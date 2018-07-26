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

@component('components.atoms._hr')
@endcomponent

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
@component('components.atoms._hr')
@endcomponent

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
<p style="margin-top: 20px;">
  <a href="#" class="checkbox f-secondary">Lorem <em>(13)</em></a>
  <a href="#" class="checkbox f-secondary">Ipsum <em>(12)</em></a>
</p>
@component('components.atoms._hr')
@endcomponent

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
@component('components.atoms._hr')
@endcomponent

<p class="f-quote">select:</p>
<p>
  @component('components.atoms._select')
    @slot('id', 'select1')
    @slot('name', 'select1')
    @slot('options', array(array('value' => '1', 'label' => 'Option 1'), array('value' => '2', 'label' => 'Option 2'), array('value' => '3', 'label' => 'Option 3')))
    @slot('disabled', true)
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
@component('components.atoms._hr')
@endcomponent

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
    @component('components.atoms._btn')
        @slot('variation', 'btn--septenary')
        Septenary
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--octonary')
        Octonary
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--nonary')
        Nonary
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
    @component('components.atoms._btn')
        @slot('variation', 'btn--septenary')
        @slot('icon', 'icon--new-window')
        Septenary
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--octonary')
        @slot('icon', 'icon--new-window')
        Octonary
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--nonary')
        @slot('icon', 'icon--new-window')
        Nonary
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
    @component('components.atoms._btn')
        @slot('variation', 'btn--septenary btn--icon')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--octonary btn--icon')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--nonary btn--icon')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
</p>
<p style="margin-top: 20px;">
    @component('components.atoms._btn')
        @slot('variation', 'btn--icon btn--icon-circle-48')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--secondary btn--icon btn--icon-circle-48')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--tertiary btn--icon btn--icon-circle-48')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--quaternary btn--icon btn--icon-circle-48')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--quinary btn--icon btn--icon-circle-48')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--senary btn--icon btn--icon-circle-48')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--septenary btn--icon btn--icon-circle-48')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--octonary btn--icon btn--icon-circle-48')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--nonary btn--icon btn--icon-circle-48')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
</p>
<p style="margin-top: 20px;">
    @component('components.atoms._btn')
        @slot('variation', 'btn--icon-sq')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--secondary btn--icon-sq')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--tertiary btn--icon-sq')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--quaternary btn--icon-sq')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--quinary btn--icon-sq')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--senary btn--icon-sq')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--septenary btn--icon-sq')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--octonary btn--icon-sq')
        @slot('font', '')
        @slot('icon', 'icon--print--24')
    @endcomponent
    @component('components.atoms._btn')
        @slot('variation', 'btn--nonary btn--icon-sq')
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
@component('components.atoms._hr')
@endcomponent

<p class="f-quote">tag:</p>
<p style="margin-top: 20px;">
    @component('components.atoms._tag')
        @slot('href','#')
        Kanan Jarrus
    @endcomponent
    @component('components.atoms._tag')
        @slot('href','#')
        Caleb Dume
    @endcomponent
    @component('components.atoms._tag')
        @slot('variation','tag--primary')
        @slot('href','#')
        Primary
    @endcomponent
    @component('components.atoms._tag')
        @slot('variation','tag--secondary')
        @slot('href','#')
        Secondary
    @endcomponent
    @component('components.atoms._tag')
        @slot('variation','tag--tertiary')
        @slot('href','#')
        Tertiary
    @endcomponent
    @component('components.atoms._tag')
        @slot('variation','tag--quaternary')
        @slot('href','#')
        Quaternary
    @endcomponent
    @component('components.atoms._tag')
        @slot('variation','tag--quinary')
        @slot('href','#')
        Quinary
    @endcomponent
</p>
<p style="margin-top: 20px;">
    @component('components.atoms._tag')
        @slot('font', 'f-tag-2')
        @slot('href','#')
        f-tag-2
    @endcomponent
</p>
<p style="margin-top: 20px;">
    @component('components.atoms._tag')
        @slot('variation', 'tag--senary')
        @slot('href','#')
        Senary
    @endcomponent
