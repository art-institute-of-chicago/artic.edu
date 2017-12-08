import { setFocusOnTarget, purgeProperties, triggerCustomEvent } from 'a17-helpers';
import { positionElementToTarget } from '../functions';

const selectDate = function(container) {

  const calendar = document.getElementById('calendar');
  const opener = container.querySelector('[data-selectDate-open]');
  const clear = container.querySelector('[data-selectDate-clear]');
  const display = container.querySelector('[data-selectDate-display]');
  const hiddenInput = container.querySelector('input[type=hidden]');
  const linked = (container.getAttribute('data-selectDate-range') === 'true');
  const linkedSelectDate = document.querySelector('[data-selectDate-id=' + container.getAttribute('data-selectDate-linkedId') + ']') || false;
  const role = (linked) ? container.getAttribute('data-selectDate-role') : false;
  const dateSelectedClass = 's-date-selected';
  const defaultMinDate = 'today';

  let calendarOpen = false;
  let minDate = defaultMinDate;

  function _closeCalendar() {
    if (calendarOpen) {
      document.documentElement.classList.remove('s-calendar-active');
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
      positionElementToTarget({
        element: calendar,
        target: container,
        padding: {
          left: -20,
          top: 20
        }
      });
      setFocusOnTarget(calendar);
      calendarOpen = true;
    } else {
      _closeCalendar();
    }
  }

  function _clearSelected(event) {
    event.preventDefault();
    clear.blur();
    container.classList.remove(dateSelectedClass);
    display.textContent = '';
    if (hiddenInput) {
      hiddenInput.value = '';
    }
    if (linked && linkedSelectDate && role && role === 'start') {
      triggerCustomEvent(linkedSelectDate, 'selectDate:startDateCleared');
    }
  }

  function _dateSelected(event) {
    if (calendarOpen && event) {
      if (event.data.friendlyString) {
        display.textContent = event.data.friendlyString;
      }
      if (hiddenInput && event.data.dateString) {
        container.classList.add(dateSelectedClass);
        hiddenInput.value = event.data.dateString;
      }
      _closeCalendar();
      if (linked && linkedSelectDate && role && role === 'start' && event.data.dateObj) {
        // if this is the start date of a range selector, tell the end about this
        triggerCustomEvent(linkedSelectDate, 'selectDate:startDateCleared');
        // add a day to the chosen date to make the end selector min date
        let minDate = event.data.dateObj;
        minDate = new Date(minDate.setDate(minDate.getDate() + 1));
        // tell the end date selector about this min date
        triggerCustomEvent(linkedSelectDate, 'selectDate:startDateSelected', {
          minDate: minDate
        });
      }
      if (!linked && !hiddenInput && event.data.href) {
        window.location.href = event.data.href;
      }
    }
  }

  function _startDateSelected(event) {
    if (linked && linkedSelectDate && role && role === 'end' && event && event.data.minDate) {
      // if this is the end date selector and the start date has been selected
      // tell the calendar to update
      minDate = event.data.minDate;
      triggerCustomEvent(calendar, 'calendar:minDate', {
        minDate: minDate
      });
      _openCalendar(event);
    }
  }

  function _startDateCleared(event) {
    _clearSelected(event);
    minDate = defaultMinDate;
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
    clear.addEventListener('click', _clearSelected, false);
    container.addEventListener('calendar:dateSelected', _dateSelected, false);
    container.addEventListener('selectDate:startDateSelected', _startDateSelected, false);
    container.addEventListener('selectDate:startDateCleared', _startDateCleared, false);
    document.addEventListener('selectDate:close', _closeCalendar, false);
    document.addEventListener('click', _clicksOutside, false);
    window.addEventListener('keyup', _escape, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    opener.removeEventListener('click', _openCalendar);
    clear.removeEventListener('click', _clearSelected);
    container.removeEventListener('calendar:dateSelected', _dateSelected);
    container.removeEventListener('selectDate:startDateSelected', _startDateSelected);
    container.removeEventListener('selectDate:startDateCleared', _startDateCleared);
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
