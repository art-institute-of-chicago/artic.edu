<!DOCTYPE html>
<html dir="ltr" lang="en-US" class="f-no-js">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="format-detection" content="telephone=no">
  <title>AIC</title>

  <!-- Main Favicon -->
  <link rel="shortcut icon" href="/dist/images/favicon.ico">
  <!-- Apple Touch Icons (ipad/iphone standard+retina) -->
  <link rel="apple-touch-icon" href="/dist/images/favicon-152.png"> <!-- General use iOS/Android icon, auto-downscaled by devices. -->
  <link rel="apple-touch-icon" type="image/png" href="/dist/images/favicon-120.png" sizes="120x120"> <!-- iPhone retina touch icon -->
  <link rel="apple-touch-icon" type="image/png" href="/dist/images/favicon-76.png" sizes="76x76"> <!-- iPad home screen icons -->
  <!-- Favicon Fallbacks for old browsers that don't read .ico -->
  <link rel="icon" type="image/png" href="/dist/images/favicon-32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="/dist/images/favicon-16.png" sizes="16x16">

  <!--[if lt IE 9]>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
  <![endif]-->
  <!-- insert head.js - ideally minified and inline and not linked like this -->
  <script src="/dist/scripts/head.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cloud.typography.com/612324/7579192/css/fonts.css" />
  <link href="{{ revAsset('styles/app.css') }}" rel="stylesheet" />

  <style>
    #a17 {
      padding-top: 0 !important;
      color: #1a1a1a !important;
    }
  </style>
</head>

