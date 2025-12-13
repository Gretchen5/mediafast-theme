import { gsap, Power2 } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', () => {
	const revealContainers = document.querySelectorAll(".reveal");

	revealContainers.forEach((container) => {
		const image = container.querySelector("img");

		const tl = gsap.timeline({
			scrollTrigger: {
				trigger: container,
				toggleActions: "play none none none"
			}
		});

		tl.set(container, { autoAlpha: 1 });
		tl.from(container, {
			duration: 1,
			xPercent: -100,
			ease: Power2.easeOut
		});
		tl.from(image, {
			duration: 1,
			xPercent: 100,
			scale: 1,
			delay: -1,
			ease: Power2.easeOut
		});
	});
});
