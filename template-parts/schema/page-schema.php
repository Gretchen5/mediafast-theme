<?php
/**
 * Page-level JSON-LD schema.
 *
 * Loaded via wp_head (priority 99) from functions.php for all singular pages.
 *
 * Schema by page / condition:
 *   Home page        → Organization + VideoObject* (+ Service if schema_enable = true in ACF)
 *   About Us         → Organization                (+ Service if schema_enable = true in ACF)
 *   Pricing page     → VideoObject*                (+ Service if schema_enable = true in ACF)
 *   Product pages    → VideoObject* + Product      (ACF schema_type = 'product')
 *   Contact Us page  → AggregateRating (itemReviewed: LocalBusiness)
 *   All other pages  → Service or FAQ              (ACF schema_enable = true)
 *
 * * VideoObject schema is generated dynamically by video-schema.php.
 *   It scans post content and ACF meta for YouTube video IDs, fetches metadata
 *   via the YouTube Data API v3 on save_post (admin only), and caches the result.
 *   Save each page in WP admin once after deployment to populate the cache.
 *
 * Multiple schemas on the same page are valid JSON-LD. The ACF Service/FAQ
 * block fires independently on any page where schema_enable = true, including
 * pages that also output a hardcoded schema (e.g. the home page).
 */

if ( is_admin() ) return;
if ( ! is_singular( 'page' ) ) return;
if ( ! function_exists( 'get_field' ) ) return;

// Read schema_type once; used by VideoObject, Product, and Service/FAQ blocks.
$schema_type = (string) get_field( 'schema_type' );
$schema_type = $schema_type ?: 'service';

$is_product_page = ( $schema_type === 'product' );

