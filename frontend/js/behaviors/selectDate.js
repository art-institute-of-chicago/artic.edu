import { setFocusOnTarget, purgeProperties, triggerCustomEvent } from 'a17-helpers';
import { positionElementToTarget } from '../functions';

const selectDate = function(container) {

  const calendar = document.getElementById('calendar');
  const opener = document.querySelector('[data-selectDate-open]');
  const clear = document.querySelector('[data-selectDate-clear]');
  const display = document.querySelector('[data-selectDate-display]');
  const dateSelectedClass = 's-date-selected';

  let calendarOpen = false;

  function _closeCalendar() {
    if (calendarOpen) {
      document.documentElement.classList.remove('s-calendar-active');
      setFocusOnTarget(container.parentNode);
      calendarOpen = false;
    }
  }

  function _openCalendar(event) {
    event.preventDefault();
    opener.blur();
    if (!calendarOpen) {
      document.documentElement.classList.add('s-calendar-active');
      positionElementToTarget({
        element: calendar,
        target: container,
        padding: {
          left: -20,
          top: 20
        }
      });
      setFocusOnTarget(calendar);
      triggerCustomEvent(calendar, 'calendar:opener', { el: container });
      calendarOpen = true;
    } else {
      _closeCalendar();
    }
  }

  function _clearSelected() {
    event.preventDefault();
    opener.blur();
    container.classList.remove(dateSelectedClass);
    display.textContent = '';
  }

  function _dateSelected(event) {
    if (calendarOpen && event && event.data.date && event.data.friendlyString) {
      display.textContent = event.data.friendlyString;
      container.classList.add(dateSelectedClass);
    }
    _closeCalendar();
  }

  function _init() {
    opener.addEventListener('click', _openCalendar, false);
    clear.addEventListener('click', _clearSelected, false);
    container.addEventListener('calendar:dateSelected', _dateSelected, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    opener.removeEventListener('click', _openCalendar);
    clear.removeEventListener('click', _clearSelected, false);
    container.removeEventListener('calendar:dateSelected', _dateSelected);

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default selectDate;
