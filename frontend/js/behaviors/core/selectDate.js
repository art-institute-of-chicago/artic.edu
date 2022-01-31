import { setFocusOnTarget, triggerCustomEvent, queryStringHandler } from '@area17/a17-helpers';
import { positionElementToTarget, googleTagManagerDataFromLink } from '../../functions/core';

const selectDate = function(container) {

  const calendar = document.getElementById('calendar');
  const mode = (container.getAttribute('data-selectDate-mode') === 'range') ? 'range' : 'single';
  const displayFormat = container.getAttribute('data-selectDate-displayFormat') || 'shortUS';
  const opener = container.querySelector('[data-selectDate-open]');
  const display = container.querySelector('[data-selectDate-display]');
  const dateSelectedClass = 's-date-selected';
  const defaultMinDate = 'today';

  let calendarOpen = false;
  let minDate = defaultMinDate;
  let displayStr = '';

  function _updateDisplay() {
    if (display.tagName.toLowerCase() === 'input') {
      display.value = displayStr;
    } else {
      display.textContent = displayStr;
    }
  }

  function _closeCalendar(datesSelected) {
    if (!datesSelected) {
      displayStr = '';
      _updateDisplay();
      container.classList.remove(dateSelectedClass);
    }
    if (calendarOpen) {
      document.documentElement.classList.remove('s-calendar-active');
      triggerCustomEvent(document, 'body:unlock');
      calendar.classList.remove('js-positioned');
      calendar.removeAttribute('style');
      triggerCustomEvent(document, 'focus:untrap');
      setTimeout(function(){ setFocusOnTarget(container.parentNode); }, 0)
      calendarOpen = false;
    }
  }

  function _openCalendar(event) {
    event.preventDefault();
    event.stopPropagation();
    opener.blur();
    if (!calendarOpen) {
      document.documentElement.classList.add('s-calendar-active');
      triggerCustomEvent(calendar, 'calendar:opener', {
        el: container,
        minDate: minDate,
        mode: mode,
      });
      triggerCustomEvent(document, 'body:lock', {
        breakpoints: 'xsmall small'
      });
      if (A17.currentMediaQuery.indexOf('small') < 0) {
        positionElementToTarget({
          element: calendar,
          target: container,
          padding: {
            left: -20,
            top: 20
          }
        });
      }
      setTimeout(function(){ setFocusOnTarget(calendar); }, 0)
      triggerCustomEvent(document, 'focus:trap', {
        element: calendar
      });
      calendarOpen = true;
      // If the opener has some google tag manager props, tell GTM
      let googleTagManagerObject = googleTagManagerDataFromLink(container);
      if (googleTagManagerObject) {
        triggerCustomEvent(document, 'gtm:push', googleTagManagerObject);
      }
    } else {
      _closeCalendar();
    }
  }

  function _dateSelected(event) {
    if (event && event.data && mode === 'range') {
      if (event.data.start) {
        displayStr = event.data.start[displayFormat];
      }
      if (event.data.end) {
        displayStr += ' – ' + event.data.end[displayFormat];
      }
      if (event.data.start || event.data.end) {
        _updateDisplay();
        container.classList.add(dateSelectedClass);
      }
    }
  }

  function _datesSelected(event) {
    if (calendarOpen && event) {
      if (event && event.data && event.data.dates) {
        displayStr = event.data.dates.start[displayFormat];
        if (event.data.dates.start.string !== event.data.dates.end.string) {
          displayStr = event.data.dates.start[displayFormat] + ' – ' + event.data.dates.end[displayFormat];
        } else {
          displayStr = event.data.dates.start[displayFormat];
        }
        _updateDisplay();
        container.classList.add(dateSelectedClass);
        //
        if (display.tagName.toLowerCase() !== 'input') {
          var windowLocationHref = queryStringHandler.updateParameter(window.location.href, 'start', event.data.dates.start.iso);
          windowLocationHref = queryStringHandler.updateParameter(windowLocationHref, 'end', event.data.dates.end.iso);
          windowLocationHref = windowLocationHref.replace(/time=weekend&/ig,'');
          // Trigger ajax call
          triggerCustomEvent(document, 'ajax:getPage', {
            url: windowLocationHref,
          });
        }
      }
      _closeCalendar(true);
    }
  }

  function _clicksOutside(event) {
    if (calendarOpen) {
      event.preventDefault();
      event.stopPropagation();
      _closeCalendar();
    }
  }

  function _escape(event) {
    var isInput = (event.target.tagName === 'INPUT');
    if (calendarOpen && event.keyCode === 27 && !isInput) {
      _closeCalendar();
    }
  }

  function _resized() {
    _closeCalendar(true);
  }

  function _init() {
    opener.addEventListener('click', _openCalendar, false);
    container.addEventListener('calendar:dateSelected', _dateSelected, false);
    container.addEventListener('calendar:datesSelected', _datesSelected, false);
    document.addEventListener('selectDate:close', _closeCalendar, false);
    document.addEventListener('click', _clicksOutside, false);
    window.addEventListener('keyup', _escape, false);
    window.addEventListener('resized', _resized, false);
  }

  this.destroy = function() {
    // Remove specific event handlers
    opener.removeEventListener('click', _openCalendar);
    container.removeEventListener('calendar:dateSelected', _dateSelected);
    container.removeEventListener('calendar:datesSelected', _datesSelected);
    document.removeEventListener('selectDate:close', _closeCalendar);
    document.removeEventListener('click', _clicksOutside);
    window.removeEventListener('keyup', _escape);
    window.removeEventListener('resized', _resized);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default selectDate;
