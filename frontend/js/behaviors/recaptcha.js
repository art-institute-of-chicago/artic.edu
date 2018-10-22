import { purgeProperties, forEach, triggerCustomEvent } from '@area17/a17-helpers';

const recaptcha = function(container){

  function _captchaOnload() {
    grecaptcha.render('g-recaptcha', {
      'sitekey' : container.getAttribute('data-sitekey'),
    });
  };

  function _init() {
    document.addEventListener('ajaxPageLoad:complete', _captchaOnload, false);
  }

  this.destroy = function() {
    document.removeEventListener('ajaxPageLoad:complete', _captchaOnload);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };

};

export default recaptcha;
