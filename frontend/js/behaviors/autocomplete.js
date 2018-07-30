import { purgeProperties, ajaxRequest, triggerCustomEvent, queryStringHandler } from '@area17/a17-helpers';
import { googleTagManagerDataFromLink } from '../functions';

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
  function _showAutocomplete(data) {
    data = JSON.parse(data);
    if (data.length > 0) {
      dropdownList = document.createElement('ul');
      dropdownList.className = 'm-search-bar__autocomplete f-secondary';
      dropdownList.setAttribute('data-autocomplete-list','');
      let ulItems = '';
      for (let i = 0; i < Math.min(5, data.length); i++) {
        let title = data[i].title;
        switch (data[i].api_model) {
          case 'agents':
            let datum = {
              query: 'artist_ids='+title.replace(/\s/g,'+'),
              title: 'Artworks by "<b>'+title+'</b>"',
            };
          break;
        }
        ulItems += '<li><a href="/collection?'+datum.query+'">'+datum.title+'</a></li>\n';
      }
      dropdownList.innerHTML = ulItems;
      container.appendChild(dropdownList);
      container.classList.add(autocompleteActiveKlass);
      active = true;
    }
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
      let qs = queryStringHandler.fromObject({
        resources: [
          'artists',
        ],
        q: textInput.value,
      });
      let xhr = new XMLHttpRequest();
      xhr.open('get', autoCompleteUrl + qs, true);
      xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
          _closeAutocomplete();
          try {
            _showAutocomplete(xhr.responseText);
          } catch (err) {
            console.error('Error updating autocomplete: '+ err);
          }
          _hideLoader();
        } else {
          console.error('Autocomplete error:',xhr.responseText,xhr.status);
          _hideLoader();
        }
      };
      xhr.onerror = function() {
        console.error('Autocomplete error:',xhr.responseText,xhr.status);
        _hideLoader();
      };

      xhr.send();
    }, 250);
  }

  // handle submit
  function _handleSubmit(event) {
    event.preventDefault();
    // trigger ajax call
    triggerCustomEvent(document, 'ajax:getPage', {
      url: queryStringHandler.updateParameter(container.action, 'q', _fixedEncodeURIComponent(textInput.value)),
    });
    // if the form has some google tag manager props, tell GTM
    let googleTagManagerObject = googleTagManagerDataFromLink(container);
    if (googleTagManagerObject) {
      triggerCustomEvent(document, 'gtm:push', googleTagManagerObject);
    }
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

  function _clearInput(event) {
    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }
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

    if(textInput.value !== '') {
      container.classList.add(autocompleteActiveKlass);
    }
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
