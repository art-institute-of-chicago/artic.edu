import { triggerCustomEvent, setFocusOnTarget, forEach, getOffset } from '@area17/a17-helpers';

const rangedAccordion = function(container) {

    function _toggleAccordion() {
        let trigger = container.querySelector('.o-accordion__trigger');
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
    
            // Get the associated panel
            let panel = container.querySelector('.o-accordion__panel');

            console.log('panel' + panel);
    
            // Toggle the expanded state
            const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
            trigger.setAttribute('aria-expanded', !isExpanded);
    
            // Toggle the height of the panel
            if (isExpanded) {
                panel.style.height = '0';
            } else {
                panel.style.height = 'max-content';
            }
    
            // Toggle the active class on the trigger
            trigger.classList.toggle('is-active');
        });
    }
    

    function _init() {
        _toggleAccordion();
    }

    this.init = function() {
        _init();
    };
}

export default rangedAccordion;