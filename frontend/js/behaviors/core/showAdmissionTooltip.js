const showAdmissionTooltip = function(container) {

    function toggleTooltip() {
        hideTooltips();
        showTooltip();
    }

    function hideTooltips() {
        const tooltips = document.querySelectorAll('.admission-info-button-info');
        tooltips.forEach(element => {
            element.style.display = 'none';
            element.setAttribute('aria-expanded','false');
            element.setAttribute('aria-hidden','true');
            element.classList.remove('admission-info-visible')
        })
    }

    function showTooltip() {
        let targetTooltip = document.getElementById(container.dataset.tooltipTarget);

        if (targetTooltip) {
            targetTooltip.setAttribute('aria-expanded','true');
            targetTooltip.setAttribute('aria-hidden','false');
            targetTooltip.style.display = 'block';
            targetTooltip.classList.add('admission-info-visible');
        }
    }

    function sizeToolTips() {
        const posTooltips = document.querySelectorAll('.admission-info-button-info');

        posTooltips.forEach(element => {
            if (element.clientHeight !== undefined) {
                const newTopValue = -1 * (element.clientHeight) + 'px';
                element.setAttribute('style', 'top: ' + newTopValue);
            }
        });
    }

    function _clicksOutside(event) {
        hideTooltips();
    }

    function _handleClicks(event) {
      event.preventDefault();
      event.stopPropagation();
      toggleTooltip();
      container.blur();
    }

    function _escape(event) {
      var isInput = (event.target.tagName === 'INPUT');
      if (event.keyCode === 27 && !isInput) {
        hideTooltips();
      }
    }

    function _init() {
        hideTooltips();
        sizeToolTips();
        container.addEventListener('click', _handleClicks, false);
        document.addEventListener('click', _clicksOutside, false);
        window.addEventListener('resize', sizeToolTips, false);
        window.addEventListener('keyup', _escape, false);
    }

    this.destroy = function() {
      // Remove specific event handlers
      container.removeEventListener('click', _handleClicks);
      document.removeEventListener('click', _clicksOutside);
      window.removeEventListener('resize', sizeToolTips);
      window.removeEventListener('keyup', _escape);

      // Remove properties of this behavior
      A17.Helpers.purgeProperties(this);
    };

    this.init = function() {
        _init();
    };
};
export default showAdmissionTooltip;
