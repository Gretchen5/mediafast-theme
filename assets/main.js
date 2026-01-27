// Webpack Imports
import * as bootstrap from "bootstrap";

(function () {
  "use strict";

  // Focus input if Searchform is empty
  [].forEach.call(document.querySelectorAll(".search-form"), (el) => {
    el.addEventListener("submit", function (e) {
      var search = el.querySelector("input");
      if (search.value.length < 1) {
        e.preventDefault();
        search.focus();
      }
    });
  });

  // Initialize Popovers: https://getbootstrap.com/docs/5.0/components/popovers
  var popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="popover"]')
  );
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl, {
      trigger: "focus",
    });
  });
})();

// Sliders

import Swiper from "swiper";
import { Navigation, Pagination, Autoplay, EffectFade } from "swiper/modules";

import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/effect-fade";

Swiper.use([Navigation, Pagination, Autoplay, EffectFade]);

// Home Hero Slider - Only initialize if element exists
document.addEventListener("DOMContentLoaded", () => {
  const heroSwiperEl = document.querySelector(".home-hero-swiper");
  if (heroSwiperEl) {
    new Swiper(".home-hero-swiper", {
      modules: [Navigation, Pagination, Autoplay, EffectFade],
      slidesPerView: 1,
      loop: true,
      effect: "fade",
      fadeEffect: { crossFade: true },
      autoplay: {
        delay: 2000,
      },
      allowTouchMove: false,
      navigation: {
        nextEl: ".slider-one-slide-next-1",
        prevEl: ".slider-one-slide-prev-1",
      },
      pagination: {
        el: ".swiper-pagination-bullets",
        clickable: true,
      },
      keyboard: {
        enabled: true,
        onlyInViewport: true,
      },
      speed: 2000,
    });
  }
});

// Testimonial Slider - Only initialize if element exists
document.addEventListener("DOMContentLoaded", () => {
  const testimonialSwiperEl = document.querySelector(".testimonial-swiper");
  if (testimonialSwiperEl) {
    new Swiper(".testimonial-swiper", {
      slidesPerView: 3,
      loopedSlides: 20,
      spaceBetween: 30,
      slidesPerGroup: 1,
      direction: "horizontal",
      loop: true,
      loopFillGroupWithBlank: true,
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".testimonial-swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".testimonial-swiper-button-next",
        prevEl: ".testimonial-swiper-button-prev",
      },
      scrollbar: {
        el: ".testimonial-swiper-scrollbar",
        draggable: true,
      },
      breakpoints: {
        0: { slidesPerView: 1 },
        768: { slidesPerView: 2 },
        1024: { slidesPerView: 3 },
      },
    });
  }
});

// Image Slider - Optimized for performance
// Only initialize if element exists (prevents errors if block not on page)
document.addEventListener("DOMContentLoaded", () => {
  const imageSliderEl = document.querySelector(".image-slider");
  if (imageSliderEl) {
    const imageSlider = new Swiper(".image-slider", {
      modules: [Navigation, Pagination, Autoplay],
      loop: true,
      loopAdditionalSlides: 2, // Add extra slides for seamless looping
      loopedSlides: 4, // Number of slides to duplicate for loop
      slidesPerView: 4,
      spaceBetween: 8, // Reduced spacing by half
      speed: 600, // Smooth transition
      autoplay: {
        delay: 2000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true, // Pause on hover for better UX
      },
      pagination: {
        el: ".image-slider .swiper-pagination",
        clickable: true,
        dynamicBullets: false, // Disabled to prevent duplicate dots
      },
      navigation: {
        nextEl: ".image-slider .swiper-button-next",
        prevEl: ".image-slider .swiper-button-prev",
      },
      keyboard: {
        enabled: true,
        onlyInViewport: true,
      },
      watchOverflow: true, // Disable if not enough slides
      breakpoints: {
        0: {
          slidesPerView: 1, // 1 on very small screens (500px and smaller)
          spaceBetween: 5,
        },
        500: {
          slidesPerView: 2, // 2 on small mobile
          spaceBetween: 5,
        },
        576: {
          slidesPerView: 3, // 3 on small tablets
          spaceBetween: 6,
        },
        768: {
          slidesPerView: 4, // 4 on tablets and desktop
          spaceBetween: 8,
        },
      },
    });
  }
});

