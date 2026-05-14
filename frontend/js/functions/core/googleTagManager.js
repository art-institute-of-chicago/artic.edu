import { triggerCustomEvent } from '@area17/a17-helpers';

const googleTagManager = function() {

  document.addEventListener('gtm:push', function(event){
    if (event.data) {
      let data = Array.isArray(event.data) ? event.data : [event.data];

      // WEB-2436: Support pushing multiple events
      data.forEach(function (datum) {
        let push = {};
        window.dataLayer = window.dataLayer || [];
        switch (datum.event) {
          case 'Pageview':
          case 'gtm.video':
          case 'video_advance':
            push = datum;
            break;
          default:
            datum.eventPageTitle = document.title.replace(/ \| The Art Institute of Chicago/ig, '');
            datum.eventPagePathName = window.location.pathname;
            datum.eventPageUrl = window.location.href;
            push = { event: 'dataLayerPush', data: datum };
        }
        if (A17.env !== 'production') {
          console.log('gtm:dataLayerPush', push);
        }
        window.dataLayer.push(push);
      });
    }
  }, false);

  window.addEventListener('load', function () {
    let pageMetaDataEm = document.getElementById('page-meta-data');

    if (pageMetaDataEm) {
      let pageMetaData = Object.assign({
        'event': 'page-meta-data',
      }, JSON.parse(pageMetaDataEm.innerHTML));

      triggerCustomEvent(document, 'gtm:push', pageMetaData);
    }
  });

};

export default googleTagManager;
