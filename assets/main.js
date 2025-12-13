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

// Home Hero Slider
const heroSwiper = new Swiper(".home-hero-swiper", {
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

// Testimonial Slider (Component Scoped)
const testimonialSwiper = new Swiper(".testimonial-swiper", {
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

// Image Slider
const imageSlider = new Swiper(".image-slider", {
  loop: true,
  slidesPerView: 3,
  spaceBetween: 16,
  pagination: {
    el: ".image-slider .swiper-pagination",
    clickable: true,
  },
  speed: 10000,
  autoplay: {
    delay: 4000, // ⏱ 4 seconds
    disableOnInteraction: false, // keep autoplay after user nav
  },
  navigation: {
    nextEl: ".image-slider .swiper-button-next",
    prevEl: ".image-slider .swiper-button-prev",
  },
  scrollbar: {
    el: ".image-slider .swiper-scrollbar",
    draggable: true,
  },
  breakpoints: {
    0: { slidesPerView: 1 },
    768: { slidesPerView: 2 },
    1024: { slidesPerView: 3 },
  },
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
    console.log("Modal trigger type:", type);
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
      threshold: 0.2,
    }
  );

  cards.forEach((card) => observer.observe(card));
});
