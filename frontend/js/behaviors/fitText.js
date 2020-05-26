import { purgeProperties, forEach } from '@area17/a17-helpers';
import fitty from 'fitty';

const fitText = function(container) {

  const fittyClass ='f-fit-text';

  // called when all fonts loaded
  function _redrawFitty() {
    fitty.fitAll();
  }

  this.destroy = function() {
    document.removeEventListener('fonts:loaded', _redrawFitty);
    forEach(container.querySelectorAll('img'), function(index, el) {
      el.removeEventListener('load', _redrawFitty);
    });

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    fitty('.' + fittyClass, {
      minSize: 16,
      maxSize: 36
    });

    document.addEventListener('fonts:loaded', _redrawFitty, false);
    forEach(container.querySelectorAll('img'), function(index, el) {
      el.addEventListener('load', _redrawFitty, false);
    });
  };
};

export default fitText;
