import { purgeProperties } from 'a17-helpers';

A17.importantDates = '20171109,20171119,20171207,20180127';

const calendar = function(container) {

  const today = new Date();
  const todayDate = today.getDate();
  const todayMonth = today.getMonth();
  const todayYear = today.getFullYear();
  const searchUrl = container.getAttribute('data-calendar-url') || window.location.href;

  let currentMonth;
  let currentYear;
  let months = [];
  let monthLengths = [];
  let daysHtml = '';
  let importantDates = [];
  let importantDatesLength = 0;

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

  function _generateCalendar(year, month) {
    // update vars
    currentMonth = month;
    currentYear = year;
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
    // check against important dates this month in this year
    var thisMonthImportantDates = '';
    var thisMonthImportantDatesRegex = false;
    if (importantDates.length > 0) {
      for (let i = 0; i < importantDatesLength; i++) {
        if (month === importantDates[i].month && year === importantDates[i].year) {
          thisMonthImportantDates = thisMonthImportantDates + ':' + importantDates[i].date + ':|';
        }
      }
      if (thisMonthImportantDates.length > 0) {
        thisMonthImportantDates = thisMonthImportantDates.slice(0, -1);
        // make regex for testing
        thisMonthImportantDatesRegex = new RegExp(thisMonthImportantDates);
      }
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
        // is this today?
        if (currentDate === todayDate && month === todayMonth && year === todayYear) {
          tdClassName = 'calendar__today';
        }
        // see if we match an important date
        // using regex for speed and so I don't have to do another loop in a loop
        if (thisMonthImportantDatesRegex && thisMonthImportantDatesRegex.test(':' + currentDate + ':')) {
          var urlMonth = (month + 1);
          urlMonth = (urlMonth < 10) ? '0' + urlMonth : urlMonth.toString();
          var urlDay = (currentDate < 10) ? '0' + currentDate : currentDate.toString();
          thisDay = '<a href="'+ searchUrl + '?date=' + year.toString() + urlMonth + urlDay + '" data-date="' + year.toString() + urlMonth + urlDay + '">' + currentDate + '</a>';
        }
        // lastly, this must be a day with no events
        if (thisDay === '') {
          thisDay = currentDate;
        }
      }

      // update HTML string, adding new table rows when needed
      daysHtml = daysHtml + '<td class="' + tdClassName + '">' + thisDay + '</td>\n' + ((i !== 0 && i !== loopMonthLengths && i % 7 === 0) ? '</tr>\n<tr>\n' : '');
    }
    // close that last tr
    daysHtml += '</tr>';
    // insert the html
    container.querySelector('[data-calendar-title]').textContent = months[month] + ' ' + year;
    container.querySelector('tbody').innerHTML = daysHtml;
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

  function _handleClicks(event) {
    // action
    let clicked = event.target;
    if (clicked.getAttribute('data-calendar-next') !== null) {
      event.preventDefault();
      event.stopPropagation();
      currentMonth++;
      _normaliseYearMonth();
      _generateCalendar(currentYear, currentMonth);
    }
    if (clicked.getAttribute('data-calendar-prev') !== null) {
      event.preventDefault();
      event.stopPropagation();
      currentMonth--;
      _normaliseYearMonth();
      _generateCalendar(currentYear, currentMonth);
    }
    if (clicked.getAttribute('data-date') !== null) {
      event.preventDefault();
      event.stopPropagation();
      console.log('date', clicked.getAttribute('data-date'));
    }
  }

  function _init() {
    // process important dates
    importantDates = A17.importantDates.split(',') || [];
    importantDatesLength = importantDates.length;

    for (let i = 0; i < importantDatesLength; i++) {
      let importantDate = importantDates[i];
      let typeOfImportantDate = (typeof importantDate).toLowerCase();
      if (typeOfImportantDate !== 'object') {
        if (typeOfImportantDate === 'number') {
          typeOfImportantDate = typeOfImportantDate.toString();
        }
        importantDates[i] = {
          year: parseInt(importantDate.substring(0,4)),
          month: parseInt(importantDate.substring(4,6) - 1),
          date: parseInt(importantDate.substring(6,8))
        };
      } else {
        importantDates.splice(i, 1);
      }
    }
    // listen for clicks
    container.addEventListener('click', _handleClicks, false);
    // draw initial calendar
    _generateCalendar(today.getFullYear(), today.getMonth());
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default calendar;
