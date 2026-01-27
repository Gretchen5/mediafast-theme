# Lazy Load Videos/Iframes (#12) – Implementation Summary

## What We Changed

Implemented **lazy loading** for videos and iframes below the fold, while preserving immediate loading for the homepage hero video (above the fold).

---

## Changes Made

### 1. **Content Video Block** (`template-parts/blocks/content-image-blocks/content_video_block.php`)

- **Added `loading="lazy"`** to the YouTube iframe.
- This block is typically below the fold, so lazy loading defers the iframe load until it's near the viewport.

---

### 2. **Multiple Videos Block** (`template-parts/blocks/creative-content-blocks/multiple_videos.php`)

- **Added `loading="lazy"`** to all YouTube iframes in the repeater.
- These videos are below the fold, so lazy loading improves initial page load.

---

### 3. **oEmbed Filter** (`functions.php`)

- **Updated `mediafast_oembed_filter`** to automatically add `loading="lazy"` to iframes in WordPress oembeds (YouTube, Vimeo, etc.).
- Only adds the attribute if it doesn't already exist.
- **Note:** The homepage hero video is a custom `<video>` element (not an oembed), so it's unaffected by this filter.

---

### 4. **Calendly Modal Iframe** (`assets/main.js`)

- **Added `loading="lazy"`** to the Calendly iframe created dynamically in modals.
- Since it's in a modal (not visible until opened), lazy loading is appropriate.

---

### 5. **Homepage Hero Video** (`template-parts/blocks/hero/video_hero.php`)

- **No changes** – intentionally left as-is.
- Uses `<video>` element (not iframe) with `preload="auto"` for immediate loading.
- This is the first thing visible on the homepage, so it should load immediately.

---

## What Was Already Good

- **`assets/main.js`** (lines 235, 286) already had `loading="lazy"` on dynamically created video iframes in modals. ✅

---

## How It Works

- **`loading="lazy"`** tells the browser to defer loading the iframe until it's about to enter the viewport.
- This reduces initial page load time and bandwidth usage.
- The browser automatically handles the lazy loading behavior.

---

## What Was Not Changed

- **Hero video** (`video_hero.php`) – Uses `preload="auto"` for immediate loading (correct for above-the-fold content).
- **Dynamically created iframes in `main.js`** – Already had lazy loading.

---

## Verifying

1. **Homepage hero video** – Should load immediately (no lazy loading).
2. **Content video blocks** – Should load when scrolled into view.
3. **Multiple videos block** – Should load when scrolled into view.
4. **WordPress oembeds** (if used) – Should have lazy loading automatically added.
5. **Calendly modal** – Iframe should load when modal opens.

---

## Performance Impact

- **Faster initial page load** – Below-the-fold videos don't load until needed.
- **Reduced bandwidth** – Users only load videos they actually view.
- **Better Core Web Vitals** – Improved LCP (Largest Contentful Paint) and TTI (Time to Interactive).
- **Hero video unaffected** – Above-the-fold content still loads immediately for best UX.

---

## Browser Support

- `loading="lazy"` is supported in all modern browsers (Chrome 76+, Firefox 75+, Safari 15.4+, Edge 79+).
- Older browsers will ignore the attribute and load iframes normally (graceful degradation).
