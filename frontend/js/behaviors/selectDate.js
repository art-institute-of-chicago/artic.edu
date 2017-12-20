import { setFocusOnTarget, purgeProperties, triggerCustomEvent } from 'a17-helpers';
import { positionElementToTarget } from '../functions';

const selectDate = function(container) {

  const calendar = document.getElementById('calendar');
  const opener = container.querySelector('[data-selectDate-open]');
  const display = container.querySelector('[data-selectDate-display]');
  const dateSelectedClass = 's-date-selected';
  const defaultMinDate = 'today';

  let calendarOpen = false;
  let minDate = defaultMinDate;

  function _closeCalendar(datesSelected) {
    if (!datesSelected) {
      display.textContent = '';
      container.classList.remove(dateSelectedClass);
    }
    if (calendarOpen) {
      document.documentElement.classList.remove('s-calendar-active');
      triggerCustomEvent(document, 'body:unlock');
      calendar.removeAttribute('style');
      triggerCustomEvent(document, 'focus:untrap');
      setFocusOnTarget(container.parentNode);
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
        minDate: minDate
      });
      triggerCustomEvent(document, 'body:lock', {
        breakpoints: 'xsmall small'
      });
      positionElementToTarget({
        element: calendar,
        target: container,
        padding: {
          left: -20,
          top: 20
        }
      });
      setFocusOnTarget(calendar);
      triggerCustomEvent(document, 'focus:trap', {
        element: calendar
      });
      calendarOpen = true;
    } else {
      _closeCalendar();
    }
  }

  function _datesSelected(event) {
    if (calendarOpen && event) {
      if (event && event.data && event.data.dates) {
        if (event.data.dates.start === event.data.dates.end) {
          display.textContent = event.data.dates.start.dateFriendlyString;
        } else {
          display.textContent = event.data.dates.start.dateFriendlyString + ' - ' + event.data.dates.end.dateFriendlyString;
        }
        container.classList.add(dateSelectedClass);
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

  function _init() {
    opener.addEventListener('click', _openCalendar, false);
    container.addEventListener('calendar:datesSelected', _datesSelected, false);
    document.addEventListener('selectDate:close', _closeCalendar, false);
    document.addEventListener('click', _clicksOutside, false);
    window.addEventListener('keyup', _escape, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    opener.removeEventListener('click', _openCalendar);
    container.removeEventListener('calendar:datesSelected', _datesSelected);
    document.removeEventListener('selectDate:close', _closeCalendar);
    document.removeEventListener('click', _clicksOutside);
    window.removeEventListener('keyup', _escape);

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default selectDate;
