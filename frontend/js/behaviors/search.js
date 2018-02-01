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
            document.documentElement.classList.add(autocompleteKlass);
            autocomplete.innerHTML = data;
          } catch (err) {
            console.error('Error updating autocomplete: '+ err);
          }
        },
        onError: function(data){
          clearTimeout(ajaxTimer);
          console.error('Error: '+ data);
        }
      });
    }, 250);
  }

  // hide autocomplete
  function _hideAutocomplete() {
    document.documentElement.classList.remove(autocompleteKlass);
    autocomplete.innerHTML = '';
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
