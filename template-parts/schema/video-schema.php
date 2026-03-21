<?php
/**
 * YouTube VideoObject schema — auto-detected from page content and ACF fields.
 *
 * HOW IT WORKS
 * ─────────────────────────────────────────────────────────────────────────────
 * 1. On save_post (admin only): scans the page's post_content and all ACF meta
 *    for YouTube video IDs, then makes one batched call to the YouTube Data
 *    API v3 for any IDs not already cached. Results are stored as WP transients
 *    so the front-end never makes an API call.
 *
 * 2. On wp_head (via page-schema.php): reads from cache and outputs one
 *    VideoObject JSON-LD block per video — zero API calls, zero performance hit.
 *
 * SETUP
 * ─────────────────────────────────────────────────────────────────────────────
 * Add your YouTube Data API v3 key to wp-config.php:
 *
 *   define( 'MEDIAFAST_YOUTUBE_API_KEY', 'YOUR_API_KEY_HERE' );
 *
 * Get a key at: https://console.cloud.google.com/ → APIs → YouTube Data API v3
 *
 * AFTER DEPLOYMENT
 * ─────────────────────────────────────────────────────────────────────────────
 * Open and save each page in the WP admin to trigger the save_post hook and
 * populate the cache. VideoObject schema will appear on the front-end immediately
 * after the first save of each page.
 *
 * CACHE
 * ─────────────────────────────────────────────────────────────────────────────
 * Per-post ID list : mediafast_yt_ids_{post_id}  — 30 days
 * Per-video data   : mediafast_yt_{video_id}     — 30 days
 *
 * To manually bust the cache for a post, re-save it in the WP admin or delete
 * the transient: delete_transient( 'mediafast_yt_ids_{post_id}' );
 */

// ---------------------------------------------------------------------------
// Extract all unique YouTube video IDs from an arbitrary string.
// Covers: lite-youtube, iframe embeds, watch URLs, short URLs, Shorts, oEmbed.
// ---------------------------------------------------------------------------
function mediafast_extract_youtube_ids( $text ) {
	if ( empty( $text ) || ! is_string( $text ) ) {
		return [];
	}

	$patterns = [
		'/\bvideoid=["\']([a-zA-Z0-9_-]{11})["\']/',
		'/youtube(?:-nocookie)?\.com\/embed\/([a-zA-Z0-9_-]{11})/',
		'/youtube(?:-nocookie)?\.com\/shorts\/([a-zA-Z0-9_-]{11})/',
		'/youtube(?:-nocookie)?\.com\/watch\?(?:[^"\'>\s]*?&(?:amp;)?)?v=([a-zA-Z0-9_-]{11})/',
		'/youtu\.be\/([a-zA-Z0-9_-]{11})/',
	];

	$ids = [];
	foreach ( $patterns as $pattern ) {
		if ( preg_match_all( $pattern, $text, $matches ) ) {
			foreach ( $matches[1] as $id ) {
				$ids[ $id ] = true; // keys deduplicate automatically
			}
		}
	}

	return array_keys( $ids );
}

// ---------------------------------------------------------------------------
// Get all YouTube video IDs present in a post's content and ACF meta.
// ---------------------------------------------------------------------------
function mediafast_get_post_youtube_ids( $post_id ) {
	$sources = [];

	// Gutenberg blocks, classic editor embeds, shortcodes
	$sources[] = (string) get_post_field( 'post_content', $post_id );

	// All ACF and custom meta values (URL fields, wysiwyg, text containing embeds)
	$all_meta = get_post_meta( $post_id );
	if ( is_array( $all_meta ) ) {
		$sources[] = serialize( $all_meta );
	}

	return mediafast_extract_youtube_ids( implode( ' ', $sources ) );
}