// Sliding Cards Slider - Optimized for performance
document.addEventListener("DOMContentLoaded", () => {
  const slidingCardsEl = document.querySelector(".sliding-cards-slider");
  if (slidingCardsEl) {
    const slidingCards = new Swiper(".sliding-cards-slider", {
      modules: [Pagination, Autoplay],
      loop: true,
      slidesPerView: 'auto', // Use auto to respect CSS-defined widths
      spaceBetween: 15,
      speed: 1500, // Slower transition for soft stop
      autoplay: {
        delay: 6000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      keyboard: {
        enabled: true,
        onlyInViewport: true,
      },
      watchOverflow: true,
      breakpoints: {
        0: {
          slidesPerView: 1, // Show only 1 slide on mobile, no peek
          spaceBetween: 20,
        },
        768: {
          slidesPerView: 'auto', // Use auto to respect CSS-defined widths
          spaceBetween: 30,
        },
        1401: {
          slidesPerView: 'auto', // Use auto to respect CSS-defined widths
          spaceBetween: 15, // Reduced spacing between slides
        },
      },
    });
  }
});

// Animations
import "./reveal.js";
import "animate.css";

//   import './magiccursor.js';
//   import './mousecursor.css';
//   import './portfolio.js';

//   Site-wide Media Modal
document.addEventListener("DOMContentLoaded", function () {
  document.addEventListener("click", function (e) {
    const trigger = e.target.closest('[data-bs-toggle="modal"][data-type]');
    if (!trigger) return;

    const mediaModal = document.getElementById("mediaModal");
    const mediaContainer = document.getElementById("modalMediaContainer");
    if (!mediaModal || !mediaContainer) return;

    const type = trigger.getAttribute("data-type");
    const title = trigger.getAttribute("data-title") || "";
    const desc = trigger.getAttribute("data-description") || "";
    const video = trigger.getAttribute("data-video") || "";
    const image = trigger.getAttribute("data-image") || "";
    const formId = trigger.getAttribute("data-form-id") || "";

    let contentHTML = "";
    if (title) contentHTML += `<h2 class="mb-2">${title}</h2>`;
    if (desc && type !== "calendly") {
      contentHTML += `<div class="mb-4">${desc}</div>`;
    }

    if (type === "image") {
      contentHTML += `<img src="${image}" class="img-fluid rounded" alt="">`;
    } else if (type === "video") {
      contentHTML += `<div class="ratio ratio-16x9"><iframe class="media-video-iframe" src="${video}" frameborder="0" allowfullscreen loading="lazy"></iframe></div>`;
    } else if (type === "form") {
      const form = document.getElementById(formId);
      contentHTML += form ? form.innerHTML : "<p>Form not found</p>";
    } else if (type === "image_video") {
      contentHTML += `
				<div class="mb-3 btn-group" role="group">
					<button type="button" class="btn btn-outline-secondary btn-sm" id="showImage">View Image</button>
					<button type="button" class="btn btn-outline-primary btn-sm" id="showVideo">Watch Video</button>
				</div>
				<div id="mediaToggleContainer">
					<img src="${image}" class="img-fluid rounded" alt="">
				</div>
			`;
    } else if (type === "calendly") {
      const calendlyUrl = trigger.getAttribute("data-calendly-url");
      if (calendlyUrl) {
        contentHTML += `<div class="calendly-wrapper">
					<iframe id="calendlyIframe" src="${calendlyUrl}" width="100%" height="800" frameborder="0"></iframe>
				</div>`;

        if (typeof wc_iframe_ypbib === "function") {
          wc_iframe_ypbib(calendlyUrl, "calendly.com");
        }
      }
    }

    const modalDialog = document.querySelector("#mediaModal .modal-dialog");

    // Remove existing size classes
    modalDialog.classList.remove("modal-sm", "modal-lg", "modal-xl");

    // Add size class based on type
    if (type === "calendly") {
      modalDialog.classList.add("modal-xl"); // or 'modal-md' if you want it smaller
    } else if (type === "image" || type === "video" || type === "image_video") {
      modalDialog.classList.add("modal-lg");
    }

    mediaContainer.innerHTML = contentHTML;

    // Toggle logic must be set after modal content is injected
    if (type === "image_video") {
      document.getElementById("showImage")?.addEventListener("click", () => {
        document.getElementById(
          "mediaToggleContainer"
        ).innerHTML = `<img src="${image}" class="img-fluid rounded" alt="">`;
      });
      document.getElementById("showVideo")?.addEventListener("click", () => {
        document.getElementById(
          "mediaToggleContainer"
        ).innerHTML = `<div class="ratio ratio-16x9"><iframe class="media-video-iframe" src="${video}" frameborder="0" allowfullscreen loading="lazy"></iframe></div>`;
      });
    }
  });

  // Stop the video when the modal is closed and remove focus from the modal before aria-hidden is set to true.

  const modal = document.getElementById("mediaModal");

  modal.addEventListener("hide.bs.modal", () => {
    if (document.activeElement) {
      document.activeElement.blur();
    }
    document.body.focus();
  });

  modal.addEventListener("hidden.bs.modal", () => {
    // Stop all video iframes
    const iframes = document.querySelectorAll(".media-video-iframe");
    iframes.forEach((iframe) => {
      iframe.src = "";
    });
  });
});

//  Capturing the page visit context (URL, referrer, search params, and hash) and storing it in a global variable ($wc_leads) — likely for analytics, lead tracking, or session tagging

var $wc_load = function (a) {
  return JSON.parse(JSON.stringify(a));
};

var $wc_leads = $wc_leads || {
  doc: {
    url: $wc_load(document.URL),
    ref: $wc_load(document.referrer),
    search: $wc_load(location.search),
    hash: $wc_load(location.hash),
  },
};

jQuery(document).ready(function ($) {
  $("#accordion_search_bar").on("input", function () {
    const searchValue = $(this).val().toLowerCase().trim();
    const searchWords = searchValue.split(" ").join("|"); // Creates "word1|word2|word3"
    const regex = new RegExp(`\\b(${searchWords})\\b`, "gi"); // Matches whole words

    $(".accordion-item").each(function () {
      const headerText = $(this).find(".accordion-header").text().toLowerCase();
      const bodyText = $(this).find(".accordion-body").text().toLowerCase();

      // Check if the header or body matches the regex
      if (regex.test(headerText) || regex.test(bodyText)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });
});

// Light Version of AOS

document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll("[data-animate]");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("animate-in");
          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.1,
    }
  );

  cards.forEach((card) => observer.observe(card));
});

// Stats rotator (lightweight, no theme animations)
document.addEventListener("DOMContentLoaded", () => {
  const rotators = document.querySelectorAll(".stats-rotator[data-stats]");
  rotators.forEach((el) => {
    let stats;
    try {
      stats = JSON.parse(el.getAttribute("data-stats")) || [];
    } catch (e) {
      stats = [];
    }
    if (!Array.isArray(stats) || stats.length < 2) return;

    const textEl = el.querySelector(".stats-text") || el;
    let index = 0;
    const rotate = () => {
      index = (index + 1) % stats.length;
      el.classList.add("is-fading");
      setTimeout(() => {
        textEl.textContent = stats[index];
        el.classList.remove("is-fading");
      }, 300); // Match CSS transition duration
    };

    const interval = setInterval(rotate, 4000); // Slowed from 3000ms to 6000ms (6 seconds)

    // Cleanup if element removed
    const observer = new MutationObserver(() => {
      if (!document.body.contains(el)) {
        clearInterval(interval);
        observer.disconnect();
      }
    });
    observer.observe(document.body, { childList: true, subtree: true });
  });
});
