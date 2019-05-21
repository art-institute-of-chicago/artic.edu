import { purgeProperties, queryStringHandler, forEach, getUrlParameterByName, triggerCustomEvent } from '@area17/a17-helpers';
import noUiSlider from '../libs/nouislider';

const rangeSlider = function(container){
  // objects
  const $slideTrack = container.querySelector('[data-range-slider]');
  const $min = container.querySelector('[data-range-thumb-min]');
  const $max = container.querySelector('[data-range-thumb-max]');
  const $range = container.querySelector('[data-range-bar]');
  const $minDisplay = container.querySelector('[data-range-min-display]');
  const $maxDisplay = container.querySelector('[data-range-max-display]');
  const $customFrom = container.querySelector('[data-range-custom-from]');
  const $customTo = container.querySelector('[data-range-custom-to]');
  const $customBtn = container.querySelector('[data-range-custom-btn]');
  const param = container.getAttribute('data-param');
  const bcText = 'BC';
  const adText = 'AD';
  const inputs = [$customFrom, $customTo];
  const displays = [$minDisplay, $maxDisplay];
  let rangeValues;
  let rangeStart = 0;
  let rangeEnd = 0;
  let timer;

  function _findInArray(array, value) {
    let returnIndex = -1;
    forEach(array, function(index, item) {
      if (item === value) {
        returnIndex = index;
      }
    });
    return returnIndex;
  }

  function _prepData(){
    // grab init positions from URL
    let initStart = getUrlParameterByName(param+'-start', window.location.search);
    let initEnd = getUrlParameterByName(param+'-end', window.location.search);

    if (initStart) {
      $customFrom.value = initStart;
    }

    if (initEnd) {
      $customTo.value = initEnd;
    }

    if( initStart || initEnd ){
      var indexes = _setCustomValues();

      rangeStart = indexes.fromIndex;
      rangeEnd = indexes.toIndex;
    }
  }

  function _triggerPageLoad(minIndex, maxIndex) {
    var windowLocationHref = queryStringHandler.updateParameter(window.location.href, param+'-start', rangeValues[minIndex].replace(/\s(AD|BC)/ig,'$1'));
    windowLocationHref = queryStringHandler.updateParameter(windowLocationHref, param+'-end', rangeValues[maxIndex].replace(/\s(AD|BC)/ig,'$1'));
    // trigger ajax call
    triggerCustomEvent(document, 'ajax:getPage', {
      url: windowLocationHref,
      ajaxScrollTarget: 'collection'
    });
  }

  function _createSlider(){
    noUiSlider.create($slideTrack, {
      start: [rangeStart, rangeEnd],
      connect: true,
      step: 1,
      range: {
        min: 0,
        max: rangeValues.length - 1
      },
      format: {
      to: function ( value ) {
        return Math.round(value);
      },
      from: function ( value ) {
        return Math.round(value);
      }
    }
    });

    $slideTrack.noUiSlider.on('update', function( values, handle ) {
      inputs[handle].value = rangeValues[values[handle]];
      displays[handle].innerHTML = rangeValues[values[handle]];
    });
  }

  function _handleClick(e){
    var indexes = _setCustomValues();

    $slideTrack.noUiSlider.updateOptions({
      range: {
        'min': 0,
        'max': rangeValues.length - 1
      }
    });
    $slideTrack.noUiSlider.set([ indexes.fromIndex, indexes.toIndex ]);

    _triggerPageLoad(indexes.fromIndex, indexes.toIndex);

    e.preventDefault();
  }

  function _setCustomValues(e){
    var fromValueRaw = $customFrom.value;
    var toValueRaw = $customTo.value;
    var fromValue = parseInt(fromValueRaw);
    var toValue = parseInt(toValueRaw);
    var fromTextValue = fromValueRaw;
    var toTextValue = toValueRaw;
    var fromExists = _findInArray(rangeValues, fromValueRaw) > -1;
    var toExists = _findInArray(rangeValues, toValueRaw) > -1;

    if( fromValueRaw.indexOf(bcText) > -1 ){
      var fromValue = fromValue * -1;
    }

    // toValue cannot be lower than fromValue
    if( fromValue > toValue ){
      alert('Upper date range must be higher than the lower date range');
      return;
    }

    // From Value
    if( !fromExists && fromValueRaw != null && fromValueRaw != '' ){
      fromTextValue = _updateRangeValues(fromValue);
    }

    // To Value
    if( !toExists && toValueRaw != null && toValueRaw != '' ){
      toTextValue = _updateRangeValues(toValue);
    }

    var fromIndex = _findInArray(rangeValues, fromTextValue) > -1 ? _findInArray(rangeValues, fromTextValue) : 0;
    var toIndex = _findInArray(rangeValues, toTextValue) > -1 ? _findInArray(rangeValues, toTextValue) : rangeValues.length - 1;

    return {fromIndex: fromIndex, toIndex: toIndex};
  }

  function _updateRangeValues(customValue){
    var isBC = false;
    var spliced = false;
    var lastIndex = false;
    var customValIndex = 0;

    if( isNaN( customValue ) ){
      alert( 'Please enter a valid number' );
      return;
    }

    // If fromValue starts with a '-' then search for BC else get AD
    if( customValue < 0 ){
      isBC = true;
    }

    var text = Math.abs(customValue) + (isBC ? ' '+bcText : ' '+adText);

    // find nearest number in array of values
    // loop all values
    rangeValues.forEach( function(val, index) {
      var parsedVal = parseInt(val);

      if( isBC ){
        // if isBC == true then check if value contains 'BC'
        if( val.indexOf(bcText) != -1 ){
          // convert BC numbers to negative
          var negVal = parsedVal * -1;

          // check if value is less than current index value
          if( customValue <= negVal && spliced == false){
            // insert value into array at location of nearest number

            if( rangeValues.indexOf(text) == -1 ){
              rangeValues.splice(index, 0, Math.abs(customValue) + bcText );
            }

            spliced = true;
            customValIndex = index;
          }

          lastIndex = index;
        }
      }else{
        // else check if it contains 'AD'
        if( val.indexOf(adText) != -1 ){
          // check if value is greater than current index value
          if( customValue <= parsedVal && spliced == false){
            // insert value into array at location of nearest number
            if( rangeValues.indexOf(text) == -1 ){
              rangeValues.splice(index, 0, text );
            }
            spliced = true;
            customValIndex = index;
          }

          lastIndex = index;
        }
      }
    });

    // if not then insert into array at current index
    if( !spliced && lastIndex ){
      rangeValues.splice(lastIndex + 1, 0, Math.abs(customValue) + (isBC ? bcText : adText) );
      customValIndex = lastIndex + 1;
    }

    return text;
  }

  function _init() {
    rangeValues = A17[container.getAttribute('data-range-values')] || ['0','25','50','75','100'];
    rangeEnd = rangeValues.length - 1;
    _prepData();
    _createSlider();
    $customBtn.addEventListener('click', _handleClick, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    $customBtn.removeEventListener('click', _handleClick);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default rangeSlider;
