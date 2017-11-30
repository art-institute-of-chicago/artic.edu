@extends('layouts.app')

@section('content')

<p>
  @component('components.atoms._radio')
    @slot('id', 'roption1')
    @slot('value', 'roption1')
    @slot('name', 'roptions')
    @slot('label', 'Option 1')
  @endcomponent
  @component('components.atoms._radio')
    @slot('id', 'roption2')
    @slot('value', 'roption2')
    @slot('name', 'roptions')
    @slot('label', 'Option 2 checked')
    @slot('checked', 'checked')
  @endcomponent
  @component('components.atoms._radio')
    @slot('id', 'roption3')
    @slot('value', 'roption3')
    @slot('name', 'roptions')
    @slot('label', 'Option 3 disabled')
    @slot('disabled', 'disabled')
  @endcomponent
  @component('components.atoms._radio')
    @slot('id', 'roption4')
    @slot('value', 'roption4')
    @slot('name', 'roptions')
    @slot('label', 'Option 4 error')
    @slot('error', 'Error message')
  @endcomponent
</p>
<p>
  @component('components.atoms._checkbox')
    @slot('id', 'coption1')
    @slot('value', 'coption1')
    @slot('name', 'coption1')
    @slot('label', 'Option 1')
  @endcomponent
  @component('components.atoms._checkbox')
    @slot('id', 'coption2')
    @slot('value', 'coption2')
    @slot('name', 'coption2')
    @slot('label', 'Option 2 checked')
    @slot('checked', 'checked')
  @endcomponent
  @component('components.atoms._checkbox')
    @slot('id', 'coption3')
    @slot('value', 'coption3')
    @slot('name', 'coption3')
    @slot('label', 'Option 3 disabled')
    @slot('disabled', 'disabled')
  @endcomponent
  @component('components.atoms._checkbox')
    @slot('id', 'coption4')
    @slot('value', 'coption4')
    @slot('name', 'coption4')
    @slot('label', 'Option 4 error')
    @slot('error', 'Error message')
  @endcomponent
</p>
<p>
  @component('components.atoms._input')
    @slot('id', 'tinput1')
    @slot('name', 'tinput1')
    @slot('placeholder', 'Placeholder')
    Label
  @endcomponent
</p>
<p>
    @component('components.atoms._input')
      @slot('id', 'tinput2')
      @slot('name', 'tinput2')
      @slot('placeholder', 'Placeholder')
      @slot('textCount', true)
      Label
    @endcomponent
</p>
<p>
  @component('components.atoms._input')
    @slot('id', 'tinput3')
    @slot('name', 'tinput3')
    @slot('placeholder', 'Placeholder')
    @slot('value', 'Value')
    @slot('error', 'Error message')
    Label
  @endcomponent
</p>
<p>
    @component('components.atoms._input')
      @slot('id', 'tinput4')
      @slot('name', 'tinput4')
      @slot('placeholder', 'Disabled')
      @slot('disabled', true)
      Label
    @endcomponent
</p>
<p>
    @component('components.atoms._textarea')
      @slot('id', 'textarea1')
      @slot('name', 'textarea1')
      @slot('value', 'Mon jinn chewbacca darth darth kenobi. Moff fett hutt cade dantooine organa skywalker. Yavin darth calamari dagobah. Maul tusken raider hutt grievous.')
      Label
    @endcomponent
</p>
<p>
    @component('components.atoms._select')
      @slot('id', 'select1')
      @slot('name', 'select1')
      @slot('options', array(array('value' => '1', 'label' => 'Option 1'), array('value' => '2', 'label' => 'Option 2'), array('value' => '3', 'label' => 'Option 3')))
      @slot('error', 'Error message')
      Label
    @endcomponent
</p>
<p>
    @component('components.atoms._select')
      @slot('id', 'select2')
      @slot('name', 'select2')
      @slot('options', array(array('value' => '1', 'label' => 'Option 1'), array('value' => '2', 'label' => 'Option 2'), array('value' => '3', 'label' => 'Option 3')))
      @slot('error', 'Error message')
      Label
    @endcomponent
