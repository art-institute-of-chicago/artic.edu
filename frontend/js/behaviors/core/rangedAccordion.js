import { purgeProperties, triggerCustomEvent } from '@area17/a17-helpers';

const rangedAccordion = function(container) {
    const trigger = container.querySelector('.o-accordion__trigger');

    function _toggleAccordion(event) {

        // Prevent default behavior
        event.preventDefault();

        // Get the associated panel
        let panel = container.querySelector(`#panel_${trigger.id}`);

        // Get the current scroll position
        const currentScrollY = window.scrollY;

        // Toggle the expanded state
        const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
        trigger.setAttribute('aria-expanded', !isExpanded);

        // Add the fading effect
        if (!isExpanded) {
            // Expanding the panel
            panel.style.height = 'auto'; // Let content height determine the space
            panel.style.opacity = '0';   // Set initial opacity to 0 for fade-in
            panel.style.transition = 'opacity 0.5s ease'; // Add transition for fade-in effect

            // Timeout to ensure the height is calculated before applying opacity
            setTimeout(() => {
                panel.style.opacity = '1'; // Fade-in effect
            }, 10); // Minimal delay to ensure transition kicks in
        } else {
            // Collapsing the panel
            panel.style.transition = 'opacity 0.5s ease'; // Add transition for fade-out effect
            panel.style.opacity = '0'; // Fade-out effect

            // Set timeout to hide after fade-out completes
            setTimeout(() => {
                panel.style.height = '0';  // Collapse the height
            }, 500); // Match with transition duration (0.5s)
        }

        // Toggle the active class on the trigger
        trigger.classList.toggle('is-active');

        // Adjust scroll position only if closing the accordion
        if (isExpanded) {
            setTimeout(() => {
                window.scrollTo({
                    top: currentScrollY,
                    behavior: 'instant'
                });
                triggerCustomEvent(document, 'accordion:toggled',);
            }, 500);
        } else {
            window.scrollTo({
                top: currentScrollY,
                behavior: 'instant'
            });
            triggerCustomEvent(document, 'accordion:toggled',);
        }
    };

    function _checkUrl() {
      const hash = window.location.hash.substring(1);

      if (hash && trigger && trigger.id === hash) {
        const isExpanded = trigger.getAttribute('aria-expanded') === 'true';

        // Only toggle if not already expanded
        if (!isExpanded) {
          setTimeout(150);
          trigger.click();
        }
      }
    }

    this.destroy = function() {
      if (trigger) {
        trigger.removeEventListener('click', _toggleAccordion);
      }

      window.removeEventListener('popstate', _checkUrl);
      // Remove properties of this behavior
      purgeProperties(this);
    };

    this.init = function() {
      if (trigger) {
        trigger.addEventListener('click', _toggleAccordion);
      }

      window.addEventListener('popstate', _checkUrl);
    };
}

export default rangedAccordion;
