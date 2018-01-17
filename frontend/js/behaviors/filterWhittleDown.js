import { purgeProperties, forEach } from 'a17-helpers';

const filterWhittleDown = function(container) {

  const input = container.querySelector('input');
  const list = container.nextElementSibling;

  function _whittleDown() {
    if (input.value.length > 0) {
      forEach(list.children, function(index, item) {
        if (item.textContent.indexOf(input.value) > -1) {
          item.classList.add('s-visible');
        } else {
          item.classList.remove('s-visible');
        }
      });
      container.classList.add('s-whittling');
    } else {
      forEach(list.children, function(index, item) {
        item.classList.remove('s-visible');
      });
      container.classList.remove('s-whittling');
    }
  }

  function _init() {
    input.addEventListener('input', _whittleDown, false);
    container.addEventListener('submit', _whittleDown, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    input.removeEventListener('input', _whittleDown);
    container.removeEventListener('submit', _whittleDown);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default filterWhittleDown;
