import { forEach } from '@area17/a17-helpers';
import fitty from 'fitty';

const fitText = function(container) {

  const fittyClass ='f-fit-text';
  const fittySmallClass ='f-fit-text-small';

  // Called when all fonts loaded
  function _redrawFitty() {
    fitty.fitAll();
  }

  this.destroy = function() {
    document.removeEventListener('fonts:loaded', _redrawFitty);
    forEach(container.querySelectorAll('img'), function(index, el) {
      el.removeEventListener('load', _redrawFitty);
    });

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    fitty('.' + fittyClass, {
      minSize: 16,
      maxSize: 36
    });
    fitty('.' + fittySmallClass, {
      minSize: 10,
      maxSize: 26
    });

    document.addEventListener('fonts:loaded', _redrawFitty, false);
    forEach(container.querySelectorAll('img'), function(index, el) {
      el.addEventListener('load', _redrawFitty, false);
    });
  };
};

export default fitText;
