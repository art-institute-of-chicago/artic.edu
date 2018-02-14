import { purgeProperties, setFocusOnTarget, forEach, triggerCustomEvent, ajaxRequest } from 'a17-helpers';
import { focusTrap } from '../functions';

const autocomplete = function(container) {
  var textInput = container.querySelector('input[type="text"]');
  var autocomplete = container.querySelector('[data-autocomplete]');
  var loaderKlass = 'm-search-bar--loading';
  var s = '';
  var ajaxTimer;

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

  function _updateVal(e){
    textInput.value = this.text;

    _hideAutocomplete();

    e.preventDefault();
  }

  // handle ajax search
  function _doAjax() {
    clearTimeout(ajaxTimer);

    _showLoader();

    ajaxTimer = setTimeout(function(){
      ajaxRequest({
        url: '/collection/search/'+ s,
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
    container.classList.add(loaderKlass);
  }

  function _hideLoader() {
    container.classList.remove(loaderKlass);
  }

  // show autocomplete
  function _showAutocomplete(content) {
    autocomplete.innerHTML = content;

    _addAutocompleteHandlers();
  }

  // hide autocomplete
  function _hideAutocomplete() {
    autocomplete.innerHTML = '';
  }

  // hide autocomplete
  function _closeAutocomplete() {
    _hideAutocomplete();

    textInput.focus();
  }

  function _addAutocompleteHandlers(){
    var results = autocomplete.querySelectorAll('li a');
    var close = autocomplete.querySelector('[data-autocomplete-close]');

    close.addEventListener('click', _closeAutocomplete, false);

    forEach(results, function(index, result) {
      result.addEventListener('click', _updateVal, false);
    });
  }

  function _init() {
    textInput.addEventListener('input', _handleInput, false);
    textInput.addEventListener('propertychange', _handleInput, false);

    container.addEventListener('submit', _handleForm, false);
  }

  this.destroy = function() {
    textInput.removeEventListener('input', _handleInput);
    textInput.removeEventListener('propertychange', _handleInput);

    container.removeEventListener('submit', _handleForm);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default autocomplete;
