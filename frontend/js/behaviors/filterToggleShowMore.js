import { purgeProperties } from 'a17-helpers';

const filterToggleShowMore = function(container) {

  const list = container.previousElementSibling;
  const klass = 's-capped';

  function _click(event) {
    event.preventDefault();
    if (list.classList.contains(klass)) {
      list.classList.remove(klass);
      container.querySelector('span').textContent = 'Show Less';
    } else {
      list.classList.add(klass);
      container.querySelector('span').textContent = 'Show More';
    }
    container.blur();
  }

  function _init() {
    container.addEventListener('click', _click, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _click);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default filterToggleShowMore;