</p>
<p>
  @component('components.atoms._select')
    @slot('id', 'select1')
    @slot('name', 'select1')
    @slot('options', array(array('value' => '1', 'label' => 'Option 1'), array('value' => '2', 'label' => 'Option 2'), array('value' => '3', 'label' => 'Option 3')))
    @slot('disabled', true)
    Label
  @endcomponent
</p>
<p style="margin-top: 20px;">
    @component('components.atoms._btn')
      Action
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--secondary')
        Action
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--tertiary')
        Action
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--quaternary')
        Action
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--secondary')
        @slot('icon', 'icon--new-window')
        Action
    @endcomponent
    @component('components.atoms._btn')
        @slot('disabled', true)
        Action
    @endcomponent
    @component('components.atoms._btn')
        @slot('loading', true)
        Action
    @endcomponent
</p>
<p>
    @component('components.atoms._tag')
        Kanan Jarrus
    @endcomponent
    @component('components.atoms._tag')
        Caleb Dume
    @endcomponent
</p>

<div style="margin-top: 20px;">
  @component('components.atoms._dropdown')
    @slot('prompt', 'Dropdown')
    @slot('ariaTitle', 'Filter by')
    @slot('options', array(array('href' => '#', 'label' => 'Option 1'), array('href' => '#', 'label' => 'Option 2'), array('href' => '#', 'label' => 'Option 3'), array('href' => '#', 'label' => 'Option 4'), array('href' => '#', 'label' => 'Option 5'), array('href' => '#', 'label' => 'Option 6'), array('href' => '#', 'label' => 'Option 7'), array('href' => '#', 'label' => 'Option 8'), array('href' => '#', 'label' => 'Option 9'), array('href' => '#', 'label' => 'Option 10')))
    Label
  @endcomponent
</div>
<div style="margin-top: 20px;">
  @component('components.atoms._dropdown')
    @slot('prompt', 'Dropdown hoverable')
    @slot('ariaTitle', 'Sort by')
    @slot('hoverable', true)
    @slot('options', array(array('href' => '#', 'label' => 'Newest'), array('href' => '#', 'label' => 'Oldest')))
    Label
  @endcomponent
</div>
<div style="margin-top: 20px;">
  @component('components.atoms._dropdown')
    @slot('prompt', 'Dropdown')
    @slot('variation', 'dropdown--filter')
    @slot('ariaTitle', 'Sort by')
    @slot('options', array(array('href' => '#', 'label' => 'Dropdown', 'active' => true), array('href' => '#', 'label' => 'Option 1'), array('href' => '#', 'label' => 'Option 2'), array('href' => '#', 'label' => 'Option 3'), array('href' => '#', 'label' => 'Option 4'), array('href' => '#', 'label' => 'Option 5'), array('href' => '#', 'label' => 'Option 6'), array('href' => '#', 'label' => 'Option 7'), array('href' => '#', 'label' => 'Option 8'), array('href' => '#', 'label' => 'Option 9'), array('href' => '#', 'label' => 'Option 10')))
    Label
  @endcomponent
</div>

<p>
    @component('components.atoms._arrow-link')
        Forward
    @endcomponent
    <br>
    @component('components.atoms._arrow-link')
        @slot('variation','arrow-link--back')
        Back
    @endcomponent
    <br>
    @component('components.atoms._arrow-link')
        @slot('variation','arrow-link--up')
        Up
    @endcomponent
    <br>
    @component('components.atoms._arrow-link')
        @slot('variation','arrow-link--down')
        Down
    @endcomponent
</p>

@component('components.molecules._m-intro-block')
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet tortor.
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('text' => 'Explore What&rsquo;s on', 'href' => '#')))
    What&rsquo;s on Today
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('text' => 'Events', 'href' => '#', 'active' => false));
@endphp
@component('components.molecules._m-links-bar')
    @slot('variation', 'tabs')
    @slot('linksPrimary', $linksBarPrimary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('text' => 'Events', 'href' => '#', 'active' => false));
