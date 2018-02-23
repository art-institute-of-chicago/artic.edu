import { purgeProperties, ajaxRequest, triggerCustomEvent, queryStringHandler } from '@area17/a17-helpers';

const autocomplete = function(container) {
  const autoCompleteUrl = container.getAttribute('data-autocomplete-url');

  if (!autoCompleteUrl || autoCompleteUrl === '') {
    return;
  }

  const textInput = container.querySelector('input[type="text"]');
  const clearBtn = container.querySelector('[data-autocomplete-clear]');
  const loaderKlass = 's-loading';
  const autocompleteActiveKlass = 's-autocomplete-active';

  let active = false;
  let searchTerm = '';
  let dropdownList;
  let ajaxTimer;

  function _showLoader() {
    container.classList.add(loaderKlass);
  }

  function _hideLoader() {
    container.classList.remove(loaderKlass);
  }

  // show autocomplete
  function _showAutocomplete(content) {
    let parser = new DOMParser();
    let doc = parser.parseFromString(content, 'text/html');
    dropdownList = doc.querySelector('[data-autocomplete-list]');
    if (dropdownList) {
      container.appendChild(dropdownList);
    }
    container.classList.add(autocompleteActiveKlass);
    active = true;
  }

  // hide autocomplete
  function _closeAutocomplete() {
    _hideAutocomplete();
    textInput.focus();
  }

  // hide autocomplete
  function _hideAutocomplete() {
    container.classList.remove(autocompleteActiveKlass);
    if (dropdownList) {
      container.removeChild(dropdownList);
      dropdownList = null;
    }
    active = false;
  }

  function _fixedEncodeURIComponent(str) {
    return encodeURIComponent(str).replace(/[!'()*]/g, function(c) {
      return '%' + c.charCodeAt(0).toString(16);
    });
  }

  // handle ajax search
  function _doAjax() {
    clearTimeout(ajaxTimer);

    _showLoader();

    ajaxTimer = setTimeout(function(){
      ajaxRequest({
        url: autoCompleteUrl,
        data: { q: _fixedEncodeURIComponent(textInput.value) },
        type: 'GET',
        requestHeaders: [
          {
            header: 'Content-Type',
            value: 'application/x-www-form-urlencoded; charset=UTF-8'
          }
        ],
        onSuccess: function(data){
          _closeAutocomplete();
          try {
            _showAutocomplete(data);
          } catch (err) {
            console.error('Error updating autocomplete: '+ err);
          }
          _hideLoader();
        },
        onError: function(data){
          console.error('Error: '+ data);
          _hideLoader();
        }
      });
    }, 250);
  }

  // handle submit
  function _handleSubmit(event) {
    event.preventDefault();
    // trigger ajax call
    triggerCustomEvent(document, 'ajax:getPage', {
      url: queryStringHandler.updateParameter(container.action, 'q', _fixedEncodeURIComponent(textInput.value)),
    });
  }

  // handle search input
  function _handleInput() {
    searchTerm = textInput.value;
    if(searchTerm.length >= 3){
      // do ajax
      _doAjax();
    }else if(searchTerm.length == 0){
      // hide autocomplete
      _hideAutocomplete();
    }
  }

  function _clearInput() {
    _closeAutocomplete();
    textInput.value = '';
  }

  function _clicks(event) {
    if (active && document.activeElement !== container && !container.contains(document.activeElement)) {
      event.preventDefault();
      event.stopPropagation();
      _hideAutocomplete();
    }
  }

  function _touchstart(event) {
    if (active && event.target !== container && !container.contains(event.target)) {
      event.preventDefault();
      event.stopPropagation();
      _hideAutocomplete();
    }
  }

  function _escape(event) {
    if (active && event.keyCode === 27) {
      _hideAutocomplete();
    }
  }

  function _init() {
    textInput.addEventListener('input', _handleInput, false);
    textInput.addEventListener('propertychange', _handleInput, false);
    container.addEventListener('submit', _handleSubmit, false);
    clearBtn.addEventListener('click', _clearInput, false);
    document.addEventListener('click', _clicks, false);
    document.addEventListener('touchstart', _touchstart, false);
    window.addEventListener('keyup', _escape, false);
  }

  this.destroy = function() {
    textInput.removeEventListener('input', _handleInput);
    textInput.removeEventListener('propertychange', _handleInput);
    container.removeEventListener('submit', _handleSubmit);
    clearBtn.removeEventListener('click', _clearInput);
    document.removeEventListener('click', _clicks);
    document.removeEventListener('touchstart', _touchstart);
    window.removeEventListener('keyup', _escape);
    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default autocomplete;
