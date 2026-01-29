# Image Optimization Summary

## Overview
Optimized image delivery across the site to reduce download sizes and improve LCP (Largest Contentful Paint) performance. Estimated savings: **1,226 KiB**.

## Changes Made

### 1. Added WordPress Image Sizes (`functions.php`)
Created optimized image sizes specifically for ACF images:
- `acf-large`: 1200x1200px (max, maintains aspect ratio)
- `acf-medium`: 800x800px (max, maintains aspect ratio)
- `acf-small`: 400x400px (max, maintains aspect ratio)
- `acf-card`: 600x400px (cropped for card layouts)
- `acf-hero`: 1920x1080px (max, maintains aspect ratio)

### 2. Created Helper Function (`functions.php`)
Added `mediafast_get_optimized_image()` function that:
- Automatically uses WordPress attachment IDs when available
- Generates responsive `srcset` attributes via `wp_get_attachment_image()`
- Falls back to direct URLs for external/non-WordPress images
- Supports lazy loading and custom attributes
- Uses appropriate image sizes based on context

### 3. Updated Templates
Replaced direct `$image['url']` usage with optimized function in:

#### Content Blocks:
- ✅ `content_image_block.php` - Uses `acf-large` size
- ✅ `content_image_block_dark.php` - Optimized background image URL
- ✅ `image_slider.php` - Uses `acf-large` for slider images

#### Card Components:
- ✅ `cards.php` - Uses `acf-card` size for card images
- ✅ `cards_team.php` - Uses `acf-medium` for team member photos
- ✅ `cards_central_image.php` - Uses `acf-small` for icons, `acf-large` for central image
- ✅ `sliding_cards.php` - Uses `acf-large` for sliding card images

#### Other Components:
- ✅ `contact_us_block.php` - Uses `acf-large` for office images

## Benefits

1. **Automatic Responsive Images**: WordPress generates `srcset` attributes automatically, serving appropriately sized images based on device/viewport
2. **Reduced File Sizes**: Images are served at optimal sizes instead of full-resolution originals
3. **Better Performance**: Smaller images = faster downloads = improved LCP scores
4. **Backward Compatible**: Function falls back gracefully for non-WordPress attachments

## Usage Example

**Before:**
```php
<img src="<?php echo esc_url($image['url']); ?>" alt="..." class="img-fluid" loading="lazy" />
```

**After:**
```php
<?php echo mediafast_get_optimized_image($image, 'acf-large', array('class' => 'img-fluid')); ?>
```

## Next Steps (Optional)

1. **Regenerate Thumbnails**: Run a plugin like "Regenerate Thumbnails" to create the new image sizes for existing uploads
2. **WebP Support**: Consider adding WebP format support via a plugin or server configuration
3. **Image Compression**: Ensure uploaded images are compressed before upload (recommend tools like TinyPNG, ImageOptim)
4. **CDN Integration**: If using a CDN, ensure it supports responsive image delivery

## Files Modified

- `functions.php` - Added image sizes, helper functions (`mediafast_get_optimized_image()` and `mediafast_get_optimized_image_from_url()`)
- `header.php` - Optimized header logo
- `footer.php` - Optimized footer logos
- `template-parts/blocks/content-image-blocks/content_image_block.php`
- `template-parts/blocks/content-image-blocks/content_image_block_dark.php`
- `template-parts/blocks/cards/cards.php`
- `template-parts/blocks/cards/cards_team.php`
- `template-parts/blocks/cards/cards_central_image.php`
- `template-parts/blocks/cards/sliding_cards.php`
- `template-parts/blocks/contact-page/contact_us_block.php`
- `template-parts/blocks/testimonial/image_slider.php`
- `template-parts/blocks/testimonial/testimonial_slider.php` - Changed from 'medium' to 'acf-medium' size
- `template-parts/blocks/hero/video_hero.php` - Optimized poster image, feature card images, and about section image

## Notes

- Templates with hardcoded image URLs (e.g., `content_image_block_2_images.php`, `content_image_slider.php`) were not updated as they don't use ACF fields. These should be converted to use ACF fields for optimization.
- The helper function automatically handles both ACF array format and direct attachment IDs
- All optimized images maintain lazy loading for below-the-fold content
