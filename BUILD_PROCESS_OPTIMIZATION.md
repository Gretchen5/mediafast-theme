# Build Process Optimization (#10) – Implementation Summary

## What We Changed

Implemented **Build Process Optimization** from the Performance Report: source maps only in development, drop `console` in production, explicit tree-shaking via `sideEffects`, and kept existing CSS minification. The setup stays simple so you can keep building and iterating.

---

## Changes Made

### 1. **Source maps only in development** ✅  
**Location:** `webpack.config.js`

- Set `devtool: isProduction ? false : "cheap-module-source-map"`.
- **Development (`npm run watch`):** Source maps enabled for easier debugging.
- **Production (`npm run build`):** No source maps → smaller bundles, no debug info shipped.

### 2. **Drop `console` in production** ✅  
**Location:** `webpack.config.js`

- Required `terser-webpack-plugin` (already available via `@wordpress/scripts`).
- In **production only**, use a custom `minimizer` array:
  - **TerserPlugin** – Same general options as wp-scripts (parallel, comments, mangle reserved), plus `compress: { drop_console: true, passes: 2 }`.
  - **CssMinimizerPlugin** – Minify CSS (unchanged from prior setup).
- Replaces spreading wp-scripts’ default minimizers so we control Terser options.

**Result:** `console.log` / `console.warn` / etc. are stripped from production JS. Dev builds keep them.

### 3. **CSS minification** ✅  
**Location:** `webpack.config.js`

- Unchanged: **CssMinimizerPlugin** still runs in production.
- Production builds minify both JS (Terser) and CSS (CssMinimizer).

### 4. **Tree-shaking via `sideEffects`** ✅  
**Location:** `package.json`

- Added:
  ```json
  "sideEffects": ["*.css", "*.scss", "*.sass"]
  ```
- Tells webpack only CSS imports have side effects; JS can be tree-shaken.
- Unused JS exports can be removed in production builds.

---

## What This Does

| | Development (`npm run watch`) | Production (`npm run build`) |
|---|---|---|
| **Source maps** | Yes (`cheap-module-source-map`) | No |
| **Console** | Kept | Stripped |
| **JS minification** | No | Yes (Terser) |
| **CSS minification** | No | Yes (CssMinimizer) |
| **Tree-shaking** | Lighter | Full (with `sideEffects`) |

---

## Not Implemented (By Design)

- **Code splitting** – Report suggested considering it for large bundles. Not added so the build stays straightforward while you’re still building and changing the site. Can be revisited later (e.g. per-page or per-block chunks) if bundles grow.
- **Bundle analyzer** – You can run `WP_BUNDLE_ANALYZER=1 npm run build` (if wp-scripts supports it) to inspect bundle size when needed.

---

## Verifying

1. **Install dependencies** (if needed):
   ```bash
   npm install
   ```
2. **Production build:**
   ```bash
   npm run build
   ```
3. **Check `build/main.js`:** Minified, no `console.*` calls.
4. **Check `build/main.css`:** Minified.
5. **Development:** `npm run watch` – source maps work, `console` works in browser devtools.

---

## Performance Impact

- Smaller production JS (no source maps, no console).
- Smaller production CSS (minification).
- Better tree-shaking of unused JS.
- Dev builds remain debuggable without affecting production.

---

## If You Need `console` in Production

For rare cases (e.g. error logging), avoid `console.*` or guard it:

```javascript
if (typeof __DEV__ !== 'undefined' && __DEV__) {
  console.log('debug');
}
```

Or use a small logger that no-ops in production. Default remains: **all console stripped in production.**
