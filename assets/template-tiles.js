// Template Tiles – Progressive Expansion Model
document.addEventListener("DOMContentLoaded", () => {
  // Ensure data exists
  if (!window.TemplateTiles) return;

  Object.keys(window.TemplateTiles).forEach((blockId) => {
    const blockData = window.TemplateTiles[blockId];
    const blockEl = document.getElementById(blockId);
    if (!blockEl || !blockData) return;

    const tabsContainer = blockEl.querySelector(".template-tabs");
    const gridsContainer = blockEl.querySelector(".template-grids-container");
    const levelTitle = blockEl.querySelector(".template-level-title");

    /** Utility: clear element */
    function clear(el) {
      while (el.firstChild) el.removeChild(el.firstChild);
    }

    /** Renders one level of tiles (expands downward, doesn’t replace) */
    function renderTiles(items, level = 1, parentTitle = "") {
      // Remove deeper levels when navigating sideways
      const deeperLevels = Array.from(
        gridsContainer.querySelectorAll(`.template-grid-level`)
      ).filter((el) => parseInt(el.dataset.level) >= level);
      deeperLevels.forEach((el) => el.remove());

      if (!items || !items.length) return;

      // Create new level container
      const levelWrapper = document.createElement("div");
      levelWrapper.className = "template-grid-level";
      levelWrapper.dataset.level = level;

      // Optional subheading — skip for top level
      if (parentTitle && level > 1) {
        const heading = document.createElement("h3");
        heading.className = "template-subheading";
        heading.textContent = parentTitle;
        levelWrapper.appendChild(heading);
      }

      // Create grid
      const grid = document.createElement("div");
      grid.className = "template-grid";

      items.forEach((item) => {
        const tile = document.createElement("div");
        tile.className = "template-tile";

        // Image
        if (item.image) {
          const img = document.createElement("img");
          img.src = item.image;
          img.alt = item.title || "";
          img.loading = "lazy"; // ✅ Lazy-load for performance
          tile.appendChild(img);
        }

        // Title
        if (item.title) {
          const title = document.createElement("h4");
          title.textContent = item.title;
          tile.appendChild(title);
        }

        // show note if no PDF is available
        if (item.type === "placeholder") {
          const note = document.createElement("p");
          note.className = "no-pdf-note";
          note.textContent = "No PDF available for this template.";
          tile.appendChild(note);
        }

        // Click handler
        tile.addEventListener("click", () => {
          if (item.children && item.children.length) {
            renderTiles(item.children, level + 1, item.title);
          } else if (item.url) {
            window.open(item.url, "_blank");
          }
        });

        grid.appendChild(tile);
      });

      levelWrapper.appendChild(grid);
      gridsContainer.appendChild(levelWrapper);
    }

    /** Render top-level tabs */
    function renderTabs() {
      clear(tabsContainer);
      clear(gridsContainer);

      blockData.tabs.forEach((tab) => {
        const btn = document.createElement("button");
        btn.className = "template-tab-btn";
        btn.textContent = tab.label;
        btn.dataset.key = tab.key;

        btn.addEventListener("click", () => {
          // Toggle active button
          tabsContainer.querySelectorAll(".template-tab-btn").forEach((b) => {
            b.classList.remove("active");
          });
          btn.classList.add("active");

          // Clear all grids
          clear(gridsContainer);

          // Render Level 1 grid
          const grid = blockData.grids[tab.key];
          renderTiles(grid.items, 1, grid.label);

          updateLevelTitle(grid.label);
        });

        tabsContainer.appendChild(btn);
      });
    }

    /** Update section heading (Level Title) */
    function updateLevelTitle(text) {
      if (levelTitle) levelTitle.textContent = text || "";
    }

    // Initialize
    renderTabs();

    // Auto-select and open the first tab
    const firstTab = tabsContainer.querySelector(".template-tab-btn");
    if (firstTab) {
      firstTab.classList.add("active");
      const firstKey = firstTab.dataset.key;
      const firstGrid = blockData.grids[firstKey];
      if (firstGrid) {
        updateLevelTitle(firstGrid.label);
        renderTiles(firstGrid.items);
      }
    }
  });
});
