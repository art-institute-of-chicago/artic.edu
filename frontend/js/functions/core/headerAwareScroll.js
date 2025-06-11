import { getOffsetTop } from '.';

const headerAwareScroll = function() {
    // Get the current URL hash
    const hash = window.location.hash;

    if (hash) {
        // Find the target element by ID
        const targetElement = document.getElementById(hash.substring(1));

        if (targetElement) {
            // Get the scroll position of the target element
            let scrollPosition = getOffsetTop(targetElement);

            const headerFeature = document.querySelectorAll('.m-article-header--digital-publication')[0];
            if (headerFeature) {
                const headerHeight = headerFeature.getBoundingClientRect().height;
                // Add the height to the scroll position
                scrollPosition -= headerHeight + 60;
            }


            // Scroll to the target element
            window.requestAnimationFrame(() => {
                window.scrollTo({
                    top: scrollPosition,
                    behavior: 'instant'
                });
            });
        }
    }
}

export default headerAwareScroll;
