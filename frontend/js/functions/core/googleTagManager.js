import { triggerCustomEvent } from '@area17/a17-helpers';

const googleTagManager = function() {

  document.addEventListener('gtm:push',function(event){
    if (event.data) {
      window.dataLayer = window.dataLayer || [];
      if (event.data.event === 'Pageview') {
        window.dataLayer.push(event.data);
      } else {
        event.data.eventPageTitle = document.title.replace(/ \| The Art Institute of Chicago/ig, '');
        event.data.eventPagePathName = window.location.pathname;
        event.data.eventPageUrl = window.location.href;
        if (A17.env !== 'production') {
          console.log('gtm:dataLayerPush', event.data);
        }
        window.dataLayer.push({
          event: 'dataLayerPush',
          data: event.data
        });
      }
    }
  }, false);

};

export default googleTagManager;
