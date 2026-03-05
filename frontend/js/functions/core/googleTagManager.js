import { triggerCustomEvent } from '@area17/a17-helpers';

const googleTagManager = function() {

  document.addEventListener('gtm:push', function(event){
    if (event.data) {
      let data = Array.isArray(event.data) ? event.data : [event.data];

      // WEB-2436: Support pushing multiple events
      data.forEach(function (datum) {
        window.dataLayer = window.dataLayer || [];
        if (datum.event === 'Pageview') {
          window.dataLayer.push(datum);
        } else {
          datum.eventPageTitle = document.title.replace(/ \| The Art Institute of Chicago/ig, '');
          datum.eventPagePathName = window.location.pathname;
          datum.eventPageUrl = window.location.href;
          if (A17.env !== 'production') {
            console.log('gtm:dataLayerPush', datum);
          }
          window.dataLayer.push({
            event: 'dataLayerPush',
            data: datum
          });
        }
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
