import Isotope from 'isotope-layout';
import imagesLoaded from 'imagesloaded';

/* ----------------------------
    Portfolio Masonry Activation
-------------------------------*/
document.addEventListener('DOMContentLoaded', () => {
	const wrapper = document.querySelector('.ag-masonary-wrapper');
	if (!wrapper) return;

	imagesLoaded(wrapper, function () {
		const grid = document.querySelector('.masonry-list');
		if (!grid) return;

		// Initialize Isotope
		const iso = new Isotope(grid, {
			itemSelector: '.col',
			percentPosition: true,
			transitionDuration: '0.7s',
			layoutMode: 'masonry',
			masonry: {
				columnWidth: '.resizer',
			},
			hiddenStyle: { opacity: 0 },
			visibleStyle: { opacity: 1 },
		});

		// Set up filtering
		const filterButtons = document.querySelectorAll('.messonry-button button');

		filterButtons.forEach((button) => {
			button.addEventListener('click', function () {
				const filterValue = this.getAttribute('data-filter');

				document
					.querySelectorAll('.messonry-button .is-checked')
					.forEach((btn) => btn.classList.remove('is-checked'));

				this.classList.add('is-checked');
				iso.arrange({ filter: filterValue });
			});
		});

		console.log('Isotope initialized');
	});
});
