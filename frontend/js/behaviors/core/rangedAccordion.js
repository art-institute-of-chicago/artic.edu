import { getOffset } from '@area17/a17-helpers';

const rangedAccordion = function(container) {

    function _toggleAccordion() {

        // Get scroll position to maintain screen position on toggle
        let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

        // Get the trigger element
        let trigger = container.querySelector('.o-accordion__trigger');

        // Get the associated panel
        let panel = document.getElementById('panel_' + trigger.id);

        // Toggle the expanded state
        const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
        trigger.setAttribute('aria-expanded', !isExpanded);

        // Toggle the height of the panel
        panel.style.height = isExpanded ? '0' : 'max-content';

        // Toggle the active class on the trigger
        trigger.classList.toggle('is-active');

        // On close scroll to the top of the accordion
        const offset = getOffset(container.querySelector('#' + trigger.id));
        window.scrollTo(0, scrollTop);
    };

    function _init() {
        container.addEventListener('click', _toggleAccordion);
    }

    this.init = function() {
        _init();
    };
}

export default rangedAccordion;