$linksBarSecondary = array();
array_push($linksBarSecondary, array('text' => 'Exhibitions', 'href' => '#'));
@endphp
@component('components.molecules._m-links-bar')
    @slot('variation', 'tabs')
    @slot('linksPrimary', $linksBarPrimary)
    @slot('linksSecondary', $linksBarSecondary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('text' => 'Events', 'href' => '#', 'active' => false));
@endphp
@component('components.molecules._m-links-bar')
    @slot('linksPrimary', $linksBarPrimary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('text' => 'Events', 'href' => '#', 'active' => false));
$linksBarPrimarySecondary = array();
array_push($linksBarPrimarySecondary, array('text' => 'Archive', 'href' => '#'));
@endphp
@component('components.molecules._m-links-bar')
    @slot('linksPrimary', $linksBarPrimary)
    @slot('linksSecondary', $linksBarSecondary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Exhibitions', 'href' => '#', 'active' => true, 'icon' => 'icon--arrow'));
array_push($linksBarPrimary, array('text' => 'Events', 'href' => '#', 'active' => false, 'icon' => 'icon--arrow'));
$linksBarPrimarySecondary = array();
array_push($linksBarPrimarySecondary, array('text' => 'Archive', 'href' => '#', 'icon' => 'icon--arrow'));
@endphp
@component('components.molecules._m-links-bar')
    @slot('linksPrimary', $linksBarPrimary)
    @slot('linksSecondary', $linksBarSecondary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Btn 1', 'href' => '#', 'variation' => ''));
array_push($linksBarPrimary, array('text' => 'Btn 2', 'href' => '#', 'variation' => 'btn--secondary'));
array_push($linksBarPrimary, array('text' => 'Btn 3', 'href' => '#', 'variation' => 'btn--tertiary'));
array_push($linksBarPrimary, array('text' => 'Btn 4', 'href' => '#', 'variation' => 'btn--quaternary'));
array_push($linksBarPrimary, array('text' => 'Btn 5', 'href' => '#', 'variation' => 'btn--secondary btn--w-icon', 'icon' => 'icon--new-window'));
@endphp
@component('components.molecules._m-links-bar')
    @slot('variation', 'buttons')
    @slot('linksPrimary', $linksBarPrimary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('text' => 'Upcoming Exhibits', 'href' => '#', 'variation' => ''));
$linksBarPrimarySecondary = array();
array_push($linksBarPrimarySecondary, array('text' => 'Archive', 'href' => '#'));
@endphp
@component('components.molecules._m-links-bar')
    @slot('variation', 'buttons')
    @slot('linksPrimary', $linksBarPrimary)
    @slot('linksSecondary', $linksBarPrimarySecondary)
@endcomponent


@component('components.molecules._m-aside-newsletter')
@endcomponent
@component('components.molecules._m-aside-newsletter')
    @slot('error', 'Please enter a valid email address')
@endcomponent
@component('components.molecules._m-aside-newsletter')
    @slot('success', 'Successfully signed up to the newsletter')
@endcomponent

<p>
    @component('components.atoms._date-select-trigger')
        Go to date
    @endcomponent
</p>

<p>
    @component('components.atoms._date-select-trigger')
        @slot('hiddenInputName', 'date0')
        @slot('hiddenInputId', 'date0')
        Choose date
    @endcomponent
</p>

<p>
    @component('components.atoms._date-select-trigger')
        @slot('hiddenInputName', 'dateStart')
        @slot('hiddenInputId', 'dateStart')
        @slot('range', true)
        @slot('selectDateId', 'cal01')
        @slot('selectDateRole', 'start')
        @slot('selectDateLinkedId', 'cal02')
        Start date
    @endcomponent
    @component('components.atoms._date-select-trigger')
        @slot('hiddenInputName', 'dateEnd')
        @slot('hiddenInputId', 'dateEnd')
        @slot('range', true)
        @slot('selectDateId', 'cal02')
        @slot('selectDateRole', 'end')
        @slot('selectDateLinkedId', 'cal01')
        End date
    @endcomponent
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

@endsection
