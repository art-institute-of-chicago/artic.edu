@extends('layouts.app')

@section('content')

@component('components.molecules._m-notification')
    <svg class="icon--info" aria-hidden="true"><use xlink:href="#icon--info" /></svg>Because of the weather conditions we're closed today. <a href="#">Learn More</a>
@endcomponent
@component('components.molecules._m-notification')
    @slot('variation', 'm-notification--secondary')
    <svg class="icon--alert" aria-hidden="true"><use xlink:href="#icon--alert" /></svg>Secondary notification with icon
@endcomponent
@component('components.molecules._m-notification')
    @slot('variation', 'm-notification--tertiary')
    <svg class="icon--alert" aria-hidden="true"><use xlink:href="#icon--alert" /></svg>Tertiary notification with icon
@endcomponent
@component('components.molecules._m-notification')
    @slot('variation', 'm-notification--quaternary')
    <svg class="icon--alert" aria-hidden="true"><use xlink:href="#icon--alert" /></svg>Quaternary notification with icon
@endcomponent
@component('components.molecules._m-notification')
    @slot('variation', 'm-notification--error')
    <svg class="icon--alert" aria-hidden="true"><use xlink:href="#icon--alert" /></svg>Error notification with icon
@endcomponent
@component('components.molecules._m-notification')
    @slot('variation', 'm-notification--quinary')
    @slot('title', 'Quinary with title')
    Dictum consectetur nunc eu luctus lacus <a href="#">integer auctor</a> velit ac porttitor malesuada
@endcomponent

<span class="hr"></span>
<p class="f-quote">radio:</p>
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
<span class="hr"></span>
<p class="f-quote">checkbox:</p>
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
<span class="hr"></span>
<p class="f-quote">input:</p>
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
<span class="hr"></span>
<p class="f-quote">select:</p>
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
<span class="hr"></span>
<p class="f-quote">btn:</p>
<p style="margin-top: 20px;">
    @component('components.atoms._btn')
        Default
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--secondary')
        Secondary
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--tertiary')
        Tertiary
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--quaternary')
        Quaternary
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--quinary')
        Quinary
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--senary')
        Senary
    @endcomponent
</p>
<p style="margin-top: 20px;">
    @component('components.atoms._btn')
        @slot('icon', 'icon--new-window')
        Default
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--secondary')
        @slot('icon', 'icon--new-window')
        Secondary
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--tertiary')
        @slot('icon', 'icon--new-window')
        Tertiary
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--quaternary')
        @slot('icon', 'icon--new-window')
        Quaternary
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--quinary')
        @slot('icon', 'icon--new-window')
        Quinary
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--senary')
        @slot('icon', 'icon--new-window')
        Senary
    @endcomponent
</p>
<p style="margin-top: 20px;">
    @component('components.atoms._btn')
        @slot('variation', 'btn--icon')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--secondary btn--icon')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--tertiary btn--icon')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--quaternary btn--icon')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--quinary btn--icon')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--senary btn--icon')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
</p>
<p style="margin-top: 20px;">
    @component('components.atoms._btn')
        @slot('disabled', true)
        Action
    @endcomponent
    @component('components.atoms._btn')
        @slot('loading', true)
        Action
    @endcomponent
</p>
<div class="o-gallery" style="margin-top: 20px; padding: 20px 0;">
    <p style="margin-top: 0;">
        @component('components.atoms._btn')
            @slot('variation', 'btn--contrast')
            Contrast
        @endcomponent
        @component('components.atoms._btn')
            @slot('variation', 'btn--contrast')
            @slot('icon', 'icon--new-window')
            With Icon
        @endcomponent
        @component('components.atoms._btn')
            @slot('variation', 'btn--contrast btn--icon')
            @slot('font', '')
            @slot('icon', 'icon--print--24')
        @endcomponent
        @component('components.atoms._btn')
            @slot('variation', 'btn--contrast-secondary')
            Contrast secondary
        @endcomponent
        @component('components.atoms._btn')
            @slot('variation', 'btn--contrast-secondary')
            @slot('icon', 'icon--new-window')
            With Icon
        @endcomponent
        @component('components.atoms._btn')
            @slot('variation', 'btn--contrast-secondary btn--icon')
            @slot('font', '')
            @slot('icon', 'icon--print--24')
        @endcomponent
    </p>
</div>
<p class="f-body">Btns with actions</p>
<p style="margin-top: 20px;">
    @component('components.atoms._btn')
        @slot('variation', 'btn--icon')
        @slot('font', '')
        @slot('icon', 'icon--share--24')
        @slot('behavior','sharePage')
        @slot('dataAttributes','data-share-title=Hello World')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--secondary btn--icon')
        @slot('font', '')
        @slot('icon', 'icon--share--24')
        @slot('behavior','sharePage')
        @slot('dataAttributes',"data-share-title='AREA 17' data-share-url='http://www.area17.com'")
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--tertiary btn--icon')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
        @slot('behavior','printPage')
    @endcomponent
