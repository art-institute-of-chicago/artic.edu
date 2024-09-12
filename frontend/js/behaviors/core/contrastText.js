import { textContrast } from "text-contrast"

const contrastText = function(container) {
  function _init() {
    let lightOrDark = textContrast.isLightOrDark(container.dataset.backgroundColor);
    container.classList.add(`s-${lightOrDark}-background`);
  }

  this.init = function() {
    _init();
  }
}

export default contrastText;