// ---------------------------------------------------------------------------
// 1. Organization — Home page and About Us page
// ---------------------------------------------------------------------------
if ( is_front_page() || is_page( 'about-us' ) ) {
	$org = [
		'@context' => 'https://schema.org',
		'@type'    => 'Organization',
		'@id'      => 'https://mediafast.com#Organization',
		'name'     => 'MediaFast',
		'url'      => 'https://mediafast.com',
		'sameAs'   => [],
		'logo'     => [
			'@type'  => 'ImageObject',
			'url'    => 'https://mediafast.com/wp-content/uploads/MediaFast_WO_logo_Horz_Color-opt.png',
			'width'  => 500,
			'height' => 43,
		],
	];
	echo '<script type="application/ld+json">'
		. wp_json_encode( $org, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
		. '</script>' . "\n";
}

// ---------------------------------------------------------------------------
// 2. VideoObject — auto-detected from page content and ACF fields.
//    One block is output per YouTube video found on the page.
//    Requires MEDIAFAST_YOUTUBE_API_KEY in wp-config.php.
//    Data is cached on save_post; save the page in WP admin to populate.
// ---------------------------------------------------------------------------
if ( function_exists( 'mediafast_output_video_schema' ) ) {
	mediafast_output_video_schema( get_the_ID() );
}

// ---------------------------------------------------------------------------
// 3. Product — Product pages only (ACF schema_type = 'product')
// ---------------------------------------------------------------------------
if ( $is_product_page ) {
	$product = [
		'@context'        => 'https://schema.org',
		'@type'           => 'Product',
		'name'            => 'Video Brochure',
		'description'     => 'A Video Brochure made by MediaFast will deliver the best ROI possible.',
		'image'           => 'https://mediafast.com/wp-content/uploads/RENUVION-2.jpg',
		'aggregateRating' => [
			'@type'       => 'AggregateRating',
			'ratingValue' => 4.9,
			'ratingCount' => 164,
		],
	];
	echo '<script type="application/ld+json">'
		. wp_json_encode( $product, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
		. '</script>' . "\n";
}

// ---------------------------------------------------------------------------
// 4. AggregateRating (itemReviewed: LocalBusiness) — Contact Us page only
//    Note: sitewide-localbusiness.php is disabled; this is the only place
//    LocalBusiness schema appears, and only on the Contact Us page.
// ---------------------------------------------------------------------------
if ( is_page( 'contact-us' ) ) {
	$area_served = [
		'United States', 'Canada', 'Alabama', 'Alaska', 'American Samoa', 'Arizona',
		'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware',
		'District of Columbia', 'Florida', 'Georgia', 'Guam', 'Hawaii', 'Idaho',
		'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine',
		'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Minor Outlying Islands',
		'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
		'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
		'Northern Mariana Islands', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania',
		'Puerto Rico', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee',
		'Texas', 'U.S. Virgin Islands', 'Utah', 'Vermont', 'Virginia', 'Washington',
		'West Virginia', 'Wisconsin', 'Wyoming',
	];

	$contact_schema = [
		'@context'    => 'https://schema.org',
		'@type'       => 'AggregateRating',
		'ratingValue' => 5.0,
		'bestRating'  => 5,
		'worstRating' => 1,
		'ratingCount' => 164,
		'itemReviewed' => [
			'@type'              => 'LocalBusiness',
			'name'               => 'MediaFast',
			'image'              => 'https://mediafast.com/wp-content/uploads/logo.png',
			'logo'               => [
				'@type'      => 'ImageObject',
				'caption'    => 'MediaFast Logo',
				'url'        => 'https://mediafast.com/wp-content/uploads/logo.png',
				'contentUrl' => 'https://mediafast.com/wp-content/uploads/logo.png',
			],
			'telephone'          => '+1-888-756-8890',
			'priceRange'         => '$$$',
			'legalName'          => 'Media Fast, LC.',
			'currenciesAccepted' => 'USD',
			'openingHours'       => 'mo-fri 09:00-18:00',
			'paymentAccepted'    => 'Cash, Credit Card, Check',
			'email'              => 'sales@mediafast.com',
			'hasMap'             => 'https://goo.gl/maps/VBMFkawaH3w1iCJs9',
			'url'                => 'https://mediafast.com/',
			'areaServed'         => $area_served,
			'address'            => [
				'@type'           => 'PostalAddress',
				'streetAddress'   => '1396 W 200 S St. Building 1, Unit C',
				'addressLocality' => 'Lindon',
				'addressRegion'   => 'Utah',
				'postalCode'      => '84042',
				'addressCountry'  => 'US',
			],
		],
	];
	echo '<script type="application/ld+json">'
		. wp_json_encode( $contact_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
		. '</script>' . "\n";
}

// ---------------------------------------------------------------------------
// 5. ACF-driven Service / FAQ schema
//    Fires on any page where schema_enable = true AND schema_type is service
//    or faq. Skipped for schema_type = 'product' because those pages get
//    hardcoded Product + VideoObject schemas above; outputting Service here
//    too would be semantically incorrect.
// ---------------------------------------------------------------------------
$enabled = (bool) get_field( 'schema_enable' );
if ( ! $enabled ) return;
if ( $is_product_page ) return;

$title = trim( (string) get_field( 'schema_name' ) );
$title = $title !== '' ? $title : get_the_title();

$desc = trim( (string) get_field( 'schema_description' ) );
if ( $desc === '' ) {
	$excerpt = get_the_excerpt();
	$desc    = $excerpt
		? wp_strip_all_tags( $excerpt )
		: wp_strip_all_tags( get_post_field( 'post_content', get_the_ID() ) );
	$desc = trim( $desc );
	if ( strlen( $desc ) > 280 ) {
		$desc = mb_substr( $desc, 0, 277 ) . '...';
	}
}

// References Yoast's Organization entity; update if @id differs.
$provider_id = trailingslashit( home_url( '/' ) ) . '#organization';

if ( $schema_type === 'faq' ) {

	$items = get_field( 'schema_faq_items' );
	if ( empty( $items ) || ! is_array( $items ) ) return;

	$main = [];
	foreach ( $items as $row ) {
		$q = isset( $row['question'] ) ? trim( (string) $row['question'] ) : '';
		$a = isset( $row['answer'] )   ? trim( (string) $row['answer'] )   : '';
		if ( $q === '' || $a === '' ) continue;
		$main[] = [
			'@type'          => 'Question',
			'name'           => $q,
			'acceptedAnswer' => [
				'@type' => 'Answer',
				'text'  => wp_kses_post( $a ),
			],
		];
	}
	if ( empty( $main ) ) return;

	$data = [
		'@context'   => 'https://schema.org',
		'@type'      => 'FAQPage',
		'mainEntity' => $main,
	];

} else {

	$service_type = trim( (string) get_field( 'schema_service_type' ) );
	if ( $service_type === '' ) {
		$service_type = get_the_title();
	}

	$faq_items = get_field( 'schema_faq_items' );
	$faq_main  = [];
	if ( ! empty( $faq_items ) && is_array( $faq_items ) ) {
		foreach ( $faq_items as $row ) {
			$q = isset( $row['question'] ) ? trim( (string) $row['question'] ) : '';
			$a = isset( $row['answer'] )   ? trim( (string) $row['answer'] )   : '';
			if ( $q === '' || $a === '' ) continue;
			$faq_main[] = [
				'@type'          => 'Question',
				'name'           => $q,
				'acceptedAnswer' => [
					'@type' => 'Answer',
					'text'  => wp_kses_post( $a ),
				],
			];
		}
	}

	$data = [
		'@context'    => 'https://schema.org',
		'@type'       => 'Service',
		'name'        => $title,
		'description' => $desc,
		'url'         => get_permalink(),
		'serviceType' => $service_type,
		'provider'    => [ '@id' => $provider_id ],
	];
	if ( ! empty( $faq_main ) ) {
		$data['mainEntity'] = $faq_main;
	}
}

echo '<script type="application/ld+json">'
	. wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
	. '</script>' . "\n";