</p>
<span class="hr"></span>
<p class="f-quote">tag:</p>
<p style="margin-top: 20px;">
    @component('components.atoms._tag')
        Kanan Jarrus
    @endcomponent
    @component('components.atoms._tag')
        Caleb Dume
    @endcomponent
</p>

<span class="hr"></span>
<p class="f-quote">dropdown:</p>
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

<span class="hr"></span>
<p class="f-quote">arrow-link:</p>
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

<span class="hr"></span>
<p class="f-quote">m-intro-block:</p>

@component('components.molecules._m-intro-block')
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet tortor.
@endcomponent

@component('components.molecules._m-intro-block')
    @slot('links', array(array('text' => 'Plan your visit', 'href' => '#', 'variation' => 'btn')))
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet tortor.
@endcomponent

<span class="hr"></span>
<p class="f-quote">m-title-bar:</p>

@component('components.molecules._m-title-bar')
    @slot('links', array(array('text' => 'Explore What&rsquo;s on', 'href' => '#')))
    What&rsquo;s on Today
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('text' => 'Browse all current exhibitions', 'href' => '#')))
    Exhibitions and Events
@endcomponent

<span class="hr"></span>
<p class="f-quote">m-links-bar:</p>

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
array_push($linksBarPrimary, array('text' => 'Exhibitions', 'href' => '#', 'variation' => 'arrow-link', 'active' => true, 'icon' => 'icon--arrow'));
array_push($linksBarPrimary, array('text' => 'Events', 'href' => '#', 'variation' => 'arrow-link', 'active' => false, 'icon' => 'icon--arrow'));
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
    @slot('variation', 'm-links-bar--buttons')
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

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--title-bar-companion')
    @slot('linksPrimary', array(array('text' => 'Browse all current exhibitions', 'href' => '#', 'variation' => 'btn btn--secondary f-buttons')))
@endcomponent

<span class="hr"></span>
<p class="f-quote">m-cta-banner:</p>

@component('components.molecules._m-cta-banner----become-a-member')
@endcomponent

<span class="hr"></span>
<p class="f-quote">m-aside-newsletter:</p>

@component('components.molecules._m-aside-newsletter')
@endcomponent
@component('components.molecules._m-aside-newsletter')
    @slot('error', 'Please enter a valid email address')
@endcomponent
@component('components.molecules._m-aside-newsletter')
    @slot('success', 'Successfully signed up to the newsletter')
@endcomponent

<span class="hr"></span>
<p class="f-quote">m-image-stack:</p>
@component('components.molecules._m-image-stack')
    @slot('images', $stackImages)
@endcomponent

<span class="hr"></span>
<p class="f-quote">date-select-trigger:</p>

<p style="margin-top: 20px;">
    @component('components.atoms._date-select-trigger')
        Go to date
    @endcomponent
</p>

<p style="margin-top: 20px;">
    @component('components.atoms._date-select-trigger')
        @slot('hiddenInputName', 'date0')
        @slot('hiddenInputId', 'date0')
        Choose date
    @endcomponent
</p>

<p style="margin-top: 20px;">
    @component('components.molecules._m-date-select-range')
        @slot('startLabel', 'Start date')
        @slot('startId', 'cal01')
        @slot('startHiddenInputName', 'dateStart01')
        @slot('startHiddenInputId', 'dateStart01')
        @slot('endLabel', 'End date')
        @slot('endId', 'cal02')
        @slot('endHiddenInputName', 'dateEnd01')
        @slot('endHiddenInputId', 'dateEnd01')
    @endcomponent
</p>

<span class="hr"></span>
<p class="f-quote">date-select-trigger in m-links-bar:</p>

@component('components.molecules._m-links-bar')
    @slot('linksPrimary', array(array('text' => 'Exhibitions', 'href' => '#', 'active' => false)))
    @slot('linksSecondary', array(array('text' => 'Archive', 'href' => '#')))

    @component('components.atoms._date-select-trigger')
        Go to date
    @endcomponent
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('linksPrimary', array(array('text' => 'Exhibitions', 'href' => '#', 'active' => false)))
    @slot('linksSecondary', array(array('text' => 'Archive', 'href' => '#')))

    @component('components.molecules._m-date-select-range')
        @slot('startLabel', 'Start date')
        @slot('startId', 'cal03')
        @slot('startHiddenInputName', 'dateStart02')
        @slot('startHiddenInputId', 'dateStart02')
        @slot('endLabel', 'End date')
        @slot('endId', 'cal04')
        @slot('endHiddenInputName', 'dateEnd02')
        @slot('endHiddenInputId', 'dateEnd02')
    @endcomponent
@endcomponent

@endsection