</p>
<p style="margin-top: 20px;">
    @component('components.atoms._tag')
        @slot('variation', 'tag--senary tag--w-image')
        @slot('href','#')
        @component('components.atoms._img')
            @slot('src', 'http://placehold.dev.area17.com/image/60x60')
            @slot('width', '60')
            @slot('height', '60')
        @endcomponent
        Senary, with Image
    @endcomponent
</p>
<p style="margin-top: 20px;">
    @component('components.atoms._tag')
        @slot('font', 'f-tag-2')
        @slot('variation', 'tag--quaternary tag--l')
        @slot('href','#')
        Large, quaternary with icon
        <svg class="icon--close"><use xlink:href="#icon--close" /></svg>
    @endcomponent
</p>

@component('components.atoms._hr')
@endcomponent

<p class="f-quote">arrow-link:</p>
<p>
    @component('components.atoms._arrow-link')
        @slot('href', '#')
        Forward
    @endcomponent
    <br>
    @component('components.atoms._arrow-link')
        @slot('href', '#')
        @slot('variation','arrow-link--back')
        Back
    @endcomponent
    <br>
    @component('components.atoms._arrow-link')
        @slot('href', '#')
        @slot('variation','arrow-link--up')
        Up
    @endcomponent
    <br>
    @component('components.atoms._arrow-link')
        @slot('href', '#')
        @slot('variation','arrow-link--down')
        Down
    @endcomponent
</p>

@component('components.atoms._hr')
@endcomponent

<p class="f-quote">m-intro-block:</p>

@component('components.molecules._m-intro-block')
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet tortor.
@endcomponent

@component('components.molecules._m-intro-block')
    @slot('links', array(array('label' => 'Plan your visit', 'href' => '#', 'variation' => 'btn')))
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eget laoreet tortor.
@endcomponent

@component('components.atoms._hr')
@endcomponent

<p class="f-quote">m-title-bar:</p>

@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Explore What&rsquo;s on', 'href' => '#')))
    What&rsquo;s on Today
@endcomponent

@component('components.molecules._m-title-bar')
    @slot('links', array(array('label' => 'Browse all current exhibitions', 'href' => '#')))
    Exhibitions and Events
@endcomponent

@component('components.atoms._hr')
@endcomponent

<p class="f-quote">m-listing-header:</p>

@component('components.molecules._m-listing-header')
    @slot('count', 'Showing 1-10 press releases')
@endcomponent

@component('components.atoms._hr')
@endcomponent

