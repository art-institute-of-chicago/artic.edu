import { triggerCustomEvent } from '@area17/a17-helpers';

const historyProxy = function() {

  // IE9 doesn't do pushState
  if (!window.history.pushState) {
    return;
  }
  // proxy events mean we don't need to worry about browsers that can't

  // listen for replaceState and pushState reqs
  document.addEventListener('history:replacestate',function(event){
    if (event.data.url !== 'about:srcdoc') {
      history.replaceState(event.data, '', event.data.url);
    }
  }, false);

  document.addEventListener('history:pushstate',function(event){
    history.pushState(event.data, '', event.data.url);
  }, false);

  // on window popstate, lets look at the event.state object and see if we need to do something
  window.addEventListener('popstate', function(event) {
    if (event && event.state && event.state.type) {
      triggerCustomEvent(document, 'ajax:pageload:popstate', event.state);
    }
  }, false);


  // replace state, so on back button we can do something
  triggerCustomEvent(document, 'history:replacestate', { url: location.href, type: 'page' });

};

export default historyProxy;
