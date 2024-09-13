import { getOffset } from '@area17/a17-helpers';

const rangedAccordion = function(container) {

    function _toggleAccordion(event) {

        // Prevent default behavior
        event.preventDefault();

        // Get the trigger element
        let trigger = container.querySelector('.o-accordion__trigger');

        // Get the associated panel
        let panel = document.getElementById('panel_' + trigger.id);

        // Get the current scroll position
        const currentScrollY = window.scrollY;

        // Toggle the expanded state
        const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
        trigger.setAttribute('aria-expanded', !isExpanded);

        // Toggle the height of the panel
        panel.style.height = isExpanded ? '0' : 'max-content';

        // Toggle the active class on the trigger
        trigger.classList.toggle('is-active');

        // Adjust scroll position only if closing the accordion
        if (isExpanded) {
            window.scrollTo({
                top: currentScrollY,
                behavior: 'instant'
            });
        } else {
            // After expanding, ensure the current scroll position is restored
            window.scrollTo({
                top: currentScrollY,
                behavior: 'instant'
            });
        }
    };

    function _init() {
        container.addEventListener('click', _toggleAccordion);
    }

    this.init = function() {
        _init();
    };
}

export default rangedAccordion;