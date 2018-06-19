import { triggerCustomEvent } from '@area17/a17-helpers';

const googleTagManager = function() {

  document.addEventListener('gtm:push',function(event){
    if (event.data) {
      window.dataLayer = window.dataLayer || [];
      if (event.data.event === 'Pageview') {
        window.dataLayer.push(event.data);
      } else {
        window.dataLayer.push({
          event: 'dataLayerPush',
          data: event.data
        });
      }
    }
  }, false);

};

export default googleTagManager;
