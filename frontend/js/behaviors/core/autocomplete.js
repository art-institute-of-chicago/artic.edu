import { triggerCustomEvent, queryStringHandler } from '@area17/a17-helpers';
import { googleTagManagerDataFromLink } from '../../functions/core';

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

  function _fixedEncodeURIComponent(str) {
    return encodeURIComponent(str).replace(/[!'()*]/g, function(c) {
      return '%' + c.charCodeAt(0).toString(16);
    });
  }

  /**
   * Very light weight, designed to handle what this autocomplete needs rather than a general utf8 string converter
   */
  function _utf8String(str) {
    return _fixedEncodeURIComponent(str.replace(/<(?:.|\n)*?>/gm, '').replace(/"|'/gm, '')).replace(/%20/gm, '-').toLowerCase();
  }

  /**
   * Show autocomplete
   */
  function _showAutocomplete(responseData) {
    let multiData = JSON.parse(responseData);
    let accessionData = multiData[0];
    let artworkData = multiData[1];
    let otherData = multiData[2];
    let ulItems = '';

    if (accessionData.length < 1 && artworkData.length < 1 && otherData.length < 1) {
      return;
    }

    dropdownList = document.createElement('ul');
    dropdownList.className = 'm-search-bar__autocomplete f-secondary';
    dropdownList.setAttribute('data-autocomplete-list','');

    var _getAutocompleteItems = function (data, minValue) {
      let ulItems = '';
      for (let i = 0; i < Math.min(minValue, data.length); i++) {
        let title = data[i].title;
        let titleUrl = encodeURIComponent(title).replace(/%20/g,'+');
        let datum = null;
        switch (data[i].api_model) {
          case 'agents':
            datum = {
              query: 'artist_ids='+titleUrl,
              title: 'by "<b>'+title+'</b>"',
            };
          break;
          case 'artworks':
            datum = {
              path: '/artworks/'+data[i].id,
              title: 'see "<b>'+title+'</b>" ('+data[i].main_reference_number+')',
            };
          break;
          case 'category-terms':
            switch (data[i].subtype) {
              case 'classification':
                datum = {
                  query: 'classification_ids='+titleUrl,
                  title: 'classified as "<b>'+title+'</b>"',
                };
              break;
              case 'material':
                datum = {
                  query: 'material_ids='+titleUrl,
                  title: 'made of "<b>'+title+'</b>"',
                };
              break;
              case 'technique':
                datum = {
                  query: 'technique_ids='+data[i].id,
                  title: 'made via "<b>'+title+'</b>"',
                };
              break;
              case 'style':
                datum = {
                  query: 'style_ids='+titleUrl,
                  title: 'in the style of "<b>'+title+'</b>"',
                };
              break;
              case 'subject':
                datum = {
                  query: 'subject_ids='+titleUrl,
                  title: 'about "<b>'+title+'</b>"',
                };
              break;
              case 'department':
                datum = {
                  query: 'department_ids='+titleUrl,
                  title: 'in the department "<b>'+title+'</b>"',
                };
              break;
              case 'theme':
                datum = {
                  query: 'theme_ids='+data[i].id,
                  title: 'related to "<b>'+title+'</b>"',
                };
              break;
            }
          break;
        }
        if (datum) {
          let href = '/collection?'+datum.query;
          if (datum.path) {
            href = datum.path;
          }
          ulItems += '<li><a href="'+href+'" data-ajax-scroll-target="collection" data-gtm-event="'+_utf8String(datum.title)+'" data-gtm-action="discover-art-artists" data-gtm-event-category="collection-filter">'+datum.title+'</a></li>\n';
        }
      }
      return ulItems;
    }

    ulItems += _getAutocompleteItems(accessionData, 1);
    ulItems += _getAutocompleteItems(artworkData, 1);
    ulItems += _getAutocompleteItems(otherData, 5);

    ulItems += (
      '<li><a href="/collection?q='+_utf8String(textInput.value)+'" data-ajax-scroll-target="collection" data-gtm-event="'+_fixedEncodeURIComponent(textInput.value)+'" data-gtm-action="discover-art-artists" data-gtm-event-category="collection-filter" class="suggestion--fulltext">' +
      '<svg class="icon--search--24"><use xlink:href="#icon--search--24" /></svg>' +
      '<span>Search for "'+textInput.value+'"</span></a></li>\n'
    );

    dropdownList.innerHTML = ulItems;
    container.appendChild(dropdownList);
    container.classList.add(autocompleteActiveKlass);
    active = true;
  }

  /**
   * Hide autocomplete
   */
  function _closeAutocomplete() {
    _hideAutocomplete();
    textInput.focus();
  }

  /**
   * Hide autocomplete
   */
  function _hideAutocomplete() {
    container.classList.remove(autocompleteActiveKlass);
    if (dropdownList) {
      container.removeChild(dropdownList);
      dropdownList = null;
    }
    active = false;
  }

  /**
   * Handle ajax search
   */
  function _doAjax() {
    clearTimeout(ajaxTimer);

    _showLoader();

    ajaxTimer = setTimeout(function(){

      var qs = '?' + _arrayQueryStringHandler([
        {
          fuzzy: false,
          q: textInput.value,
          resources: [
            'artworks',
          ],
          contexts: [
            'accession',
          ],
        },
        {
          q: textInput.value,
          resources: [
            'artworks',
          ],
          contexts: [
            'title',
          ],
        },
        {
          q: textInput.value,
          resources: [
            'artists',
            'category-terms',
          ],
          contexts: [
            'title',
          ],
        },
      ]);

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

  /**
   * Handle submit
   */
  function _handleSubmit(event) {
    event.preventDefault();
    // If the form has some google tag manager props, tell GTM
    let googleTagManagerObject = googleTagManagerDataFromLink(container);
    if (googleTagManagerObject) {
      googleTagManagerObject['event'] = _fixedEncodeURIComponent(textInput.value);
      triggerCustomEvent(document, 'gtm:push', googleTagManagerObject);
    }
    // Trigger ajax call
    triggerCustomEvent(document, 'ajax:getPage', {
      url: queryStringHandler.updateParameter(container.action, 'q', _fixedEncodeURIComponent(textInput.value)),
    });
  }

  /**
   * Handle search input
   */
  function _handleInput() {
    searchTerm = textInput.value;
    if(searchTerm.length >= 3){
      // Do ajax
      _doAjax();
    }else if(searchTerm.length == 0){
      // Hide autocomplete
      _hideAutocomplete();
    }
  }

  function _isAccessionNumber(val) {
    return /^\d/.test(val);
  }

  /**
   * QueryStringhandler cannot handle top-level arrays
   * @see adapted from http://locutus.io/php/url/http_build_query/
   */
  function _arrayQueryStringHandler(formdata) {
    const argSeparator = '&'

    const _httpBuildQueryHelper = function (key, val) {
      if (val === true) {
        val = '1'
      } else if (val === false) {
        val = '0'
      }
      if (val !== null) {
        if (typeof val === 'object') {
          let serialized = []
          for (const k in val) {
            if (val[k] !== null) {
              serialized.push(_httpBuildQueryHelper(key + '[' + k + ']', val[k]))
            }
          }
          return serialized.join(argSeparator)
        } else if (typeof val !== 'function') {
          return _encodeURIComponent(key) + '=' + _encodeURIComponent(val)
        } else {
          throw new Error('There was an error processing for http_build_query().')
        }
      } else {
        return ''
      }
    }

    let queryItems = []
    for (const key in formdata) {
      const query = _httpBuildQueryHelper(key, formdata[key])
      if (query !== '') {
        queryItems.push(query)
      }
    }

    return queryItems.join(argSeparator)
  }

  /**
   * Extracted from queryStringhandler
   */
  function _encodeURIComponent(value) {
    return encodeURIComponent(value)
      .replace(/[!'()]/g, '')
      .replace(/\*/g, '%2A')
      .replace(/%2B/ig, '+')
      .replace(/%5B/ig, '[')
      .replace(/%5D/ig, ']');
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
    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default autocomplete;
