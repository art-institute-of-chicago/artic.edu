import { purgeProperties, triggerCustomEvent, queryStringHandler, forEach } from '@area17/a17-helpers';

const calendar = function(container) {

  const searchUrl = container.getAttribute('data-calendar-url') || '/';

  let today, todayDate, todayMonth, todayYear, minDate;

  let monthsVisible = 0;
  let monthDivs = [];

  let opener = false;

  let currentMonth;
  let currentYear;
  let months = [];
  let monthLengths = [];
  let daysHtml = '';

  let $monthsContainer, $template, $start, $end;

  let datesSelected = {};
  let mode = 'single'; // range or single
  let selecting = 'start';

  datesSelected.start = {};
  datesSelected.end = {};

  // give the months some names
  months[0] = 'Jan';
  months[1] = 'Feb';
  months[2] = 'Mar';
  months[3] = 'Apr';
  months[4] = 'May';
  months[5] = 'Jun';
  months[6] = 'Jul';
  months[7] = 'Aug';
  months[8] = 'Sep';
  months[9] = 'Oct';
  months[10] = 'Nov';
  months[11] = 'Dec';

  // how many days in each month

  monthLengths[0] = 31;
  monthLengths[1] = 28; // will be updated in generate calendar func for leap years
  monthLengths[2] = 31;
  monthLengths[3] = 30;
  monthLengths[4] = 31;
  monthLengths[5] = 30;
  monthLengths[6] = 31;
  monthLengths[7] = 31;
  monthLengths[8] = 30;
  monthLengths[9] = 31;
  monthLengths[10] = 30;
  monthLengths[11] = 31;

  function _parseDateString(str) {
    return new Date(parseInt(str.substring(0,4)), (parseInt(str.substring(4,6)) - 1), parseInt(str.substring(6,8)));
  }

  function _normaliseYearMonth(){
    // if months over 11 (December), we must be wanting January a year later
    if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }
    // if months under 0 (January), we must be wanting December last year
    if (currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    }
  }

  function _generateCalendar(el, year, month) {
    // JS this date
    var theDate = new Date(year, month);
    // is leap year?
    var isLeapYear = (new Date(year, 1, 29).getMonth() === 1);
    // update length of February as required
    monthLengths[1] = (isLeapYear) ? 29 : 28;
    // what day within the week is the first day of the month?
    var firstDayOfMonth = new Date(year, month).getDay();
    // we want to loop a multiple of 7 days and add spaces around the actual starting day
    var loopMonthLengths = monthLengths[month] + firstDayOfMonth;
    // make that loop length a multiple of 7
    while(loopMonthLengths % 7 > 0) {
      loopMonthLengths++;
    }
    // generate HTML
    // open new tr
    daysHtml = '<tr>';
    // now loop
    for (let i = 1; i <= loopMonthLengths; i++) {
      var thisDay = '';
      var tdClassName = '';
      // the gaps for if a month doesn't start on monday and to make the total TDs a multiple of 7
      if (i <= firstDayOfMonth || i > (monthLengths[month] + firstDayOfMonth)) {
        thisDay = '&nbsp;';
      } else {
        // normalize date
        var currentDate = (i - firstDayOfMonth);
        var currentDateObj = new Date(year, month, currentDate);
        var istoday = (currentDateObj.getTime() === today.getTime())
        ;
        var beforeMinDate = (currentDateObj.getTime() < minDate.getTime());
        var isStartDate = (datesSelected.start.dateObj && currentDateObj.getTime() === datesSelected.start.dateObj.getTime());
        var isEndDate = (datesSelected.end.dateObj && currentDateObj.getTime() === datesSelected.end.dateObj.getTime());
        var isBetweenStartAndEnd = (datesSelected.start.dateObj && datesSelected.end.dateObj && !(currentDateObj.getTime() <= datesSelected.start.dateObj.getTime() || currentDateObj.getTime() >= datesSelected.end.dateObj.getTime()));
        // now add some classes if we need
        if (istoday) {
          tdClassName = 'm-calendar__today';
        }
        if (isStartDate) {
          tdClassName += ' s-start';
        }
        if (isEndDate) {
          tdClassName += ' s-end';
        }
        if(isBetweenStartAndEnd) {
          tdClassName += ' s-range';
        }
        // if today or after, add a link
        if (istoday || !beforeMinDate) {
          var titleAttr =  months[month] + ' ' + currentDate + ', ' + year;
          var urlMonth = (month + 1);
          urlMonth = (urlMonth < 10) ? '0' + urlMonth : urlMonth.toString();
          var urlDay = (currentDate < 10) ? '0' + currentDate : currentDate.toString();
          // TODO: Remove 'time' parameter here?
          var windowLocationHref = queryStringHandler.updateParameter(window.location.href, 'date', (year.toString() + urlMonth + urlDay));
          thisDay = '<a href="'+ windowLocationHref + '" data-date="' + year.toString() + urlMonth + urlDay + '" title="' + titleAttr + '">' + currentDate + '</a>';
        } else {
          thisDay = currentDate;
        }
      }

      // update HTML string, adding new table rows when needed
      daysHtml = daysHtml + '<td class="' + tdClassName + '">' + thisDay + '</td>\n' + ((i !== 0 && i !== loopMonthLengths && i % 7 === 0) ? '</tr>\n<tr>\n' : '');
    }
    // close that last tr
    daysHtml += '</tr>';
    // insert the html
    el.querySelector('[data-calendar-title]').textContent = months[month] + ' ' + year;
    el.querySelector('tbody').innerHTML = daysHtml;
  }

  function _generateCalendars(year, month) {
    if (monthDivs.length !== monthsVisible) {
      // clone $template, update and insert
      for (let i = 0; i < monthsVisible; i++) {
        let $thisCopy = $template.cloneNode(true);
        $thisCopy.removeAttribute('data-calendar-month-template');
        $thisCopy.removeAttribute('style');
        $monthsContainer.insertBefore($thisCopy, $template);
        monthDivs.push($thisCopy);
      }
    }
    currentYear = year;
    currentMonth = month - 1;
    for (let i = 0; i < monthsVisible; i++) {
      currentMonth = currentMonth + 1;
      _normaliseYearMonth();
      _generateCalendar(monthDivs[i], currentYear, currentMonth);
    }
  }

  function _showDateRange(endDateObj) {
    if (datesSelected.start.dateObj && endDateObj && (!datesSelected.end.dateObj || (datesSelected.end.dateObj.getTime() === endDateObj.getTime()))) {
      forEach($monthsContainer.querySelectorAll('.s-range'), function(index, el) {
        el.classList.remove('s-range');
      });

      let date = new Date(datesSelected.start.dateObj);
      date.setDate(date.getDate() + 1);

      while (date.getTime() < endDateObj.getTime()) {
        let searchMonth = date.getMonth() + 1;
        let searchDay = date.getDate();
        //
        searchMonth = (searchMonth < 10) ? '0' + searchMonth : searchMonth.toString();
        searchDay = (searchDay < 10) ? '0' + searchDay : searchDay.toString();
        //
        forEach($monthsContainer.querySelectorAll('[data-date="' + date.getFullYear() + searchMonth + searchDay + '"]'), function(index, el) {
          el.parentNode.classList.add('s-range');
        });
        date.setDate(date.getDate() + 1);
      }
    }
  }

  function _removedSelectedClasses(which) {
    if (which === 'start' || which === 'all') {
      forEach($monthsContainer.querySelectorAll('.s-start'), function(index, el) {
        el.classList.remove('s-start');
      });
    }
    if (which === 'end' || which === 'all') {
      forEach($monthsContainer.querySelectorAll('.s-range'), function(index, el) {
        el.classList.remove('s-range');
      });
      forEach($monthsContainer.querySelectorAll('.s-end'), function(index, el) {
        el.classList.remove('s-end');
      });
    }
  }

  function _datesSelected() {
    if (Object.keys(datesSelected.start).length === 0) {
      triggerCustomEvent(document, 'selectDate:close');
    } else {
      if (Object.keys(datesSelected.end).length === 0) {
        datesSelected.end = datesSelected.start;
      }
      triggerCustomEvent(opener, 'calendar:datesSelected', {
        dates: datesSelected,
      });
    }
  }

  function _dateSelected(clicked) {
    let chosenDate = clicked.getAttribute('data-date');
    let dateObj = _parseDateString(chosenDate);
    let friendlyString = clicked.getAttribute('title');
    let isoDate = dateObj.toISOString().substr(0, 10);
    let shortDate = (('0'+dateObj.getDate()).slice(-2))+'/'+(('0'+(dateObj.getMonth()+1)).slice(-2))+'/'+dateObj.getFullYear().toString().slice(-2);
    let shortDateUS = (('0'+(dateObj.getMonth()+1))+'/'+(('0'+dateObj.getDate()).slice(-2)).slice(-2))+'/'+dateObj.getFullYear().toString().slice(-2)

    datesSelected[selecting] = {
      string: chosenDate,
      dateObj: dateObj,
      friendlyString: friendlyString,
      iso: isoDate,
      short: shortDate,
      shortUS: shortDateUS,
    };

    if (selecting === 'start') {
      selecting = 'end';
      datesSelected.end = {};
      $start.classList.remove('s-active');
      $start.classList.add('s-has-date');
      $start.textContent = friendlyString;
      $end.classList.add('s-active');
      $end.textContent = 'To';
      _removedSelectedClasses('all');
      clicked.parentNode.classList.add('s-start');
      triggerCustomEvent(opener, 'calendar:dateSelected', {
        start: datesSelected.start,
      });
      if (mode === 'single') {
        _datesSelected();
      }
    } else if (selecting === 'end') {
      $end.textContent = friendlyString;
      _removedSelectedClasses('end');
      clicked.parentNode.classList.add('s-end');
      _showDateRange(datesSelected.end.dateObj);
      triggerCustomEvent(opener, 'calendar:dateSelected', {
        end: datesSelected.end,
      });
      if (A17.currentMediaQuery.indexOf('small') < 0) {
        _datesSelected();
      }
    }
  }

  function _reset(which) {
    if (which === 'end') {
      selecting = 'start';
      datesSelected.end = {};
      $start.classList.add('s-active');
      $end.classList.remove('s-has-date');
      $end.classList.remove('s-active');
      $end.textContent = 'To';
    }

    if (which === 'all') {
      selecting = 'start';
      datesSelected.start = {};
      datesSelected.end = {};
      $start.classList.add('s-active');
      $start.classList.remove('s-has-date');
      $start.textContent = 'From';
      $end.classList.remove('s-active');
      $end.classList.remove('s-has-date');
      $end.textContent = 'To';
      //
      let $startDate = $monthsContainer.querySelector('.s-start');
      if ($startDate) {
        $startDate.classList.remove('s-start');
      }
      let $endDate = $monthsContainer.querySelector('.s-end');
      if ($endDate) {
        $endDate.classList.remove('s-end');
      }
    }

    _removedSelectedClasses(which);
  }

  function _handleClicks(event) {
    event.preventDefault();
    event.stopPropagation();
    //
    let clicked = event.target;
    clicked.blur();
    // pick action
    if (clicked.getAttribute('data-calendar-next') !== null) {
      currentMonth++;
      _normaliseYearMonth();
      _generateCalendars(currentYear, currentMonth);
    }
    if (clicked.getAttribute('data-calendar-prev') !== null) {
      // sequentially lower month, normalise each time to trap for going back a year
      for (let i = 1; i < (monthsVisible * 2); i++) {
        currentMonth = currentMonth - 1;
        _normaliseYearMonth();
      }
      _generateCalendars(currentYear, currentMonth);
    }
    if (clicked.getAttribute('data-calendar-start') !== null) {
      _reset('end');
    }
    if (clicked.getAttribute('data-calendar-end') !== null) {
      selecting = 'end';
      $start.classList.remove('s-active');
      $end.classList.add('s-active');
    }
    if (clicked.getAttribute('data-calendar-reset') !== null) {
      _reset('all');
    }
    if (clicked.getAttribute('data-calendar-close') !== null) {
      triggerCustomEvent(document, 'selectDate:close');
    }
    if (clicked.getAttribute('data-calendar-done') !== null) {
      _datesSelected();
    }
    if (clicked.getAttribute('data-date') !== null) {
      _dateSelected(clicked);
    }
  }

  function _mouseOver(event) {
    if (event.target.getAttribute('data-date') !== null) {
      let chosenDate = event.target.getAttribute('data-date');
      let dateObj = _parseDateString(chosenDate);
      _showDateRange(dateObj);
    }
  }

  function _openerSent(event) {
    // resets
    today = new Date();
    today = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    minDate = today;
    currentMonth = today.getMonth();
    currentYear = today.getFullYear();
    monthsVisible = (A17.currentMediaQuery.indexOf('xsmall') < 0) ? 2 : 1;
    daysHtml = '';
    datesSelected.start = {};
    datesSelected.end = {};
    //
    forEach(monthDivs, function(index, el) {
      el.parentNode.removeChild(el);
    });
    monthDivs = [];
    //
    $monthsContainer = container.querySelector('[data-calendar-months]');
    $template = $monthsContainer.querySelector('[data-calendar-month-template]');
    $start = container.querySelector('[data-calendar-start]');
    $end = container.querySelector('[data-calendar-end]');
    _reset('all');
    if (event && event.data.el) {
      opener = event.data.el;
    }
    if (event && event.data.minDate && event.data.minDate !== 'today') {
      minDate = event.data.minDate;
    } else {
      minDate = today;
    }
    if (event && event.data.mode) {
      mode = (event.data.mode === 'range') ? 'range' : 'single';
    } else {
      mode = 'single';
    }
    container.setAttribute('data-calendar-mode', mode);
    _generateCalendars(minDate.getFullYear(), minDate.getMonth());
  }

  function _init() {
    // listen for clicks
    container.addEventListener('click', _handleClicks, false);
    container.addEventListener('mouseover', _mouseOver, false);
    container.addEventListener('calendar:opener', _openerSent, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);
    container.removeEventListener('mouseover', _mouseOver);
    container.removeEventListener('calendar:opener', _openerSent);

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default calendar;
