<?php
/**
 * Sitewide Organization / LocalBusiness schema (JSON-LD).
 *
 * STATUS: DISABLED — commented out in functions.php to avoid duplicate schema
 * with Yoast SEO, which already outputs Organization / WebSite schema sitewide.
 *
 * If Yoast is removed, re-enable by uncommenting the add_action block in
 * functions.php (see the "Schema" section around line 1152).
 *
 * Page-specific schema (Organization, VideoObject, Product, AggregateRating,
 * Service, FAQ) is handled in template-parts/schema/page-schema.php.
 *
 * Full LocalBusiness data is in page-schema.php on the Contact Us page
 * (wrapped in AggregateRating as itemReviewed).
 *
 * -----------------------------------------------------------------------
 * Reference data — update here if details change so page-schema.php can
 * import from a single source of truth in the future.
 * -----------------------------------------------------------------------
 *
 * Organization:
 *   @id    : https://mediafast.com#Organization
 *   name   : MediaFast
 *   url    : https://mediafast.com
 *   logo   : https://mediafast.com/wp-content/uploads/MediaFast_WO_logo_Horz_Color-opt.png
 *              width=500, height=43
 *
 * LocalBusiness:
 *   name      : MediaFast
 *   legalName : Media Fast, LC.
 *   telephone : +1-888-756-8890
 *   email     : sales@mediafast.com
 *   url       : https://mediafast.com/
 *   address   : 1396 W 200 S St. Building 1, Unit C, Lindon, Utah 84042, US
 *   hasMap    : https://goo.gl/maps/VBMFkawaH3w1iCJs9
 */

// No active output. This file is included only as a reference.
// All schema is handled in template-parts/schema/page-schema.php.
