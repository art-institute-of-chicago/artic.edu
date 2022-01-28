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
    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default restrictDownload;
