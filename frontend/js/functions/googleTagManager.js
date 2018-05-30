import { triggerCustomEvent } from '@area17/a17-helpers';

const googleTagManager = function() {

  document.addEventListener('gtm:push',function(event){
    if (event.data) {
      window.dataLayer = window.dataLayer || [];
      window.dataLayer.push(event.data);
    }
  }, false);

};

export default googleTagManager;
