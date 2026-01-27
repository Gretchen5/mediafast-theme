# CSS Optimization - Implementation Summary

## What We Changed

Added **CSS minification** to the production build so `main.css` is minified when you run `npm run build`.

## Changes Made

### 1. **css-minimizer-webpack-plugin** ✅
**Location:** `package.json`

- Added `css-minimizer-webpack-plugin` to `devDependencies`.

### 2. **Webpack production config** ✅
**Location:** `webpack.config.js`

- Required `CssMinimizerPlugin`.
- In **production only** (`npm run build`), added an `optimization` override that:
  - Keeps existing wp-scripts `optimization` (e.g. `splitChunks`, `concatenateModules`).
  - Keeps existing minimizers (e.g. TerserPlugin for JS).
  - Adds `CssMinimizerPlugin` so CSS is minified.

**Result:** Production builds now minify both JavaScript (Terser) and CSS (CssMinimizerPlugin).

## What This Does

- **Development (`npm run watch`):** CSS is **not** minified. Easier to debug.
- **Production (`npm run build`):** CSS **is** minified. Smaller `main.css`, faster loads.

## Setup Required

Install the new dependency, then build:

```bash
npm install
npm run build
```

If `css-minimizer-webpack-plugin` is not installed, the build will fail when it tries to load the plugin.

## Verifying

1. Run `npm run build`.
2. Open `build/main.css`.
3. Production output should be minified (single line, no comments, shortened names).

## Other CSS Optimizations (Not Implemented)

The report also mentioned:

- **PurgeCSS** – Removes unused CSS. Higher risk with WordPress (dynamic classes, ACF, etc.). Consider only with a careful safelist and testing.
- **Split CSS by page type** – Load different CSS per template. Would need conditional enqueues and more refactoring.
- **Review vendor CSS** – Manually audit `icon.css`, `responsive.css`, etc. to drop unused rules.

Those can be tackled later if you want to go further.

## Performance Impact

- **Smaller CSS** in production.
- **Fewer bytes** over the network.
- **Faster parsing** for the browser.
- **Better PageSpeed / Core Web Vitals** from reduced payload.