<p class="f-quote">m-links-bar:</p>

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('label' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('label' => 'Events', 'href' => '#', 'active' => false));
@endphp
@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--tabs')
    @slot('overflow', true)
    @slot('linksPrimary', $linksBarPrimary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('label' => 'Lorem', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('label' => 'Ipsum', 'href' => '#', 'active' => false));
array_push($linksBarPrimary, array('label' => 'Aenean', 'href' => '#', 'active' => false));
array_push($linksBarPrimary, array('label' => 'Consectetur', 'href' => '#', 'active' => false));
array_push($linksBarPrimary, array('label' => 'Sollicitudin', 'href' => '#', 'active' => false));
array_push($linksBarPrimary, array('label' => 'Rurpis', 'href' => '#', 'active' => false));
@endphp
@component('components.molecules._m-links-bar')
    @slot('overflow', true)
    @slot('variation', 'm-links-bar--tabs')
    @slot('linksPrimary', $linksBarPrimary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('label' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('label' => 'Events', 'href' => '#', 'active' => false));
$linksBarSecondary = array();
array_push($linksBarSecondary, array('label' => 'Exhibitions', 'href' => '#'));
array_push($linksBarSecondary, array('label' => 'Exhibitions', 'href' => '#'));
@endphp
@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--tabs')
    @slot('overflow', true)
    @slot('linksPrimary', $linksBarPrimary)
    @slot('linksSecondary', $linksBarSecondary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('label' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('label' => 'Events', 'href' => '#', 'active' => false));
@endphp
@component('components.molecules._m-links-bar')
    @slot('linksPrimary', $linksBarPrimary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('label' => 'Exhibitions', 'href' => '#', 'active' => true));
array_push($linksBarPrimary, array('label' => 'Events', 'href' => '#', 'active' => false));
array_push($linksBarPrimary, array('label' => 'Events', 'href' => '#', 'active' => false, 'liVariation' => 'm-links-bar__item--push'));
@endphp
@component('components.molecules._m-links-bar')
    @slot('linksPrimary', $linksBarPrimary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('label' => 'Exhibitions<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => '#', 'variation' => 'arrow-link', 'active' => true));
array_push($linksBarPrimary, array('label' => 'Events<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => '#', 'variation' => 'arrow-link', 'active' => false));
array_push($linksBarPrimary, array('label' => 'Archive', 'href' => '#', 'active' => false, 'liVariation' => 'm-links-bar__item--push'));
array_push($linksBarPrimary, array('label' => 'All', 'href' => '#', 'active' => false, 'liVariation' => 'm-links-bar__item--push'));
@endphp
@component('components.molecules._m-links-bar')
    @slot('linksPrimary', $linksBarPrimary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('label' => 'Btn 1', 'href' => '#', 'variation' => ''));
array_push($linksBarPrimary, array('label' => 'Btn 2', 'href' => '#', 'variation' => 'btn--secondary'));
array_push($linksBarPrimary, array('label' => 'Btn 3', 'href' => '#', 'variation' => 'btn--tertiary'));
array_push($linksBarPrimary, array('label' => 'Btn 4', 'href' => '#', 'variation' => 'btn--quaternary'));
array_push($linksBarPrimary, array('label' => 'Btn 5', 'href' => '#', 'variation' => 'btn--secondary btn--w-icon', 'icon' => 'icon--new-window'));
@endphp
@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--buttons')
    @slot('linksPrimary', $linksBarPrimary)
@endcomponent

@php
$linksBarPrimary = array();
array_push($linksBarPrimary, array('label' => 'Upcoming exhibitions', 'href' => '#', 'variation' => ''));
$linksBarPrimarySecondary = array();
array_push($linksBarPrimarySecondary, array('label' => 'Archive', 'href' => '#'));
@endphp
@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--buttons')
    @slot('linksPrimary', $linksBarPrimary)
    @slot('linksSecondary', $linksBarPrimarySecondary)
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('variation', 'm-links-bar--title-bar-companion')
    @slot('linksPrimary', array(array('label' => 'Browse all current exhibitions', 'href' => '#', 'variation' => 'btn btn--secondary f-buttons')))
@endcomponent

@component('components.molecules._m-links-bar')
    @slot('overflow', true)
    @slot('variation', 'm-links-bar--nav-bar')
    @slot('linksPrimary', array(
      array('label' => 'Hours', 'href' => '#'),
      array('label' => 'Admission', 'href' => '#admission'),
      array('label' => 'Directions', 'href' => '#directions'),
      array('label' => 'Dining', 'href' => '#dining'),
      array('label' => 'FAQ', 'href' => '#faq'),
      array('label' => 'Tours', 'href' => '#tours'),
      array('label' => 'Families, Teens &amp; Educators', 'href' => '#familes_teens_educators'),
    ))
    @slot('secondaryHtml')
        <li class="m-links-bar__item  m-links-bar__item--primary">
            @component('components.atoms._dropdown')
              @slot('prompt', 'Select language')
              @slot('ariaTitle', 'Select language')
              @slot('variation','dropdown--filter f-link')
              @slot('font', null)
              @slot('options', array(
                array('href' => '#', 'label' => 'English'),
                array('href' => '#', 'label' => 'Español'),
                array('href' => '#', 'label' => 'Français'),
                array('href' => '#', 'label' => 'Deutsch'),
                array('href' => '#', 'label' => '日本語'),
                array('href' => '#', 'label' => 'Português'),
              ))
            @endcomponent
        </li>
    @endslot
@endcomponent

@component('components.atoms._hr')
@endcomponent

<p class="f-quote">m-cta-banner:</p>

@component('components.molecules._m-cta-banner----become-a-member')
@endcomponent

@component('components.atoms._hr')
@endcomponent

<p class="f-quote">m-aside-newsletter:</p>

@component('components.molecules._m-aside-newsletter')
@endcomponent
@component('components.molecules._m-aside-newsletter')
    @slot('error', 'Please enter a valid email address')
@endcomponent
@component('components.molecules._m-aside-newsletter')
    @slot('success', 'Successfully signed up to the newsletter')
@endcomponent

@component('components.atoms._hr')
@endcomponent

<p class="f-quote">m-image-stack:</p>
@component('components.molecules._m-image-stack')
    @slot('images', $stackImages)
@endcomponent

@component('components.atoms._hr')
@endcomponent

<p class="f-quote" id="test">date-select-trigger:</p>

<p style="margin-top: 20px;">
    @component('components.atoms._date-select-trigger')
        Select dates
    @endcomponent
</p>

@component('components.atoms._hr')
@endcomponent

<p class="f-quote">day:</p>

@component('components.atoms._day')
    @slot('date', '13')
    @slot('month', 'Dec')
    @slot('day', 'Mon')
@endcomponent

@component('components.atoms._hr')
@endcomponent

<p class="f-quote">dropdown:</p>
<div style="margin-top: 20px;">
  @component('components.atoms._dropdown')
    @slot('prompt', 'Dropdown')
    @slot('ariaTitle', 'Filter by')
    @slot('options', array(array('href' => '#', 'label' => 'Option 1'), array('href' => 'http://www.google.com/', 'label' => 'Option 2'), array('href' => '#', 'label' => 'Option 3'), array('href' => '#', 'label' => 'Option 4'), array('href' => '#', 'label' => 'Option 5'), array('href' => '#', 'label' => 'Option 6'), array('href' => '#', 'label' => 'Option 7'), array('href' => '#', 'label' => 'Option 8'), array('href' => '#', 'label' => 'Option 9'), array('href' => '#', 'label' => 'Option 10')))
  @endcomponent
  @component('components.atoms._dropdown')
    @slot('prompt', 'Dropdown')
    @slot('ariaTitle', 'Filter by')
    @slot('options', array(array('href' => '#', 'label' => 'Option 1'), array('href' => '#', 'label' => 'Option 2'), array('href' => '#', 'label' => 'Option 3'), array('href' => '#', 'label' => 'Option 4'), array('href' => '#', 'label' => 'Option 5'), array('href' => '#', 'label' => 'Option 6'), array('href' => '#', 'label' => 'Option 7'), array('href' => '#', 'label' => 'Option 8'), array('href' => '#', 'label' => 'Option 9'), array('href' => '#', 'label' => 'Option 10')))
  @endcomponent
</div>
<p class="f-body">If the dropdown is in a m-links bar, add variation <code>dropdown--filter</code></p>
{{--
<div style="margin-top: 20px;">
  @component('components.atoms._dropdown')
    @slot('prompt', 'Dropdown filter hoverable')
    @slot('variation', 'dropdown--filter')
    @slot('ariaTitle', 'Sort by')
    @slot('hoverable', true)
    @slot('options', array(array('href' => '#', 'label' => 'Newest'), array('href' => '#', 'label' => 'Oldest')))
  @endcomponent
</div> --}}

@component('components.atoms._hr')
@endcomponent

<p class="f-quote">mixed links bar:</p>

@component('components.molecules._m-links-bar')
    @slot('linksPrimary', array(
        array('label' => 'Today', 'href' => '#', 'active' => true),
        array('label' => 'Tomorrow', 'href' => '#', 'liVariation' => "u-hide@xsmall u-hide@small u-hide@medium"),
        array('label' => 'This weekend', 'href' => '#', 'liVariation' => "u-hide@xsmall u-hide@small")
    ))
    @slot('primaryHtml')
        <li class="m-links-bar__item">
            @component('components.atoms._date-select-trigger')
                Pick a date
            @endcomponent
        </li>
    @endslot
    @slot('secondaryHtml')
        <li class="m-links-bar__item  m-links-bar__item--primary">
            @component('components.atoms._dropdown')
              @slot('prompt', 'All event types')
              @slot('ariaTitle', 'Filter by')
              @slot('variation','dropdown--filter f-link')
              @slot('font', null)
              @slot('options', array(
                array('href' => '#', 'label' => 'All event types'),
                array('href' => '#', 'label' => 'Classes and workshops'),
                array('href' => '#', 'label' => 'Live Arts'),
                array('href' => '#', 'label' => 'Screenings'),
                array('href' => '#', 'label' => 'Special Events'),
                array('href' => '#', 'label' => 'Talks'),
                array('href' => '#', 'label' => 'Tours'),
              ))
            @endcomponent
        </li>
    @endslot
@endcomponent

@endsection
