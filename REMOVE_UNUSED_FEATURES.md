# Remove Unused WordPress Features (#13) – Implementation Summary

## What We Changed

Removed **unused WordPress features** to reduce overhead and improve performance, while keeping features needed for development and functionality.

---

## Changes Made

### 1. **Disable WordPress Emojis** ✅

**Location:** `functions.php` - `mediafast_remove_unused_features()`

**Removed:**
- Emoji detection script from `wp_head`
- Emoji styles from frontend
- Emoji detection script from admin
- Emoji styles from admin
- Emoji conversion in RSS feeds
- Emoji conversion in email

**Why:** No emoji usage found in the codebase. Emoji scripts/styles add unnecessary HTTP requests and JavaScript execution.

**Impact:** 
- Removes ~2-3 HTTP requests per page
- Reduces JavaScript payload
- Slightly faster page loads

---

### 2. **Disable oEmbed Discovery Links** ✅

**Location:** `functions.php` - `mediafast_remove_unused_features()`

**Removed:**
- `wp_oembed_add_discovery_links` from `wp_head`

**Why:** These are just metadata links (`<link rel="alternate" type="application/json+oembed">`) that help external services discover embeddable content. They're not needed for embeds to work.

**Important:** **Embeds still work!** The `mediafast_oembed_filter()` function in `functions.php` handles actual embed rendering. This only removes the discovery metadata.

**Impact:**
- Removes 1-2 `<link>` tags from `<head>`
- Slightly cleaner HTML output

---

### 3. **REST API - NOT Disabled** ⚠️

**Why we kept it:**
- **Gutenberg/Block Editor** – May need REST API for block functionality
- **ACF Blocks** – Your theme uses ACF blocks (`inc/acf-blocks.php`), which may rely on REST API
- **Plugins** – Many plugins use REST API (admin, forms, etc.)
- **Development** – You're still building the site; REST API might be needed for future features
- **Admin Features** – WordPress admin uses REST API for various features

**Recommendation:** If you want to disable REST API later (after development is complete), you can add:
```php
// Disable REST API (only if not needed)
remove_action('rest_api_init', 'rest_api_default_filters', 10);
add_filter('rest_enabled', '__return_false');
add_filter('rest_jsonp_enabled', '__return_false');
```

**But wait until:**
- Site is fully developed
- You've confirmed no plugins/themes need it
- You've tested thoroughly

---

## What Was Not Changed

- **REST API** – Kept enabled for development safety
- **oEmbed functionality** – Only removed discovery links, embeds still work
- **Block Editor** – Fully functional
- **Other WordPress features** – Left as-is

---

## Verifying

1. **Emojis:** Check page source – should not see `wp-emoji-release.min.js` or emoji stylesheets
2. **oEmbed discovery:** Check `<head>` – should not see `<link rel="alternate" type="application/json+oembed">`
3. **Embeds still work:** Paste a YouTube/Vimeo URL in the editor – should still embed correctly
4. **Site functionality:** All features should work normally

---

## Performance Impact

- **Fewer HTTP requests** – Emoji scripts/styles removed
- **Smaller HTML output** – Fewer `<link>` tags in `<head>`
- **Reduced JavaScript** – No emoji detection script
- **Better Core Web Vitals** – Slightly improved TTI (Time to Interactive)

---

## Safety Notes

- **Conservative approach** – Only disabled features with zero usage found
- **Development-friendly** – REST API kept enabled for ongoing work
- **Reversible** – All changes are in one function, easy to revert if needed
- **No breaking changes** – All existing functionality preserved

---

## If You Need to Revert

To re-enable emojis or oembed discovery, simply comment out or remove the `mediafast_remove_unused_features()` function and its `add_action` call in `functions.php`.
