@extends('layouts.app')

@section('content')

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

@include('shared._intro-block', array('intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet tortor.'))

@php
$introBlockActionsPrimary = array();
array_push($introBlockActionsPrimary, array('text' => 'Plan your visit', 'href' => '#'));
$introBlockActionsSecondary = array();
array_push($introBlockActionsSecondary, array('text' => 'Hours and admission', 'href' => '#'));
array_push($introBlockActionsSecondary, array('text' => 'Directions and parking', 'href' => '#'));
@endphp
@include('shared._intro-block', array('intro' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet tortor.', 'primaryActions' => $introBlockActionsPrimary, 'secondaryActions' => $introBlockActionsSecondary))

@php
$titleBarLinks = array();
array_push($titleBarLinks, array('text' => 'Explore What&rsquo;s on', 'href' => '#'));
@endphp
@include('shared._title-bar', array('title' => 'What&rsquo;s on Today', 'links' => $titleBarLinks))

@php
$navTabPrimaryLinksPrimary = array();
array_push($navTabPrimaryLinksPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($navTabPrimaryLinksPrimary, array('text' => 'Events', 'href' => '#', 'active' => false));
@endphp
@include('shared._links-bar', array('variation' => 'tabs', 'linksPrimary' => $navTabPrimaryLinksPrimary))

@php
$navTabPrimaryLinksPrimary = array();
array_push($navTabPrimaryLinksPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($navTabPrimaryLinksPrimary, array('text' => 'Events', 'href' => '#', 'active' => false));
$navTabPrimaryLinksSecondary = array();
array_push($navTabPrimaryLinksSecondary, array('text' => 'Exhibitions', 'href' => '#'));
@endphp
@include('shared._links-bar', array('variation' => 'tabs', 'linksPrimary' => $navTabPrimaryLinksPrimary, 'linksSecondary' => $navTabPrimaryLinksSecondary))

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('text' => 'Events', 'href' => '#', 'active' => false));
@endphp
@include('shared._links-bar', array('linksPrimary' => $linksBarPrimary))

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('text' => 'Events', 'href' => '#', 'active' => false));
$linksBarPrimarySecondary = array();
array_push($linksBarPrimarySecondary, array('text' => 'Archive', 'href' => '#'));
@endphp
@include('shared._links-bar', array('linksPrimary' => $linksBarPrimary, 'linksSecondary' => $linksBarPrimarySecondary))

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true, 'icon' => 'icon--arrow'));
array_push($linksBarPrimary, array('text' => 'Events', 'href' => '#', 'active' => false, 'icon' => 'icon--arrow'));
$linksBarPrimarySecondary = array();
array_push($linksBarPrimarySecondary, array('text' => 'Archive', 'href' => '#', 'icon' => 'icon--arrow'));
@endphp
@include('shared._links-bar', array('linksPrimary' => $linksBarPrimary, 'linksSecondary' => $linksBarPrimarySecondary))

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Btn 1', 'href' => '#', 'variation' => ''));
array_push($linksBarPrimary, array('text' => 'Btn 2', 'href' => '#', 'variation' => 'btn--secondary'));
array_push($linksBarPrimary, array('text' => 'Btn 3', 'href' => '#', 'variation' => 'btn--tertiary'));
array_push($linksBarPrimary, array('text' => 'Btn 4', 'href' => '#', 'variation' => 'btn--quaternary'));
array_push($linksBarPrimary, array('text' => 'Btn 5', 'href' => '#', 'variation' => 'btn--secondary btn--w-icon', 'icon' => 'icon--new-window'));
@endphp
@include('shared._links-bar', array('variation' => 'buttons', 'linksPrimary' => $linksBarPrimary))

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Upcoming Exhibits', 'href' => '#', 'variation' => ''));
$linksBarPrimarySecondary = array();
array_push($linksBarPrimarySecondary, array('text' => 'Archive', 'href' => '#'));
@endphp
@include('shared._links-bar', array('variation' => 'buttons', 'linksPrimary' => $linksBarPrimary, 'linksSecondary' => $linksBarPrimarySecondary))


@include('shared._aside-newsletter')
@include('shared._aside-newsletter', array('error' => true))
@include('shared._aside-newsletter', array('success' => true))

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
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing, no cols, o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--gridlines-top">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing, no cols, o-grid-listing--gridlines-rows</p>
<ul class="o-grid-listing o-grid-listing--gridlines-rows">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing, no cols, o-grid-listing--gridlines-split-rows</p>
<ul class="o-grid-listing o-grid-listing--gridlines-split-rows">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing, 2 cols at small, 3 cols at medium, 4 cols large+ (most examples follow this)</p>
<ul class="o-grid-listing o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--keyline-top</p>
<ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--gridlines-right</p>
<ul class="o-grid-listing o-grid-listing--gridlines-right o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--gridlines-cols</p>
<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--keyline-top o-grid-listing--gridlines-cols</p>
<ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--gridlines-cols o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--keyline-top o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--gridlines-rows</p>
<ul class="o-grid-listing o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--gridlines-right o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--gridlines-right o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--keyline-top o-grid-listing--gridlines-right o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--gridlines-right o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--gridlines-right o-grid-listing--gridlines-rows</p>
<ul class="o-grid-listing o-grid-listing--gridlines-right o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--gridlines-cols o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--keyline-top o-grid-listing--gridlines-cols o-grid-listing--gridlines-top</p>
<ul class="o-grid-listing o-grid-listing--keyline-top o-grid-listing--gridlines-cols o-grid-listing--gridlines-top o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows</p>
<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--gridlines-split-rows</p>
<ul class="o-grid-listing o-grid-listing--gridlines-split-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--gridlines-right o-grid-listing--gridlines-split-rows</p>
<ul class="o-grid-listing o-grid-listing--gridlines-right o-grid-listing--gridlines-split-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
</ul>

<hr class="hr--big-break">
<p class="f-secondary">o-grid-listing--gridlines-cols o-grid-listing--gridlines-split-rows</p>
<ul class="o-grid-listing o-grid-listing--gridlines-cols o-grid-listing--gridlines-split-rows o-grid-listing--2-col@small o-grid-listing--3-col@medium o-grid-listing--4-col@large o-grid-listing--4-col@xlarge o-grid-listing--4-col@xxlarge">
  @include('shared._listitems')
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

@endsection
