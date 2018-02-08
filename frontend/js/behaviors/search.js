import { purgeProperties, setFocusOnTarget, forEach, triggerCustomEvent, ajaxRequest } from 'a17-helpers';
import { focusTrap } from '../functions';

const search = function(container) {
  var openTriggers = document.querySelectorAll('[data-search-open]');
  var closeTriggers = document.querySelectorAll('[data-search-close]');
  var textInput = container.querySelector('input[type="search"]');
  var form = container.querySelector('form');
  var autocomplete = container.querySelector('[data-autocomplete]');
  var stateKlass ='s-search-active';
  var autocompleteKlass = 's-search-active--autocomplete';
  var loaderKlass = 's-search-active--loader';
  var s = '';
  var ajaxTimer;

  // open search
  function _open(e) {
    document.documentElement.classList.add(stateKlass);
    _lockBody();

    e.preventDefault();
  }

  // close search
  function _close(e) {
    document.documentElement.classList.remove(stateKlass);
    _unlockBody();

    e.preventDefault();
  }

  // handle search input
  function _handleInput() {
    s = textInput.value;

    if( s.length >= 3 ){
      // do ajax
      _doAjax();
    }else if(s.length == 0){
      // hide autocomplete
      _hideAutocomplete();
    }
  }

  // handle form submit
  function _handleForm(e){
    _handleInput();

    e.preventDefault();
  }

  // handle ajax search
  function _doAjax() {
    clearTimeout(ajaxTimer);

    _showLoader();

    ajaxTimer = setTimeout(function(){
      ajaxRequest({
        url: '/autocomplete/'+ s,
        type: 'GET',
        requestHeaders: [
          {
              header: 'Content-Type',
              value: 'application/x-www-form-urlencoded; charset=UTF-8'
          }
        ],
        onSuccess: function(data){
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

  function _showLoader() {
    document.documentElement.classList.add(loaderKlass);
  }

  function _hideLoader() {
    document.documentElement.classList.remove(loaderKlass);
  }

  // show autocomplete
  function _showAutocomplete(content) {
    document.documentElement.classList.add(autocompleteKlass);

    autocomplete.innerHTML = content;
  }

  // hide autocomplete
  function _hideAutocomplete() {
    document.documentElement.classList.remove(autocompleteKlass);

    autocomplete.innerHTML = '';

    _hideLoader();
  }

  function _lockBody(){
    triggerCustomEvent(document, 'body:lock', {
      breakpoints: 'xsmall small medium large xlarge'
    });
    setFocusOnTarget(container);
    triggerCustomEvent(document, 'focus:trap', {
      element: container
    });
  }

  function _unlockBody(){
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    setFocusOnTarget(document.getElementById('a17'));
  }

  function _init() {
    forEach(openTriggers, function(index, openTrigger) {
      openTrigger.addEventListener('click', _open, false);
    });

    forEach(closeTriggers, function(index, closeTrigger) {
      closeTrigger.addEventListener('click', _close, false);
    });

    document.addEventListener('search:close', _close, false);

    textInput.addEventListener('input', _handleInput, false);
    textInput.addEventListener('propertychange', _handleInput, false);

    form.addEventListener('submit', _handleForm, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    forEach(openTriggers, function(index, openTrigger) {
      openTrigger.removeEventListener('click', _open);
    });

    forEach(closeTriggers, function(index, closeTrigger) {
      closeTrigger.removeEventListener('click', _close);
    });

    textInput.removeEventListener('input', _handleInput);
    textInput.removeEventListener('propertychange', _handleInput);

    form.removeEventListener('submit', _handleForm);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default search;