// ---------------------------------------------------------------------------
// Batch-fetch YouTube metadata and cache each video individually.
// Called from save_post — never from the front-end.
// ---------------------------------------------------------------------------
function mediafast_cache_youtube_videos( array $video_ids ) {
	if ( empty( $video_ids ) ) {
		return;
	}

	$api_key = defined( 'MEDIAFAST_YOUTUBE_API_KEY' ) ? MEDIAFAST_YOUTUBE_API_KEY : '';
	if ( $api_key === '' ) {
		return;
	}

	// Only fetch IDs that are not already cached.
	$uncached = array_filter( $video_ids, function ( $id ) {
		return get_transient( 'mediafast_yt_' . $id ) === false;
	} );

	if ( empty( $uncached ) ) {
		return;
	}

	// YouTube Data API v3 allows up to 50 IDs per request.
	foreach ( array_chunk( array_values( $uncached ), 50 ) as $chunk ) {
		$url = add_query_arg(
			[
				'id'   => implode( ',', $chunk ),
				'part' => 'snippet',
				'key'  => $api_key,
			],
			'https://www.googleapis.com/youtube/v3/videos'
		);

		$response = wp_remote_get( $url, [ 'timeout' => 10 ] );

		if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) {
			continue;
		}

		$body = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( empty( $body['items'] ) ) {
			continue;
		}

		foreach ( $body['items'] as $item ) {
			$id      = $item['id'];
			$snippet = $item['snippet'];

			// Prefer the highest-quality thumbnail available.
			$thumb = $snippet['thumbnails']['maxres']['url']
				?? $snippet['thumbnails']['standard']['url']
				?? $snippet['thumbnails']['high']['url']
				?? "https://i.ytimg.com/vi/{$id}/hqdefault.jpg";

			$data = [
				'name'         => $snippet['title'],
				'description'  => mb_substr( wp_strip_all_tags( $snippet['description'] ), 0, 500 ),
				'thumbnailUrl' => $thumb,
				'uploadDate'   => $snippet['publishedAt'], // ISO 8601, e.g. 2021-01-27T00:34:30.000Z
				'contentUrl'   => "https://www.youtube.com/watch?v={$id}",
			];

			set_transient( 'mediafast_yt_' . $id, $data, 30 * DAY_IN_SECONDS );
		}
	}
}

// ---------------------------------------------------------------------------
// save_post hook — pre-caches video IDs and their API data in the admin.
// This is the only place we call the YouTube API.
// ---------------------------------------------------------------------------
add_action(
	'save_post',
	function ( $post_id, $post ) {
		if ( wp_is_post_autosave( $post_id ) ) {
			return;
		}
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}
		if ( $post->post_type !== 'page' ) {
			return;
		}
		if ( $post->post_status === 'trash' ) {
			return;
		}

		$ids = mediafast_get_post_youtube_ids( $post_id );

		// Detect IDs that were previously cached for this post but are no longer
		// present. Delete their per-video transients only if no other page shares
		// the same video — checked by scanning all pages' ID lists.
		$previous_ids = get_transient( 'mediafast_yt_ids_' . $post_id );
		if ( is_array( $previous_ids ) && ! empty( $previous_ids ) ) {
			$removed = array_diff( $previous_ids, $ids );
			if ( ! empty( $removed ) ) {
				// Build a set of all video IDs still in use across other pages.
				$all_pages = get_posts( [
					'post_type'      => 'page',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'fields'         => 'ids',
					'exclude'        => [ $post_id ],
				] );

				$in_use = [];
				foreach ( $all_pages as $other_id ) {
					$other_ids = get_transient( 'mediafast_yt_ids_' . $other_id );
					if ( is_array( $other_ids ) ) {
						foreach ( $other_ids as $vid ) {
							$in_use[ $vid ] = true;
						}
					}
				}

				// Only delete the transient if no other page still uses that video.
				foreach ( $removed as $orphan_id ) {
					if ( ! isset( $in_use[ $orphan_id ] ) ) {
						delete_transient( 'mediafast_yt_' . $orphan_id );
					}
				}
			}
		}

		// Cache the list of video IDs for this post (even if empty, to avoid live scans).
		set_transient( 'mediafast_yt_ids_' . $post_id, $ids, 30 * DAY_IN_SECONDS );

		// Batch-fetch and cache metadata for any uncached video IDs.
		mediafast_cache_youtube_videos( $ids );
	},
	10,
	2
);

// ---------------------------------------------------------------------------
// Output VideoObject JSON-LD blocks for the current page.
// Reads entirely from cache — zero API calls on the front-end.
// Called from page-schema.php.
// ---------------------------------------------------------------------------
function mediafast_output_video_schema( $post_id ) {
	if ( ! defined( 'MEDIAFAST_YOUTUBE_API_KEY' ) || MEDIAFAST_YOUTUBE_API_KEY === '' ) {
		return;
	}

	// Get the cached list of video IDs for this post.
	// Returns false if the page hasn't been saved since this feature was deployed.
	$ids = get_transient( 'mediafast_yt_ids_' . $post_id );

	if ( $ids === false || ! is_array( $ids ) || empty( $ids ) ) {
		return;
	}

	foreach ( $ids as $video_id ) {
		$data = get_transient( 'mediafast_yt_' . $video_id );

		if ( ! is_array( $data ) ) {
			continue; // Data missing from cache; will appear after next page save.
		}

		$schema = [
			'@context'     => 'https://schema.org',
			'@type'        => 'VideoObject',
			'name'         => $data['name'],
			'description'  => $data['description'],
			'thumbnailUrl' => $data['thumbnailUrl'],
			'uploadDate'   => $data['uploadDate'],
			'contentUrl'   => $data['contentUrl'],
		];

		echo '<script type="application/ld+json">'
			. wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
			. '</script>' . "\n";
	}
}
