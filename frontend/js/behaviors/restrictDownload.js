import { purgeProperties } from '@area17/a17-helpers';

const restrictDownload = function(container) {

  function _init() {

    // Disable right-click
    container.addEventListener('contextmenu', function(e){
      e.preventDefault();
    });

    // Disable drag
    container.addEventListener('mousedown', function(e){
      e.preventDefault()
    });

  }

  this.destroy = function() {
    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default restrictDownload;