<body>
<div id="a17">
  <main id="content">
    <p style="margin-top: 0; padding-top: 20px;">
      <span class="radio">
        <input type="radio" value="roption1" id="roption1" name="roptions">
        <label for="roption1" class="f-secondary">Option 1</label>
      </span>
      <span class="radio">
        <input type="radio" value="roption2" id="roption2" name="roptions" checked>
        <label for="roption2" class="f-secondary">Option 2</label>
      </span>
      <span class="radio">
        <input type="radio" value="roption3" id="roption3" name="roptions" disabled>
        <label for="roption3" class="f-secondary">Disabled</label>
      </span>
    </p>
    <p style="margin-top: 0; padding-top: 20px;">
      <span class="checkbox">
        <input type="checkbox" value="coption1" id="coption1" name="coption1">
        <label for="coption1" class="f-secondary">Option</label>
      </span>
      <span class="checkbox">
        <input type="checkbox" value="coption2" id="coption2" name="coption2" checked>
        <label for="coption2" class="f-secondary">Option</label>
      </span>
      <span class="checkbox">
        <input type="checkbox" value="coption3" id="coption3" name="coption3" disabled>
        <label for="coption3" class="f-secondary">Disabled</label>
      </span>
    </p>
    <p style="margin-top: 0; padding-top: 20px;">
      <label for="tinput1" class="f-secondary">Label</label>
      <input class="f-secondary" type="text" name="tinput1" id="tinput1" placeholder="Placeholder">
    </p>
    <p>
      <label for="tinput2" class="f-secondary">Label</label>
      <span class="input-with-output" data-behavior="textCount">
        <input class="f-secondary" type="text" name="tinput2" id="tinput2" placeholder="Placeholder">
        <output for="tinput2" class="f-secondary"></output>
      </span>
    </p>
    <p class="s-error" style="margin-top: 0; padding-top: 20px;">
      <label for="tinput3" class="f-secondary">Label</label>
      <input class="f-secondary" type="text" name="tinput3" id="tinput3" placeholder="Placeholder" value="Value">
      <em class="error-msg f-secondary">Error message</em>
    </p>
    <p style="margin-top: 0; padding-top: 20px;">
      <label for="tinput4" class="f-secondary">Label</label>
      <input class="f-secondary" type="text" name="tinput4" id="tinput4" placeholder="Disabled" value="Disabled" disabled>
    </p>
    <p style="margin-top: 0; padding-top: 20px;">
      <label for="textarea1">Label</label>
      <textarea name="textarea1" id="textarea1" class="f-secondary">Mon jinn chewbacca darth darth kenobi. Moff fett hutt cade dantooine organa skywalker. Yavin darth calamari dagobah. Maul tusken raider hutt grievous.</textarea>
    </p>
    <p style="margin-top: 0; padding-top: 20px;">
      <label for="select1">Label</label>
      <span class="select" data-behavior="formSelectFocus">
        <select class="f-secondary" name="select1" id="select1">
          <option>Option 1</option>
          <option>Option 2</option>
          <option>Option 3</option>
          <option>Option 4</option>
          <option>Option 5</option>
        </select>
      </span>
    </p>
    <p class="s-error" style="margin-top: 0; padding-top: 20px;">
      <label for="select2">Label</label>
      <span class="select" data-behavior="formSelectFocus">
        <select class="f-secondary" name="select2" id="select2">
          <option>Option 1</option>
          <option>Option 2</option>
          <option>Option 3</option>
          <option>Option 4</option>
          <option>Option 5</option>
        </select>
      </span>
    </p>
    <p style="margin-top: 0; padding-top: 20px;">
      <label for="select3">Label</label>
      <span class="select" data-behavior="formSelectFocus">
        <select class="f-secondary" name="select3" id="select3" disabled>
          <option>Disabled</option>
          <option>Option 1</option>
          <option>Option 2</option>
          <option>Option 3</option>
          <option>Option 4</option>
          <option>Option 5</option>
        </select>
      </span>
    </p>
    <p style="margin-top: 0; padding-top: 20px;">
      <button class="btn f-buttons">Action</button>
      <button class="btn btn--secondary f-buttons">Action</button>
      <button class="btn btn--tertiary f-buttons">Action</button>
      <button class="btn btn--quaternary f-buttons">Action</button>
      <button class="btn btn--secondary f-buttons"><svg class="icon--new-window" aria-hidden="true"><use xlink:href="#icon--new-window" /></svg>Action</button>
      <button class="btn btn--disabled f-buttons">Action</button>
      <button class="btn f-buttons" disabled>Action</button>
    </p>
    <p style="margin-top: 0; padding-top: 20px;">
      <a href="#" class="tag f-tag">Kanan Jarrus</a>
      <a href="#" class="tag f-tag">Caleb Dume</a>
    </p>

    <div style="margin-top: 0; padding-top: 20px;">
      <span aria-title="sort by" class="dropdown" data-behavior="dropdown">
        <button class="f-secondary">Dropdown<svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></button>
        <ul class="f-secondary">
          <li><a href="#">Option 1</a></li>
          <li><a href="#">Option 2</a></li>
          <li><a href="#">Option 3</a></li>
          <li><a href="#">Option 4</a></li>
          <li><a href="#">Option 5</a></li>
          <li><a href="#">Option 6</a></li>
          <li><a href="#">Option 7</a></li>
          <li><a href="#">Option 8</a></li>
          <li><a href="#">Option 9</a></li>
          <li><a href="#">Option 10</a></li>
        </ul>
      </span>
    </div>
    <div style="margin-top: 0; padding-top: 20px;">
      <span aria-title="sort by" class="dropdown" data-behavior="dropdown" data-dropdown-hoverable>
        <button class="f-secondary">Dropdown Hoverable<svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></button>
        <ul class="f-secondary">
          <li><a href="#">Newest</a></li>
          <li><a href="#">Oldest</a></li>
        </ul>
      </span>
    </div>
    <div style="margin-top: 0; padding-top: 20px;">
      <span aria-title="sort by" class="dropdown dropdown--filter" data-behavior="dropdown">
        <button class="f-secondary">Dropdown<svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></button>
        <ul class="f-secondary">
          <li class="s-active"><a href="#">Dropdown</a></li>
          <li><a href="#">Option 1</a></li>
          <li><a href="#">Option 2</a></li>
          <li><a href="#">Option 3</a></li>
          <li><a href="#">Option 4</a></li>
          <li><a href="#">Option 5</a></li>
          <li><a href="#">Option 6</a></li>
          <li><a href="#">Option 7</a></li>
          <li><a href="#">Option 8</a></li>
          <li><a href="#">Option 9</a></li>
          <li><a href="#">Option 10</a></li>
        </ul>
      </span>
    </div>

    <nav class="m-tabs" style="margin-top: 20px;">
      <ul class="m-tabs__items f-module-title-1">
        <li class="tabs__item s-active"><span class="m-tabs__item-trigger">Exhibitions</span></li>
        <li class="m-tabs__item"><a class="m-tabs__item-trigger" href="#">Events</a></li>
      </ul>
    </nav>

    <p class="f-body">Inline calendar</p>
    <div class="m-calendar m-calendar--inline" style="margin-top: 20px;" data-behavior="calendar" data-calendar-url="/events">
      <b class="m-calendar__title f-caption" data-calendar-title></b>
      <table>
        <thead class="f-caption">
          <tr>
            <th title="Sunday">S</th>
            <th title="Monday">M</th>
            <th title="Tuesday">T</th>
            <th title="Wednesday">W</th>
            <th title="Thursday">T</th>
            <th title="Friday">F</th>
            <th title="Saturday">S</th>
          </tr>
        </thead>
        <tbody class="f-secondary">
        </tbody>
      </table>
      <button class="m-calendar__next" data-calendar-next><svg aria-title="Next month" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></button>
      <button class="m-calendar__prev" data-calendar-prev><svg aria-title="Previous month" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></button>
    </div>

    <p class="f-secondary">
      <span class="date-select-trigger" data-behavior="selectDate">
        <button class="date-select-trigger__open" data-selectDate-open>
          <svg class="icon--calendar"><use xlink:href="#icon--calendar" /></svg>
          <span class="date-select-trigger__label f-buttons">Choose date</span>
          <span class="date-select-trigger__selected-date f-buttons" data-selectDate-display></span>
        </button>
        <button class="date-select-trigger__clear" data-selectDate-clear><svg class="icon--close-circle"><use xlink:href="#icon--close-circle" /></svg></button>
        <input type="hidden">
      </span>
    </p>

    <p class="f-secondary">
      <span class="date-select-trigger" data-behavior="selectDate" data-selectDate-range="true" data-selectDate-id="cal01" data-selectDate-role="start" data-selectDate-linkedId="cal02">
        <button class="date-select-trigger__open" data-selectDate-open>
          <svg class="icon--calendar"><use xlink:href="#icon--calendar" /></svg>
          <span class="date-select-trigger__label f-buttons">Start date</span>
          <span class="date-select-trigger__selected-date f-buttons" data-selectDate-display></span>
        </button>
        <button class="date-select-trigger__clear" data-selectDate-clear><svg class="icon--close-circle"><use xlink:href="#icon--close-circle" /></svg></button>
        <input type="hidden">
      </span>
      <span class="date-select-trigger" data-behavior="selectDate" data-selectDate-range="true" data-selectDate-id="cal02" data-selectDate-role="end" data-selectDate-linkedId="cal01">
        <button class="date-select-trigger__open" data-selectDate-open>
          <svg class="icon--calendar"><use xlink:href="#icon--calendar" /></svg>
          <span class="date-select-trigger__label f-buttons">End date</span>
          <span class="date-select-trigger__selected-date f-buttons" data-selectDate-display></span>
        </button>
        <button class="date-select-trigger__clear" data-selectDate-clear><svg class="icon--close-circle"><use xlink:href="#icon--close-circle" /></svg></button>
        <input type="hidden">
      </span>
    </p>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing, no cols</p>
    <ul class="o-grid-listing">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing, no cols, o-grid-listing--gridlines-top</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-top">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing, no cols, o-grid-listing--gridlines-rows</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-rows">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing, no cols, o-grid-listing--gridlines-split-rows</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-split-rows">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing, 2 cols at small, 3 cols at medium, 4 cols large+ (most examples follow this)</p>
    <ul class="o-grid-listing o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--keyline-top</p>
    <ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--gridlines-right</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-right o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--gridlines-cols</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--keyline-top o-grid-listing--gridlines-cols</p>
    <ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--gridlines-cols o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--gridlines-top</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--keyline-top o-grid-listing--gridlines-top</p>
    <ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--gridlines-rows</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--gridlines-right o-grid-listing--gridlines-top</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-right o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--keyline-top o-grid-listing--gridlines-right o-grid-listing--gridlines-top</p>
    <ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--gridlines-right o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--gridlines-right o-grid-listing--gridlines-rows</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-right o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--gridlines-cols o-grid-listing--gridlines-top</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--keyline-top o-grid-listing--gridlines-cols o-grid-listing--gridlines-top</p>
    <ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--gridlines-cols o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--gridlines-split-rows</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-split-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--gridlines-right o-grid-listing--gridlines-split-rows</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-right o-grid-listing--gridlines-split-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">o-grid-listing--gridlines-cols o-grid-listing--gridlines-split-rows</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-split-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      @include('shared.listitems')
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">4 col at large+</p>
    <ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
      <li class="m-listing">
        <a href="#" class="m-listing__link">
          <span class="m-listing__img">
            <img src="http://placehold.dev.area17.com/image/400x225">
          </span>
          <span class="m-listing__meta">
            <em class="m-listing__type f-tag">Special Exhibition</em> <br>
            <strong class="m-listing__title f-list-3">Cauleen Smith: Human_3.0 Reading Listz</strong> <br>
            <span class="m-listing__bottom m-listing__date f-secondary">Oct 29, 2017</span>
          </span>
        </a>
      </li>
      <li class="m-listing">
        <a href="#" class="m-listing__link">
          <span class="m-listing__img">
            <img src="http://placehold.dev.area17.com/image/400x225">
          </span>
          <span class="m-listing__meta">
            <em class="m-listing__type f-tag">Ongoing</em> <br>
            <strong class="m-listing__title f-list-3">Along the Lines: Selected drawings by Saul Steinberg</strong> <br>
            <span class="m-listing__bottom m-listing__date f-secondary">Oct 29, 2017</span>
          </span>
        </a>
      </li>
      <li class="m-listing">
        <a href="#" class="m-listing__link">
          <span class="m-listing__img">
            <img src="http://placehold.dev.area17.com/image/400x225">
          </span>
          <span class="m-listing__meta">
            <em class="m-listing__type f-tag">Ongoing</em> <br>
            <strong class="m-listing__title f-list-3">Charles White Murals</strong> <br>
            <span class="m-listing__bottom m-listing__date f-secondary">Through Nov 29, 2017</span>
          </span>
        </a>
      </li>
      <li class="m-listing">
        <a href="#" class="m-listing__link">
          <span class="m-listing__img">
            <img src="http://placehold.dev.area17.com/image/400x225">
          </span>
          <span class="m-listing__meta">
            <em class="m-listing__type f-tag">Ongoing</em> <br>
            <strong class="m-listing__title f-list-3">Moholy-Nagy&mdash;Future Present</strong> <br>
            <span class="m-listing__bottom m-listing__date f-secondary">Through Nov 29, 2017</span>
          </span>
        </a>
      </li>
    </ul>

    <hr class="hr--big-break">
    <p class="f-secondary">5 col at xlarge+</p>

    <ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--5-col@xlarge o-grid-listing--5-col@xxlarge">
      <li class="m-listing">
        <a href="#" class="m-listing__link">
          <span class="m-listing__img">
            <img src="http://placehold.dev.area17.com/image/300x300">
          </span>
          <span class="m-listing__meta">
            <strong class="m-listing__title f-list-2">Resin Elephant</strong> <br>
            <span class="m-listing__bottom m-listing__price f-secondary">$19.99</span>
          </span>
        </a>
      </li>
      <li class="m-listing">
        <a href="#" class="m-listing__link">
          <span class="m-listing__img">
            <img src="http://placehold.dev.area17.com/image/300x300">
          </span>
          <span class="m-listing__meta">
            <strong class="m-listing__title f-list-2">Autumn Glass Leaves</strong> <br>
            <span class="m-listing__bottom m-listing__price f-secondary">$68</span>
          </span>
        </a>
      </li>
      <li class="m-listing">
        <a href="#" class="m-listing__link">
          <span class="m-listing__img">
            <img src="http://placehold.dev.area17.com/image/300x300">
          </span>
          <span class="m-listing__meta">
            <strong class="m-listing__title f-list-2">Modern Cuff Bracelet</strong> <br>
            <span class="m-listing__bottom m-listing__price f-secondary"><strike>$80</strike> <span class="m-listing__sale-price">$59.99</span></span>
          </span>
        </a>
      </li>
      <li class="m-listing">
        <a href="#" class="m-listing__link">
          <span class="m-listing__img">
            <img src="http://placehold.dev.area17.com/image/300x300">
          </span>
          <span class="m-listing__meta">
            <strong class="m-listing__title f-list-2">Tapestry Duffle</strong> <br>
            <span class="m-listing__bottom m-listing__price f-secondary">$150</span>
          </span>
        </a>
      </li>
      <li class="m-listing">
        <a href="#" class="m-listing__link">
          <span class="m-listing__img">
            <img src="http://placehold.dev.area17.com/image/300x300">
          </span>
          <span class="m-listing__meta">
            <strong class="m-listing__title f-list-2">Glass Pumpkin</strong> <br>
            <span class="m-listing__bottom m-listing__price f-secondary">$79</span>
          </span>
        </a>
      </li>
    </ul>


    <ul class="sg-type-spec">
      <li>
        <p class="f-display-2">f-display-2</p>
        <p class="f-display-2">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-display-1">f-display-1</p>
        <p class="f-display-1">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-display-1">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-headline">f-headline</p>
        <p class="f-headline">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-headline">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-headline-editorial">f-headline-editorial</p>
        <p class="f-headline-editorial">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-headline-editorial">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-deck">f-deck</p>
        <p class="f-deck">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-deck">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-module-title-2">f-module-title-2</p>
        <p class="f-module-title-2">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-module-title-2">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-module-title-1">f-module-title-1</p>
        <p class="f-module-title-1">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-module-title-1">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-subheading">f-subheading</p>
        <p class="f-subheading">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-subheading">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-subheading-editorial">f-subheading-editorial</p>
        <p class="f-subheading-editorial">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-subheading-editorial">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-body">f-body</p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-body">f-body-emphasis</p>
        <p class="f-body-emphasis">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body-emphasis">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-body-editorial">f-body-editorial</p>
        <p class="f-body-editorial">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body-editorial">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-body-editorial-emphasis">f-body-editorial-emphasis</p>
        <p class="f-body-editorial-emphasis">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body-editorial-emphasis">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-buttons">f-buttons</p>
        <p class="f-buttons">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-buttons">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-secondary">f-secondary</p>
        <p class="f-secondary">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-secondary">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-tag">f-tag</p>
        <p class="f-tag">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-tag">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-caption">f-caption</p>
        <p class="f-caption">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-caption">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-list-3">f-list-3</p>
        <p class="f-list-3">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-list-3">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-list-2">f-list-2</p>
        <p class="f-list-2">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-list-2">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-list-1">f-list-1</p>
        <p class="f-list-1">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-list-1">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-quote">f-quote</p>
        <p class="f-quote">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-quote">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
      <li>
        <p class="f-body-editorial">f-dropcap-editorial / f-dropcap-editorial</p>
        <p class="f-body-editorial"><span class="f-dropcap-editorial">L</span>orem ipsum dolor sit amet, consectetur adipiscing elit. Mauris vehicula libero vel quam fringilla dignissim. Praesent finibus sem sed arcu tempor, non tincidunt magna luctus. Maecenas lacinia interdum lacinia. Pellentesque ac felis vehicula, fermentum mauris sed, ornare ex. Mauris cursus, nulla eget fermentum molestie, metus velit sodales turpis, nec tempus felis orci id erat.</p>
      </li>
      <li>
        <p class="f-date-numeral">f-date-numeral</p>
        <p class="f-date-numeral">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-date-numeral">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
        <p class="f-body">The quick brown fox, <br>jumps over the lazy dog H<sub>2</sub>O<sup>2</sup></p>
      </li>
    </ul>

    <div class="sg-icons">
      <svg class="icon--alert"><use xlink:href="#icon--alert" /></svg>
      <svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
      <svg class="icon--arrow icon--arrow--left"><use xlink:href="#icon--arrow" /></svg>
      <svg class="icon--arrow icon--arrow--top"><use xlink:href="#icon--arrow" /></svg>
      <svg class="icon--arrow icon--arrow--bottom"><use xlink:href="#icon--arrow" /></svg>
      <svg class="icon--calendar"><use xlink:href="#icon--calendar" /></svg>
      <svg class="icon--check"><use xlink:href="#icon--check" /></svg>
      <svg class="icon--clock"><use xlink:href="#icon--clock" /></svg>
      <svg class="icon--close-circle"><use xlink:href="#icon--close-circle" /></svg>
      <svg class="icon--close"><use xlink:href="#icon--close" /></svg>
      <svg class="icon--info--24"><use xlink:href="#icon--info--24" /></svg>
      <svg class="icon--location--24"><use xlink:href="#icon--location--24" /></svg>
      <svg class="icon--location"><use xlink:href="#icon--location" /></svg>
      <svg class="icon--logo--80"><use xlink:href="#icon--logo--80" /></svg>
      <svg class="icon--logo--88"><use xlink:href="#icon--logo--88" /></svg>
      <svg class="icon--logo--outline--80"><use xlink:href="#icon--logo--outline--80" /></svg>
      <svg class="icon--logo--outline--88"><use xlink:href="#icon--logo--outline--88" /></svg>
      <svg class="icon--minus--24"><use xlink:href="#icon--minus--24" /></svg>
      <svg class="icon--new-window"><use xlink:href="#icon--new-window" /></svg>
      <svg class="icon--play--48"><use xlink:href="#icon--play--48" /></svg>
      <svg class="icon--play--64"><use xlink:href="#icon--play--64" /></svg>
      <svg class="icon--play--96"><use xlink:href="#icon--play--96" /></svg>
      <svg class="icon--plus--24"><use xlink:href="#icon--plus--24" /></svg>
      <svg class="icon--print--24"><use xlink:href="#icon--print--24" /></svg>
      <svg class="icon--quote--76"><use xlink:href="#icon--quote--76" /></svg>
      <svg class="icon--return"><use xlink:href="#icon--return" /></svg>
      <svg class="icon--search--24"><use xlink:href="#icon--search--24" /></svg>
      <svg class="icon--share--24"><use xlink:href="#icon--share--24" /></svg>
      <svg class="icon--user"><use xlink:href="#icon--user" /></svg>
      <svg class="icon--zoom--24"><use xlink:href="#icon--zoom--24" /></svg>
    </div>
  </main>

  @include('shared.footer')
  @include('shared.calendar')

  <span class="design-grid-toggle design-grid-toggle--baseline" onClick="this.nextElementSibling.classList.toggle('js-hide');">Toggle baseline grid</span>
  <span class="design-grid design-grid--baseline js-hide"></span>
  <span class="design-grid-toggle design-grid-toggle--columns" data-env="Development" onClick="this.nextElementSibling.classList.toggle('js-hide');">Toggle columns grid</span>
  <span class="design-grid design-grid--columns js-hide"></span>
</div>

<script src="{{ revAsset('scripts/app.js') }}"></script>
</body>
</html>

