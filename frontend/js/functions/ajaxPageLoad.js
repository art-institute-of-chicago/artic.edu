import { triggerCustomEvent, ajaxRequest } from '@area17/a17-helpers';
import { findAncestorByTagName, ajaxableLink, ajaxableHref } from '../functions';

const ajaxPageLoad = function() {

  var ajaxing = false;
  var ajaxTimeOutTime = 3500;
  var ajaxTimer;

  var docContent;
  var documentContent;
  var docTitle;

  function stateChecks(doc) {
    // check to see if we need the contrasted header
    if (doc.documentElement.classList.contains('s-contrast-header')) {
      document.documentElement.classList.add('s-contrast-header');
    } else {
      document.documentElement.classList.remove('s-contrast-header');
    }
    // check to see if we need the filled in logo
    if (doc.documentElement.classList.contains('s-filled-logo')) {
      document.documentElement.classList.add('s-filled-logo');
    } else {
      document.documentElement.classList.remove('s-filled-logo');
    }
  }

  function defaultStart(options,doc) {
    document.documentElement.classList.add('s-page-nav');
  }

  function defaultComplete(options,doc) {
    // fade out content
    document.documentElement.classList.add('s-page-nav-swapping');
    setTimeout(function(){
      // replace content
      document.querySelector('#a17').innerHTML = doc.querySelector('#a17').innerHTML;
      // fix scroll
      if(options.popstate && options.popstate.data.scrollY) {
        document.documentElement.scrollTop = options.popstate.data.scrollY;
        document.body.scrollTop = options.popstate.data.scrollY;
      } else {
        // scroll to top
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;
      }
      // check states
      stateChecks(doc);
      // reveal content
      document.documentElement.classList.remove('s-page-nav');
      document.documentElement.classList.remove('s-page-nav-swapping');
      // tell page about update
      triggerCustomEvent(document, 'page:updated');
    }, 250);
    // replace title
    docTitle = doc.title;
    document.title = docTitle;
    // update history
    if (!options.popstate) {
      triggerCustomEvent(document, 'history:pushstate', {
        url: options.href,
        type: options.type,
        title: docTitle,
      });
    }
    // so we know what to do on replace states
    A17.previousAjaxPageLoadType = options.type;
  }

  function tabStart(options,doc) {
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

  function modalStart(options,doc) {
  }

  function modalComplete(options,doc) {
    // replace content
    document.querySelector('[data-modal]').className = 'g-modal ' + (options.modalClass ? options.modalClass : '');
    document.querySelector('[data-modal-content]').innerHTML = doc.querySelector('body').innerHTML;
    triggerCustomEvent(document, 'modal:show', { opener: options.opener });
  }

  function parseHTML(data,type) {
    if (type === 'native') {
      var parser = new DOMParser();
      return parser.parseFromString(data, 'text/html');
    } else {
      var doc = document.implementation.createHTMLDocument('');
      if (data.toLowerCase().indexOf('<!doctype') > -1) {
        doc.documentElement.innerHTML = data;
      }
      else {
        doc.body.innerHTML = data;
      }
      return doc;
    }
  }

  function loadDocument(options) {

    if (!A17.ajaxLinksActive) {
      window.location.href = options.href;
      return false;
    }

    if (ajaxing) {
      return;
    }

    ajaxing = true;

    triggerCustomEvent(document, 'shareMenu:close');
    triggerCustomEvent(document, 'selectDate:close');
    triggerCustomEvent(document, 'fullScreenImage:close');
    triggerCustomEvent(document, 'collectionSearch:close');
    triggerCustomEvent(document, 'infoButtonInfo:close');
    triggerCustomEvent(document, 'modal:close');
    triggerCustomEvent(document, 'roadblock:close');
    triggerCustomEvent(document, 'globalSearch:close');
    triggerCustomEvent(document, 'navMobile:close');

    docTitle = null;
    docContent = null;
    documentContent = null;

    triggerCustomEvent(document, 'ajaxPageLoadMask:show');
    triggerCustomEvent(document, 'loader:start');

    // do on start func
    switch (options.type) {
      case 'tab':
        tabStart(options);
        break;
      case 'modal':
        modalStart(options);
        break;
      default:
        // essentially, type = page
        defaultStart(options);
    }

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
          clearTimeout(ajaxTimer);
        } catch(err) {}
        try {
          // parse returned page
          var doc = parseHTML(data,'native');
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
          if (window.picturefill) {
            window.picturefill();
          }
          // tell the page and hide the loaders
          triggerCustomEvent(document, 'page:updated');
          triggerCustomEvent(document, 'loader:complete');
          triggerCustomEvent(document, 'ajaxPageLoadMask:hide');
          //
          ajaxing = false;
        } catch (err) {
          triggerCustomEvent(document, 'loader:error');
          triggerCustomEvent(document, 'ajaxPageLoadMask:hide');
          ajaxing = false;
          if (A17.ajaxLinksFailSafe) {
            location.href = options.href;
          } else {
            console.log(err);
          }
        }
      },
      onError: function(data){
        clearTimeout(ajaxTimer);
        triggerCustomEvent(document, 'loader:error');
        triggerCustomEvent(document, 'ajaxPageLoadMask:hide');
        ajaxing = false;
        if (A17.ajaxLinksFailSafe) {
          location.href = options.href;
        } else {
          console.log(data);
        }
      }
    });

    ajaxTimer = setTimeout(function(){
      location.href = options.href;
    }, ajaxTimeOutTime);
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
      if (ajaxableHref(event.data.url)) {
        if (!history.state && (!event.data.type || (event.data.type && event.data.type !== 'modal'))) {
          triggerCustomEvent(document, 'history:replacestate', {
            url: location.href,
            type: event.data.type || 'page',
            scrollY: window.scrollY || 0,
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
      } else {
        window.location.href = event.data.url;
      }
    }
  }

  function handleClicks(event) {
    if (A17.ajaxLinksActive) {
      var link = findAncestorByTagName(event.target, 'A');
      var ajaxable = ajaxableLink(link, event);
      if (ajaxable) {
        event.preventDefault();
        triggerCustomEvent(document, 'history:replacestate', {
          url: location.href,
          type: 'page',
          scrollY: window.scrollY || 0,
        });
        A17.previousAjaxPageLoadType = 'page';
        loadDocument({
          href: ajaxable.href,
          type: 'page',
          popstate: false,
          link: link,
        });
      }
    }
  }

  document.addEventListener('ajax:getPage', getPage);
  document.addEventListener('ajax:pageload:popstate', popstate);
  document.addEventListener('click', handleClicks);
};

export default ajaxPageLoad;
