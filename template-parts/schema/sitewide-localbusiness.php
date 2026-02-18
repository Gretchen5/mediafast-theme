<?php
/**
 * Sitewide LocalBusiness / Organization schema (JSON-LD)
 * Outputs once per page load.
 */

if ( is_admin() ) return;

$home = home_url('/');
$business_id = trailingslashit($home) . '#localbusiness';

// TODO: Replace these with ACF Options fields later if you have them.
// Keep it minimal for now (valid + stable).
$data = [
  '@context' => 'https://schema.org',
  '@type'    => 'LocalBusiness',
  '@id'      => $business_id,
  'name'     => get_bloginfo('name'),
  'url'      => $home,
];

echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
