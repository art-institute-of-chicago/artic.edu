import { setFocusOnTarget, triggerCustomEvent, ajaxRequest, queryStringHandler } from '@area17/a17-helpers';
import { googleTagManagerDataFromLink } from '../../functions/core';

const globalSearch = function(container) {
  const autoCompleteUrl = container.getAttribute('data-autocomplete-url');

  const textInput = container.querySelector('input[type="search"]');
  const form = container.querySelector('form');
  const stateKlass ='s-search-active';
  const autocompleteKlass = 's-search-active--autocomplete';
  const loaderKlass = 's-loading';

  let active = false;
  let searchTerm = '';
  let dropdownList;
  let ajaxTimer;
  let timestamp = 0;

  function _showLoader() {
    container.classList.add(loaderKlass);
  }

  function _hideLoader() {
    container.classList.remove(loaderKlass);
  }

  // Show autocomplete
  function _showAutocomplete(content,stamp) {
    if (stamp === timestamp) {
      let parser = new DOMParser();
      let doc = parser.parseFromString(content, 'text/html');
      dropdownList = doc.querySelector('[data-autocomplete-list]');
      if (dropdownList) {
        container.querySelector('[data-search-inner]').appendChild(dropdownList);
        requestAnimationFrame(function(){
          if (!document.documentElement.classList.contains(autocompleteKlass)) {
            document.documentElement.classList.add(autocompleteKlass);
          }
        });
        triggerCustomEvent(document, 'page:updated');
      }
    }
  }

  function _clearAutocomplete() {
    if (dropdownList) {
      container.querySelector('[data-search-inner]').removeChild(dropdownList);
      dropdownList = null;
    }
  }

  // Hide autocomplete
  function _hideAutocomplete() {
    if (document.documentElement.classList.contains(autocompleteKlass)) {
      document.documentElement.classList.remove(autocompleteKlass);
    }
    _clearAutocomplete();
  }

  function _fixedEncodeURIComponent(str) {
    return encodeURIComponent(str).replace(/[!'()*]/g, function(c) {
      return '%' + c.charCodeAt(0).toString(16);
    });
  }

  /**
   * Handle ajax search
   */
  function _doAjax() {
    clearTimeout(ajaxTimer);

    var tempTimeStamp = Date.now();
    if (tempTimeStamp > timestamp) {
      timestamp = tempTimeStamp;
    } else {
      return;
    }

    _showLoader();
    ajaxTimer = setTimeout(function(){
      ajaxRequest({
        url: autoCompleteUrl,
        type: 'GET',
        data: { q: textInput.value },
        requestHeaders: [
          {
            header: 'Content-Type',
            value: 'application/x-www-form-urlencoded; charset=UTF-8'
          }
        ],
        onSuccess: function(data){
          _clearAutocomplete();
          try {
            _showAutocomplete(data,timestamp,textInput.value);
          } catch (err) {
            console.error('Error updating autocomplete: '+ err);
            triggerCustomEvent(document, 'globalSearch:close');
            triggerCustomEvent(document, 'ajax:getPage', {
              url: queryStringHandler.updateParameter(form.action, 'q', _fixedEncodeURIComponent(textInput.value)),
            });
          }
          _hideLoader();
        },
        onError: function(data){
          _hideLoader();
          triggerCustomEvent(document, 'globalSearch:close');
          triggerCustomEvent(document, 'ajax:getPage', {
            url: queryStringHandler.updateParameter(form.action, 'q', _fixedEncodeURIComponent(textInput.value)),
          });
        }
      });
    }, 250);
  }

  /**
   * Open search
   */
  function _openSearch() {
    triggerCustomEvent(document, 'body:lock', {
      breakpoints: 'all'
    });
    window.requestAnimationFrame(function(){
      document.documentElement.classList.add(stateKlass);
      setTimeout(function(){ setFocusOnTarget(container); }, 0)
      triggerCustomEvent(document, 'focus:trap', {
        element: container
      });
      setTimeout(function(){
        textInput.focus();
      },250);
    });
    active = true;
  }

  /**
   * Close search
   */
  function _closeSearch() {
    active = false;
    clearTimeout(ajaxTimer);
    _hideAutocomplete();
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    document.documentElement.classList.remove(stateKlass);
    // WEB-1985: Because this gets triggered whenever `g-mask` gets closed,
    // it gets triggered for a lot of different things. Attempting to restore
    // focus to `global-search-icon` actually steals focus in most cases.
    // We should update `focus:trap` and `focus:untrap` to save and restore focus.
    // setTimeout(function(){ setFocusOnTarget(document.getElementById('global-search-icon')); }, 0)
    textInput.value = '';
  }

  /**
   * Handle escape key
   */
  function _escape(event) {
    if (active && event.keyCode === 27) {
      triggerCustomEvent(document, 'globalSearch:close');
    }
  }

  /**
   * Doesn't show search on xsmall
   */
  function _resized() {
    if (active && A17.currentMediaQuery !== 'xsmall') {
      triggerCustomEvent(document, 'globalSearch:close');
    }
  }

  /**
   * Handle form submit
   */
  function _handleSubmit(event){
    event.preventDefault();
    let terms = _fixedEncodeURIComponent(textInput.value);
    if (active && terms.length > 0) {
      // If the form has some google tag manager props, tell GTM
      let googleTagManagerObject = googleTagManagerDataFromLink(container);
      if (googleTagManagerObject) {
        googleTagManagerObject['event'] = _fixedEncodeURIComponent(textInput.value);
        triggerCustomEvent(document, 'gtm:push', googleTagManagerObject);
      }
      triggerCustomEvent(document, 'globalSearch:close');
      triggerCustomEvent(document, 'ajax:getPage', {
        url: queryStringHandler.updateParameter(form.action, 'q', terms),
      });
    }
  }

  /**
   * Handle search input
   */
  function _handleInput() {
    if (active) {
      searchTerm = textInput.value;
      if(searchTerm.length >= 3){
        // Do ajax
        _doAjax();
      }else if(searchTerm.length === 0){
        // Hide autocomplete
        _hideAutocomplete();
      }
    }
  }

  function _init() {
    form.addEventListener('submit', _handleSubmit, false);
    document.addEventListener('globalSearch:open', _openSearch, false);
    document.addEventListener('globalSearch:close', _closeSearch, false);
    window.addEventListener('keyup', _escape, false);
    window.addEventListener('resized', _resized, false);
    if (autoCompleteUrl && autoCompleteUrl !== '') {
      textInput.addEventListener('input', _handleInput, false);
      textInput.addEventListener('propertychange', _handleInput, false);
    }
  }

  this.destroy = function() {
    textInput.removeEventListener('input', _handleInput);
    textInput.removeEventListener('propertychange', _handleInput);
    form.removeEventListener('submit', _handleSubmit);
    document.removeEventListener('globalSearch:open', _openSearch);
    document.removeEventListener('globalSearch:close', _closeSearch);
    window.removeEventListener('keyup', _escape);
    window.removeEventListener('resized', _resized);
    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default globalSearch;
