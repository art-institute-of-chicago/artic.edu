const maskEmail = function(container) {

  this.destroy = function() {
    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    let emailAddress = container.getAttribute('data-maskEmail-user') + '@' + container.getAttribute('data-maskEmail-domain');
    container.setAttribute('href', 'mailto:'+emailAddress);
    container.setAttribute('target','_blank');
    if (container.textContent === '') {
      container.textContent = emailAddress;
    }
  };
};

export default maskEmail;
