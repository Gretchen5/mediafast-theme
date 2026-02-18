/**
 * Lite YouTube Embeds
 * Replaces YouTube iframes with lightweight placeholders that load on click
 */

(function() {
  'use strict';

  /**
   * Extract YouTube video ID from embed URL
   * Supports: /embed/VIDEO_ID? or /embed/VIDEO_ID
   */
  function getYouTubeIdFromEmbedUrl(url) {
    if (!url) return null;
    
    // Match /embed/VIDEO_ID followed by ? or end of string
    const embedMatch = url.match(/\/embed\/([^?&\s]+)/);
    if (embedMatch && embedMatch[1]) {
      return embedMatch[1];
    }
    
    // Fallback: try other YouTube URL patterns
    const patterns = [
      /(?:youtube\.com\/watch\?v=|youtube\.com\/embed\/|youtube-nocookie\.com\/embed\/|youtu\.be\/)([^&\s?#]+)/,
      /^([a-zA-Z0-9_-]{11})$/ // Direct video ID
    ];

    for (const pattern of patterns) {
      const match = url.match(pattern);
      if (match && match[1]) {
        return match[1];
      }
    }
    
    return null;
  }

  /**
   * Get YouTube thumbnail URL
   */
  function getYouTubeThumbnail(videoId) {
    return `https://i.ytimg.com/vi/${videoId}/hqdefault.jpg`;
  }

  /**
   * Add autoplay parameter to URL if not present
   */
  function addAutoplayToUrl(url) {
    if (!url) return url;
    
    // Check if autoplay is already in the URL
    if (url.includes('autoplay=')) {
      // Replace existing autoplay value with 1
      return url.replace(/autoplay=[^&]*/, 'autoplay=1');
    }
    
    // Add autoplay=1
    const separator = url.includes('?') ? '&' : '?';
    return url + separator + 'autoplay=1';
  }

  /**
   * Initialize lite YouTube embeds
   */
  function initLiteYouTube() {
    const containers = document.querySelectorAll('.js-lite-youtube:not([data-initialized])');
    
    if (containers.length === 0) {
      return; // No containers to initialize
    }
    
    containers.forEach((container) => {
      const videoUrl = container.dataset.videoUrl || container.dataset.videoId;
      const videoTitle = container.dataset.videoTitle || 'Video';
      
      if (!videoUrl) {
        console.warn('Lite YouTube: Missing video URL or ID', container);
        return;
      }

      const videoId = getYouTubeIdFromEmbedUrl(videoUrl);
      
      if (!videoId) {
        console.warn('Lite YouTube: Could not extract video ID from', videoUrl);
        return;
      }

      // Mark as initialized immediately to prevent double processing
      container.dataset.initialized = 'true';
      container.dataset.videoId = videoId;

      // Check if inside .video-wrapper (which handles aspect ratio)
      const isInsideWrapper = container.closest('.video-wrapper');
      
      // Set thumbnail as background image and required styles
      const thumbnailUrl = getYouTubeThumbnail(videoId);
      container.style.setProperty('background-image', `url(${thumbnailUrl})`, 'important');
      container.style.setProperty('background-size', 'cover', 'important');
      container.style.setProperty('background-position', 'center', 'important');
      container.style.setProperty('background-repeat', 'no-repeat', 'important');
      container.style.setProperty('cursor', 'pointer', 'important');
      container.style.setProperty('overflow', 'hidden', 'important');
      container.style.setProperty('display', 'block', 'important');
      
      if (isInsideWrapper) {
        // Inside .video-wrapper: fill it completely (wrapper handles aspect ratio)
        container.style.setProperty('position', 'absolute', 'important');
        container.style.setProperty('top', '0', 'important');
        container.style.setProperty('left', '0', 'important');
        container.style.setProperty('width', '100%', 'important');
        container.style.setProperty('height', '100%', 'important');
        container.style.setProperty('padding-bottom', '0', 'important');
      } else {
        // Standalone: use padding-bottom for aspect ratio
        container.style.setProperty('position', 'relative', 'important');
        // padding-bottom should already be set via inline style or CSS
        if (!container.style.paddingBottom) {
          container.style.setProperty('padding-bottom', '56.25%', 'important');
        }
      }

      // Create play button
      const playButton = document.createElement('button');
      playButton.className = 'lite-youtube-play-button';
      playButton.setAttribute('role', 'button');
      playButton.setAttribute('aria-label', `Play video: ${videoTitle}`);
      playButton.style.cssText = `
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 68px;
        height: 48px;
        background-color: rgba(23, 35, 34, 0.9);
        border: none;
        border-radius: 14px;
        cursor: pointer;
        z-index: 1;
        transition: background-color 0.2s;
        padding: 0;
      `;

      // Play icon (SVG)
      const playIcon = document.createElement('div');
      playIcon.innerHTML = `
        <svg viewBox="0 0 68 48" style="width: 100%; height: 100%; display: block;">
          <path d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.63-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path>
          <path d="M 45,24 27,14 27,34" fill="#fff"></path>
        </svg>
      `;
      playButton.appendChild(playIcon);

      // Hover effect
      playButton.addEventListener('mouseenter', () => {
        playButton.style.backgroundColor = 'rgba(23, 35, 34, 1)';
      });
      playButton.addEventListener('mouseleave', () => {
        playButton.style.backgroundColor = 'rgba(23, 35, 34, 0.9)';
      });

      // Click handler
      const loadVideo = (e) => {
        e.preventDefault();
        e.stopPropagation();

        // Create iframe using the original video URL
        const iframe = document.createElement('iframe');
        iframe.src = addAutoplayToUrl(videoUrl);
        iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
        iframe.setAttribute('allowfullscreen', '');
        iframe.setAttribute('title', videoTitle);
        iframe.className = 'lite-youtube-iframe';

        // Replace container contents with iframe
        container.innerHTML = '';
        container.appendChild(iframe);
        container.classList.add('lite-youtube-loaded');
      };

      playButton.addEventListener('click', loadVideo);
      container.addEventListener('click', loadVideo);

      // Add play button to container
      container.appendChild(playButton);
    });
  }

  // Initialize immediately and on DOM ready
  // Try multiple times to catch content loaded at different times
  function startInit() {
    // Run immediately if DOM is ready
    if (document.readyState !== 'loading') {
      initLiteYouTube();
    }
    
    // Also run on DOMContentLoaded
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initLiteYouTube);
    }
    
    // Fallback: run after a short delay to catch late-loading content
    setTimeout(initLiteYouTube, 500);
    setTimeout(initLiteYouTube, 1000);
  }

  startInit();

  // Re-initialize for dynamically added content
  if (typeof MutationObserver !== 'undefined') {
    const observer = new MutationObserver((mutations) => {
      // Only re-init if new .js-lite-youtube elements were added
      const hasNewContainers = Array.from(mutations).some(mutation => {
        return Array.from(mutation.addedNodes).some(node => {
          if (node.nodeType === 1) { // Element node
            return node.classList && node.classList.contains('js-lite-youtube') ||
                   (node.querySelector && node.querySelector('.js-lite-youtube'));
          }
          return false;
        });
      });
      
      if (hasNewContainers) {
        setTimeout(initLiteYouTube, 50);
      }
    });
    
    if (document.body) {
      observer.observe(document.body, {
        childList: true,
        subtree: true
      });
    }
  }
})();
