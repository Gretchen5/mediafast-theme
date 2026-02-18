<?php
/**
 * Page-level schema driven by ACF "Schema Settings"
 */

if ( is_admin() ) return;
if ( ! is_singular('page') ) return;
if ( ! function_exists('get_field') ) return;

$enabled = (bool) get_field('schema_enable');
if ( ! $enabled ) return;

$type = (string) get_field('schema_type');
$type = $type ? $type : 'service';

$title = trim((string) get_field('schema_name'));
$title = $title !== '' ? $title : get_the_title();

$desc = trim((string) get_field('schema_description'));
if ( $desc === '' ) {
  $excerpt = get_the_excerpt();
  $desc = $excerpt ? wp_strip_all_tags($excerpt) : wp_strip_all_tags(get_post_field('post_content', get_the_ID()));
  $desc = trim($desc);
  if ( strlen($desc) > 280 ) {
    $desc = mb_substr($desc, 0, 277) . '...';
  }
}

// Provider ID for Service schema (references Yoast's Organization entity)
// Update this if Yoast uses a different @id value
$provider_id = trailingslashit(home_url('/')) . '#organization';

if ( $type === 'faq' ) {

  $items = get_field('schema_faq_items');
  if ( empty($items) || ! is_array($items) ) return;

  $main = [];
  foreach ( $items as $row ) {
    $q = isset($row['question']) ? trim((string) $row['question']) : '';
    $a = isset($row['answer']) ? trim((string) $row['answer']) : '';
    if ( $q === '' || $a === '' ) continue;

    $main[] = [
      '@type' => 'Question',
      'name'  => $q,
      'acceptedAnswer' => [
        '@type' => 'Answer',
        'text'  => wp_kses_post($a),
      ],
    ];
  }

  if ( empty($main) ) return;

  $data = [
    '@context' => 'https://schema.org',
    '@type'    => 'FAQPage',
    'mainEntity' => $main,
  ];

} else {

  // Service schema
  // Get service type (use ACF field or fallback to page title)
  $service_type = trim((string) get_field('schema_service_type'));
  if ( $service_type === '' ) {
    $service_type = get_the_title();
  }

  // Fetch FAQ items if any (to embed in Service schema)
  $faq_items = get_field('schema_faq_items');
  $faq_main = [];

  if ( ! empty($faq_items) && is_array($faq_items) ) {
    foreach ( $faq_items as $row ) {
      $q = isset($row['question']) ? trim((string) $row['question']) : '';
      $a = isset($row['answer']) ? trim((string) $row['answer']) : '';
      if ( $q === '' || $a === '' ) continue;

      $faq_main[] = [
        '@type' => 'Question',
        'name'  => $q,
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text'  => wp_kses_post($a),
        ],
      ];
    }
  }

  $data = [
    '@context' => 'https://schema.org',
    '@type'    => 'Service',
    'name'     => $title,
    'description' => $desc,
    'url'      => get_permalink(),
    'serviceType' => $service_type,
    'provider' => [
      '@id' => $provider_id,
    ],
  ];

  // Add FAQs as mainEntity if present
  if ( ! empty($faq_main) ) {
    $data['mainEntity'] = $faq_main;
  }

}

echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
