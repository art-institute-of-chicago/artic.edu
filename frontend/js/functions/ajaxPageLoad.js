import { triggerCustomEvent, ajaxRequest } from 'a17-helpers';
import { findAncestorByTagName, ajaxableLink } from '../functions';

const ajaxPageLoad = function() {

  var ajaxActive = false;
  var failSafe = false;

  var docContent;
  var documentContent;
  var docTitle;

  function defaultComplete(options,doc) {
    // replace content
    document.querySelector('#a17').innerHTML = doc.querySelector('#a17').innerHTML;
    // replace title
    docTitle = doc.title;
    document.title = docTitle;
    // scroll to top
    document.documentElement.scrollTop = 0;
    document.body.scrollTop = 0;
    // update history
    if (!options.popstate) {
      triggerCustomEvent(document, 'history:pushstate', { url: options.href, type: options.type, title: docTitle });
    }
    // so we know what to do on replace states
    A17.previousAjaxPageLoadType = options.type;
  }

  function tabComplete(options,doc) {
    // replace content
    document.querySelector('[data-tab-content]').innerHTML = doc.querySelector('[data-tab-content]').innerHTML;
    // replace titles
    docTitle = doc.title;
    document.title = docTitle;
    // update history
    if (!options.popstate) {
      triggerCustomEvent(document, 'history:pushstate', { url: options.href, type: options.type, title: docTitle });
    }
    // so we know what to do on replace states
    A17.previousAjaxPageLoadType = options.type;
  }

  function modalComplete(options,doc) {
    // replace content
    document.querySelector('[data-modal]').className = 'g-modal ' + (options.modalClass ? options.modalClass : '');
    document.querySelector('[data-modal-content]').innerHTML = doc.querySelector('body').innerHTML;
    triggerCustomEvent(document, 'modal:show', { opener: options.opener });
  }

  function loadDocument(options) {

    if (!ajaxActive) {
      window.location.href = options.href;
      return false;
    }

    triggerCustomEvent(document, 'modal:hide', { opener: options.opener });
    triggerCustomEvent(document, 'navPrimary:hide', { opener: options.opener });
    triggerCustomEvent(document, 'shareMenu:close');
    triggerCustomEvent(document, 'selectDate:close');

    docTitle = null;
    docContent = null;
    documentContent = null;

    triggerCustomEvent(document, 'ajaxPageLoadMask:show');
    triggerCustomEvent(document, 'loader:start');

    let token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
      token = token.getAttribute('content');
    } else {
      token = '';
    }

    ajaxRequest({
      url: options.href,
      type: 'GET',
      requestHeaders: [
        {
          header: 'X-CSRF-Token',
          value: token
        }
      ],
      onSuccess: function(data){
        try {
          // parse returned page
          var parser = new DOMParser();
          var doc = parser.parseFromString(data, 'text/html');
          // do on complete func
          switch (options.type) {
            case 'tab':
              tabComplete(options, doc);
              break;
            case 'modal':
              modalComplete(options, doc);
              break;
            default:
              // essentially, type = page
              defaultComplete(options, doc);
          }
          // fix images
          //picturefill();
          // tell the page and hide the loaders
          triggerCustomEvent(document, 'page:updated');
          triggerCustomEvent(document, 'loader:complete');
          triggerCustomEvent(document, 'ajaxPageLoadMask:hide');
        } catch (err) {
          triggerCustomEvent(document, 'loader:error');
          triggerCustomEvent(document, 'ajaxPageLoadMask:hide');
          if (failSafe) {
            location.href = options.href;
          } else {
            console.log(err);
          }
        }
      },
      onError: function(data){
        triggerCustomEvent(document, 'loader:error');
        triggerCustomEvent(document, 'ajaxPageLoadMask:hide');
        if (failSafe) {
          location.href = options.href;
        } else {
          console.log(data);
        }
      }
    });
  }

  function popstate(event) {
    loadDocument({
      href: event.data.url,
      type: event.data.type,
      title: event.data.title,
      popstate: event
    });
  }

  function getPage(event) {
    if (event.data.url) {
      if (!history.state && (!event.data.type || (event.data.type && event.data.type !== 'modal'))) {
        triggerCustomEvent(document, 'history:replacestate', {
          url: location.href,
          type: event.data.type || 'page',
        });
        A17.previousAjaxPageLoadType = event.data.type || 'page';
      }
      loadDocument({
        href: event.data.url,
        type: event.data.type || 'page',
        popstate: false,
        modalClass: event.data.modalClass ? event.data.modalClass : null,
        opener: event.data.opener ? event.data.opener : null,
      });
    }
  }

  function handleClicks(event) {
    if (ajaxActive) {
      var link = findAncestorByTagName(event.target, 'A');
      var ajaxable = ajaxableLink(link, event);
      if (ajaxable) {
        event.preventDefault();
        loadDocument({
          href: ajaxable.href,
          type: 'page',
          popstate: false,
          link: link
        });
      }
    }
  }

  document.addEventListener('ajax:getPage', getPage);
  document.addEventListener('ajax:pageload:popstate', popstate);
  document.addEventListener('click', handleClicks);
};

export default ajaxPageLoad;
