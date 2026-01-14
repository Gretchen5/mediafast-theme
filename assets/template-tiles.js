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

    /** Renders one level of tiles (expands downward, doesn't replace) */
    function renderTiles(items, level = 1, parentTitle = "") {
      // Remove deeper levels when navigating sideways
      const deeperLevels = Array.from(
        gridsContainer.querySelectorAll(`.template-grid-level`)
      ).filter((el) => parseInt(el.dataset.level) >= level);
      deeperLevels.forEach((el) => el.remove());
      
      // Clear active states only from deeper levels (not the current/parent level)
      // This preserves the active state of the tile that triggered this render
      const deeperLevelElements = Array.from(
        gridsContainer.querySelectorAll(`.template-grid-level`)
      ).filter((el) => parseInt(el.dataset.level) > level);
      deeperLevelElements.forEach(levelEl => {
        levelEl.querySelectorAll('.template-tile.active').forEach(tile => {
          tile.classList.remove('active');
        });
      });

      if (!items || !items.length) return null;

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
            // Remove active class from all tiles in the same grid
            const currentGrid = tile.closest('.template-grid');
            if (currentGrid) {
              currentGrid.querySelectorAll('.template-tile').forEach(t => {
                t.classList.remove('active');
              });
            }
            
            // Add active class to clicked tile
            tile.classList.add('active');
            
            const newLevel = renderTiles(item.children, level + 1, item.title);
            // Scroll to the newly created level after rendering
            if (newLevel) {
              scrollToElement(newLevel);
            }
          } else if (item.url) {
            window.open(item.url, "_blank");
          }
        });

        grid.appendChild(tile);
      });

      levelWrapper.appendChild(grid);
      gridsContainer.appendChild(levelWrapper);
      
      // Return the level wrapper so we can scroll to it
      return levelWrapper;
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
          
          // Clear any active tile states when switching tabs
          blockEl.querySelectorAll('.template-tile.active').forEach(tile => {
            tile.classList.remove('active');
          });

          // Render Level 1 grid
          const grid = blockData.grids[tab.key];
          const newLevel = renderTiles(grid.items, 1, grid.label);

          updateLevelTitle(grid.label);
          
          // Scroll to the newly created level after rendering
          if (newLevel) {
            scrollToElement(newLevel);
          } else {
            scrollToGridsContainer();
          }
        });

        tabsContainer.appendChild(btn);
      });
    }

    /** Update section heading (Level Title) */
    function updateLevelTitle(text) {
      if (levelTitle) levelTitle.textContent = text || "";
    }

    /** Smooth scroll to grids container */
    function scrollToGridsContainer() {
      if (gridsContainer) {
        // Use requestAnimationFrame to ensure DOM is updated before scrolling
        requestAnimationFrame(() => {
          gridsContainer.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        });
      }
    }

    /** Smooth scroll to a specific element */
    function scrollToElement(element) {
      if (element) {
        // Use requestAnimationFrame to ensure DOM is updated before scrolling
        requestAnimationFrame(() => {
          element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        });
      }
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
