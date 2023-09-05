const showAdmissionTooltip = function(container) {

    let infoOpen = false;
    let tooltipSized = false;

    let targetAttribute = container.getAttribute('data-tooltip-target');
    let targetTooltip = document.getElementById(targetAttribute);

    container.addEventListener('click', function() {
        toggleTooltip.call(this);
    });

    function toggleTooltip() {
        hideTooltips();
        showTooltip(targetTooltip);
        sizeToolTips();
    }

    function hideTooltips() {
        const tooltips = document.querySelectorAll('.admission-info-button-info.admission-info-visible');
        if(infoOpen && !container.contains(document.activeElement)){
            tooltips.forEach(element => {
                infoOpen = false;
                element.setAttribute('aria-expanded','false');
                element.setAttribute('aria-hidden','true');
                element.classList.remove('admission-info-visible')
            })
        }
    }

    function showTooltip(targetTooltip) {
        if (targetTooltip) {
            infoOpen = true;
            targetTooltip.setAttribute('aria-expanded','true');
            targetTooltip.setAttribute('aria-hidden','false');
            targetTooltip.classList.add('admission-info-visible');
        }
    }

    function sizeToolTips() {
        if (!tooltipSized){
            tooltipSized = true;
        
            const posTooltips = document.querySelectorAll('.admission-info-button-info');
            
            posTooltips.forEach(element => {
            if (element.clientHeight !== undefined) {
                const newTopValue = -1 * (element.clientHeight) + 'px';
                element.setAttribute('style', 'top: ' + newTopValue);
            }
            });
        }
      }

    function _init() {
        document.addEventListener('click', hideTooltips, false);
        window.addEventListener('resize', sizeToolTips, false);
    }

    this.init = function() {
        _init();
    };
};
export default showAdmissionTooltip;