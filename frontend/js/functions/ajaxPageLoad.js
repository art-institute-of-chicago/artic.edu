import { triggerCustomEvent, ajaxRequest, getOffset, forEach, scrollToY, setFocusOnTarget } from '@area17/a17-helpers';
import { findAncestorByTagName, ajaxableLink, ajaxableHref, googleTagManagerDataFromLink, parseHTML } from '../functions';
const ajaxPageLoad = function() {
  var ajaxing = false;
  var ajaxTimeOutTime = 5000;
  var ajaxTimer;
  var docContent;
  var documentContent;
  var docTitle;
  function _ajaxPageLoadComplete() {
    // fix images
    if (window.picturefill) {
      window.picturefill();
    }
    // tell the page and hide the loaders
    window.requestAnimationFrame(function(){
      triggerCustomEvent(document, 'page:updated');
      triggerCustomEvent(document, 'loader:complete');
      triggerCustomEvent(document, 'ajaxPageLoadMask:hide');
      triggerCustomEvent(document, 'ajaxPageLoad:complete');
      triggerCustomEvent(document, 'setScrollDirection:machineScroll', { 'machineScroll': false });
    });
    //
    ajaxing = false;
  }
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
    // check to see if we need the gallery header class
    if (doc.documentElement.classList.contains('s-gallery-header')) {
      document.documentElement.classList.add('s-gallery-header');
    } else {
      document.documentElement.classList.remove('s-gallery-header');
    }
    // check to see if we need the roadblock class
    if (doc.documentElement.classList.contains('s-roadblock-defined')) {
      let promo = doc.querySelector('#modal-promo');
      if (promo) {
        let promoClone = promo.cloneNode(true);
        document.body.append(promoClone);
        document.documentElement.classList.add('s-roadblock-defined');
      }
    } else {
      document.documentElement.classList.remove('s-roadblock-defined');
    }
    // update page class (p-xxxx)
    let pClassReg = /p-\S*/g;
    let oldDocPclasses = document.documentElement.className.match(pClassReg);
    let newDocPclasses = doc.documentElement.className.match(pClassReg);
    forEach(oldDocPclasses, function(index, item) {
      document.documentElement.classList.remove(item);
    });
    forEach(newDocPclasses, function(index, item) {
      document.documentElement.classList.add(item);
    });
  }
  function defaultStart(options,doc) {
    let $a17 = document.querySelector('#a17');
    $a17.style.minHeight = $a17.offsetHeight + 'px';
    document.documentElement.classList.add('s-page-nav');
  }
  function defaultComplete(options,doc) {
    // fade out content
    document.documentElement.classList.add('s-page-nav-swapping');
    // wait for fade to finish
    setTimeout(function(){
      // replace content
      let $a17 = document.querySelector('#a17');
      $a17.innerHTML = doc.querySelector('#a17').innerHTML;
      $a17.style.minHeight = '';
      // check states
      stateChecks(doc);
      window.requestAnimationFrame(function(){
        // fix scroll
        let scrollTarget = 0; // scroll to top
        let focusTarget = null;
        if(options.popstate && options.popstate.data.scrollY) {
          scrollTarget = options.popstate.data.scrollY;
        } else if (window.location.hash) {
          focusTarget = document.getElementById(window.location.hash.replace('#',''));
        } else if (options.ajaxScrollTarget) {
          focusTarget = document.getElementById(options.ajaxScrollTarget);
        }
        if (focusTarget) {
          scrollTarget = Math.round(getOffset(focusTarget).top);
        }
        document.documentElement.scrollTop = scrollTarget;
        document.body.scrollTop = scrollTarget;
        // reveal content
        document.documentElement.classList.remove('s-page-nav');
        document.documentElement.classList.remove('s-page-nav-swapping');
        // tell page about update
        triggerCustomEvent(document, 'page:updated');
        //
        if (focusTarget) {
          setTimeout(function(){ setFocusOnTarget(focusTarget); }, 0)
        }
        //
        _ajaxPageLoadComplete();
      });
    },1); // 250 is transition time
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
    A17.currentPathname = window.location.pathname;
    // tell GTM
    triggerCustomEvent(document, 'gtm:push', {
      'event': 'Pageview',
      'url': options.href
    });
  }
  function tabStart(options,doc) {
    document.documentElement.classList.add('s-page-nav');
  }
  function tabComplete(options,doc) {
    // replace content
    let tabTarget = document.getElementById(options.ajaxTabTarget);
    tabTarget.innerHTML = doc.getElementById(options.ajaxTabTarget).innerHTML;
    let scrollTarget = Math.round(getOffset(tabTarget).top);
    scrollToY({
      el: document,
      offset: scrollTarget,
      duration: 500,
      easing: 'easeInOut',
      onComplete: function() {
        setTimeout(function(){ setFocusOnTarget(tabTarget); }, 0)
      }
    });
    document.documentElement.classList.remove('s-page-nav');
    // tell page about update
    triggerCustomEvent(document, 'page:updated');
    // tell GTM
    triggerCustomEvent(document, 'gtm:push', {
      'event': 'Pageview',
      'url': options.href
    });
    //
    _ajaxPageLoadComplete();
  }
  function modalStart(options,doc) {
  }
  function modalComplete(options,doc) {
    // replace content
    document.querySelector('[data-modal]').className = 'g-modal ' + (options.modalClass ? options.modalClass : '');
    document.querySelector('[data-modal-content]').innerHTML = doc.querySelector('body').innerHTML;
    triggerCustomEvent(document, 'modal:show', { opener: options.opener });
    //
    _ajaxPageLoadComplete();
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
    triggerCustomEvent(document, 'dropdown:close');
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
          triggerCustomEvent(document, 'setScrollDirection:machineScroll', { 'machineScroll': true });
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
        } catch (err) {
          triggerCustomEvent(document, 'loader:error');
          triggerCustomEvent(document, 'ajaxPageLoadMask:hide');
          document.documentElement.classList.remove('s-page-nav');
          document.documentElement.classList.remove('s-page-nav-swapping');
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
        document.documentElement.classList.remove('s-page-nav');
        document.documentElement.classList.remove('s-page-nav-swapping');
        ajaxing = false;
        if (A17.ajaxLinksFailSafe) {
          location.href = options.href;
        } else {
          console.log(data);
        }
      }
    });
    ajaxTimer = setTimeout(function(){
      if (A17.ajaxLinksFailSafe) {
        location.href = options.href;
      } else {
        console.log('Ajax response taking a long time to complete');
      }
    }, ajaxTimeOutTime);
  }
  function popstate(event) {
    event.preventDefault();
    //if (A17.currentPathname !== window.location.pathname && (!event.data.type || event.data.type === 'page')) {
    if (!event.data.type || event.data.type === 'page') {
      loadDocument({
        href: event.data.url,
        type: event.data.type,
        title: event.data.title,
        popstate: event
      });
    }
  }
  function getPage(event) {
    if (event.data.url) {
      if (ajaxableHref(event.data.url, event)) {
        if (!history.state && (!event.data.type || (event.data.type && event.data.type !== 'modal'))) {
          triggerCustomEvent(document, 'history:replacestate', {
            url: location.href,
            type: event.data.type || 'page',
            scrollY: window.scrollY || 0,
          });
        }
        loadDocument({
          href: event.data.url,
          type: event.data.type || 'page',
          popstate: false,
          modalClass: event.data.modalClass ? event.data.modalClass : null,
          opener: event.data.opener ? event.data.opener : null,
          ajaxScrollTarget: event.data.ajaxScrollTarget ? event.data.ajaxScrollTarget : null
        });
      } else {
        window.location.href = event.data.url;
      }
    }
  }
  function nonAjaxLinks(link,googleTagManagerObject,event) {
    // if the link has some google tag manager props, tell GTM
    if (googleTagManagerObject) {
      triggerCustomEvent(document, 'gtm:push', googleTagManagerObject);
    }
    // if link opens in this tab, halt execution while we tell GTM
    // TODO: This tends to break things and overrides core browser behavior. Remove..?
    if (event && link && link.getAttribute('target') !== '_blank' && link.href && link.href.indexOf('#') < 0) {
      event.preventDefault();
      var win = window.open(link.href, '_blank');
      win.focus();
    }
  }
  function handleClicks(event) {
    var link = findAncestorByTagName(event.target, 'A');
    var googleTagManagerObject = googleTagManagerDataFromLink(link);
    //
    if (A17.ajaxLinksActive) {
      var ajaxable = ajaxableLink(link, event);
      if (ajaxable) {
        event.preventDefault();
        if (!ajaxing) {
          // give immediate feedback to checkboxes
          if (link.classList.contains('checkbox')) {
            if (link.classList.contains('s-checked')) {
              link.classList.remove('s-checked');
            } else {
              link.classList.add('s-checked');
            }
          }
          // if the link has some google tag manager props, tell GTM
          if (googleTagManagerObject) {
            triggerCustomEvent(document, 'gtm:push', googleTagManagerObject);
          }
          // then start the ajax process
          var ajaxTabTarget = link.getAttribute('data-ajax-tab-target');
          var ajaxScrollTarget = link.getAttribute('data-ajax-scroll-target');
          var ajaxTabTargetNode = null;
          if (ajaxTabTarget !== null && ajaxScrollTarget !== null) {
            ajaxTabTarget = null;
          }
          if (ajaxTabTarget !== null) {
            ajaxTabTargetNode = document.getElementById(ajaxTabTarget);
            if (!ajaxTabTargetNode) {
              ajaxScrollTarget = ajaxTabTarget;
              ajaxTabTarget = null;
            }
          }
          if (!ajaxTabTargetNode) {
            triggerCustomEvent(document, 'history:replacestate', {
              url: location.href,
              type: 'page',
              scrollY: window.scrollY || 0,
            });
          }
          loadDocument({
            href: ajaxable.href,
            type: ajaxTabTarget ? 'tab' : 'page',
            popstate: false,
            link: link,
            ajaxTabTarget: ajaxTabTarget ? ajaxTabTarget : null,
            ajaxScrollTarget: ajaxScrollTarget ? ajaxScrollTarget : null,
          });
        }
      } else {
        nonAjaxLinks(link,googleTagManagerObject,event);
      }
    } else {
      nonAjaxLinks(link,googleTagManagerObject,event);
    }
  }
  document.addEventListener('ajax:getPage', getPage);
  document.addEventListener('ajax:pageload:popstate', popstate);
  document.addEventListener('click', handleClicks);
};
export default ajaxPageLoad;
