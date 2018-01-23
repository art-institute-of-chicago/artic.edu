@extends('layouts.app')

@section('content')

<section class="o-visit" data-behavior="internalLinksScroll">

  @component('components.molecules._m-media')
    @slot('item', $headerMedia)
  @endcomponent

  @component('components.molecules._m-links-bar')
      @slot('overflow', true)
      @slot('variation', 'm-links-bar--nav-bar')
      @slot('linksPrimary', array(
        array('label' => 'Hours', 'href' => '#hours'),
        array('label' => 'Admission', 'href' => '#admission'),
        array('label' => 'Directions', 'href' => '#directions'),
        array('label' => 'Dining', 'href' => '#dining'),
        array('label' => 'FAQ', 'href' => '#faq'),
        array('label' => 'Tours', 'href' => '#tours'),
        array('label' => 'Families, Teens &amp; Educators', 'href' => '#familes_teens_educators'),
      ))
      @slot('secondaryHtml')
          <li class="m-links-bar__item m-links-bar__item--primary">
              @component('components.atoms._dropdown')
                @slot('prompt', 'Select language')
                @slot('ariaTitle', 'Select language')
                @slot('variation','dropdown--filter f-buttons')
                @slot('font', 'f-buttons')
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

  @component('components.molecules._m-header-block')
      {{ $title }}
  @endcomponent

  @component('components.molecules._m-title-bar')
      @slot('id', 'hours')
      Hours
  @endcomponent

  @component('components.organisms._o-grid-listing')
      @slot('variation', 'o-grid-listing--gridlines-rows')
      @slot('cols_medium','2')
      @slot('cols_large','2')
      @slot('cols_xlarge','2')
      @slot('cols_xxlarge','2')
      @slot('tag', 'div')

      <div class="o-blocks">
        @component('components.molecules._m-media')
          @slot('item', $hours['media'])
        @endcomponent
      </div>
      <div class="o-blocks">
        @component('components.blocks._text')
            @slot('font','f-list-4')
            {{ $hours['primary'] }}
        @endcomponent
        @component('components.blocks._text')
            @slot('font','f-secondary')
            {{ $hours['secondary'] }}
        @endcomponent
      </div>
  @endcomponent

  @foreach ($hours['sections'] as $section)

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-rows')
        @slot('cols_small','2')
        @slot('cols_medium','2')
        @slot('cols_large','2')
        @slot('cols_xlarge','2')
        @slot('cols_xxlarge','2')
        @slot('tag', 'div')

        <div class="o-blocks">
          @component('components.blocks._text')
              @slot('font','f-list-3')
              @slot('tag','h3')
              <a href="{{ $section['link'] }}">
                {{ $section['title'] }}
                <svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
              </a>
          @endcomponent
        </div>
        <div class="o-blocks">
          @component('components.blocks._text')
              @slot('font','f-secondary')
              {{ $section['text'] }}
          @endcomponent
        </div>
    @endcomponent

  @endforeach


  @component('components.molecules._m-title-bar')
      @slot('id', 'admission')
      Admission
  @endcomponent

  <div class="m-table">
    <table>
      <thead>
        <tr>
          <td>&nbsp;</td>
          <th>
            @component('components.blocks._text')
                @slot('font', 'f-module-title-1')
                @slot('tag','span')
                General Admission
            @endcomponent
          </th>
          <th>
            @component('components.blocks._text')
                @slot('font', 'f-module-title-1')
                @slot('tag','span')
                Chicago Residents
            @endcomponent
            &nbsp;
            @component('components.atoms._info-button-trigger')
                A valid photo ID with a resident address is required for Chicago and Illinois resident admission prices. Discount only available at museum admission desks.
            @endcomponent
          </th>
          <th>
            @component('components.blocks._text')
                @slot('font', 'f-module-title-1')
                @slot('tag','span')
                Illinois Residents
            @endcomponent
            &nbsp;
            @component('components.atoms._info-button-trigger')
                A valid photo ID with a resident address is required for Chicago and Illinois resident admission prices. Discount only available at museum admission desks.
            @endcomponent
          </th>
          <th>
            @component('components.blocks._text')
                @slot('font', 'f-module-title-1')
                @slot('tag','span')
                Fast Pass
            @endcomponent
            &nbsp;
            @component('components.atoms._info-button-trigger')
                A valid photo ID with a resident address is required for Chicago and Illinois resident admission prices. Discount only available at museum admission desks.
            @endcomponent
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($admission['ageGroups'] as $ageGroup)
        <tr>
          <th>
            @component('components.blocks._text')
                @slot('font', 'f-module-title-1')
                @slot('tag','span')
                {{ $ageGroup['title'] }}
            @endcomponent
            @if (isset($ageGroup['subtitle']))
              @component('components.blocks._text')
                  @slot('font', 'f-secondary')
                  @slot('tag','em')
                  &nbsp;({{ $ageGroup['subtitle'] }})
              @endcomponent
            @endif
          </th>
          @foreach (['generalAdmission', 'chicagoResidents', 'illonoisResidents', 'fastPass'] as $ageGroupPrice)
            <td>
              @if (strtolower($ageGroup['prices'][$ageGroupPrice]) === 'free')
                @component('components.blocks._text')
                    @slot('font','f-tag')
                    @slot('tag','span')
                    Free
                @endcomponent
              @else
                @component('components.blocks._text')
                    @slot('font', 'f-secondary')
                    @slot('tag','span')
                    {{ $ageGroup['prices'][$ageGroupPrice] }}
                @endcomponent
              @endif
            </td>
          @endforeach
        </tr>
        @endforeach
        <tr>
          <th>
            @component('components.blocks._text')
                @slot('font', 'f-module-title-1')
                @slot('tag','span')
                Children
            @endcomponent
          </th>
          <td rowspan="2" colspan="4">
            @component('components.blocks._text')
                @slot('font','f-tag')
                @slot('tag','span')
                Free
            @endcomponent
          </td>
        </tr>
        <tr>
          <th>
            @component('components.blocks._text')
                @slot('font', 'f-module-title-1')
                @slot('tag','span')
                Members
            @endcomponent
          </th>
        </tr>
      </tbody>
    </table>
  </div>

  @component('components.organisms._o-grid-listing')
      @slot('variation', 'o-grid-listing--gridlines-rowss')
      @slot('cols_medium','2')
      @slot('cols_large','2')
      @slot('cols_xlarge','2')
      @slot('cols_xxlarge','2')
      @slot('tag', 'div')

      <div class="o-blocks">
        @component('components.blocks._text')
            @slot('font','f-secondary')
            {{ $admission['text'] }}
        @endcomponent
      </div>
      <div class="o-blocks">
        <ul class="m-ticket-actions">
            <li class="m-ticket-actions__action">
                @component('components.atoms._btn')
                    @slot('variation', 'btn--full')
                    @slot('tag', 'a')
                    @slot('href', '#')
                    Buy tickets
                @endcomponent
            </li>
            <li class="m-ticket-actions__action">
                @component('components.atoms._btn')
                    @slot('variation', 'btn--secondary btn--full')
                    @slot('tag', 'a')
                    @slot('href', '#')
                    Become a member
                @endcomponent
            </li>
        </ul>
      </div>
  @endcomponent

  <div class="m-mini-promo">
    @component('components.atoms._img')
        @slot('src', $admission['cityPass']['image']['src'] ?? '')
        @slot('srcset', $admission['cityPass']['image']['srcset'] ?? '')
        @slot('sizes', $admission['cityPass']['image']['sizes'] ?? '')
        @slot('width', $admission['cityPass']['image']['width'] ?? '')
        @slot('height', $admission['cityPass']['image']['height'] ?? '')
    @endcomponent
    <div class="m-mini-promo__text">
      @component('components.atoms._title')
          @slot('font', 'f-module-title-1')
          @slot('tag','h4')
          {{ $admission['cityPass']['title'] }}
      @endcomponent
      @component('components.blocks._text')
          @slot('font', 'f-secondary')
          {{ $admission['cityPass']['text'] }}
      @endcomponent
    </div>
    @component('components.atoms._btn')
        @slot('variation', 'btn--tertiary')
        @slot('tag', 'a')
        @slot('href', $admission['cityPass']['link']['href'])
        {{ $admission['cityPass']['link']['label'] }}
    @endcomponent
  </div>

  @component('components.molecules._m-title-bar')
      @slot('id', 'directions')
      Directions
  @endcomponent

  @component('components.atoms._hr')
  @endcomponent

  @component('components.molecules._m-intro-block')
      {{ $directions['intro'] }}
  @endcomponent

  <div class="m-directions-block">
    <div class="m-directions-block__map">
      @component('components.molecules._m-media')
        @slot('item', $directions['image'])
      @endcomponent
    </div>
    <div class="m-directions-block__text o-blocks">
      @component('components.blocks._blocks')
          @slot('blocks', $directions['text'] ?? null)
      @endcomponent
    </div>
    <div class="m-directions-block__links o-blocks">
      <ul class="f-secondary">
        @foreach ($directions['links'] as $link)
        <li>
          @component('components.atoms._arrow-link')
              @slot('href', $link['href'])
              {{ $link['label'] }}
          @endcomponent
        </li>
        @endforeach
      </ul>
    </div>
  </div>

  @component('components.molecules._m-title-bar')
      @slot('links', array(array('label' => 'Explore all dining', 'href' => '#')))
      @slot('id', 'dining')
      Dining
  @endcomponent

  @component('components.atoms._hr')
  @endcomponent

  @component('components.organisms._o-grid-listing')
      @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
      @slot('cols_large','3')
      @slot('cols_xlarge','3')
      @slot('cols_xxlarge','3')
      @foreach ($dining['options'] as $diningOption)
          @component('components.molecules._m-listing----multi-links')
              @slot('variation', 'm-listing--row@small m-listing--row@medium')
              @slot('item', $diningOption)
          @endcomponent
      @endforeach
  @endcomponent

  @component('components.molecules._m-links-bar')
      @slot('variation', 'm-links-bar--title-bar-companion')
      @slot('linksPrimary', array(
        array('label' => 'Explore all dining', 'href' => '#'),
      ))
  @endcomponent

  @component('components.molecules._m-title-bar')
      @slot('links', array(
        array('label' => 'Accessibility information', 'href' => '#'),
        array('label' => 'More FAQ\'s and guidelines', 'href' => '#')
      ))
      @slot('id', 'faq')
      FAQ
  @endcomponent

  @component('components.molecules._m-link-list')
      @slot('links', $faq['questions']);
  @endcomponent

  @component('components.molecules._m-links-bar')
      @slot('variation', 'm-links-bar--title-bar-companion')
      @slot('linksPrimary', array(
        array('label' => 'Accessibility information', 'href' => '#'),
        array('label' => 'More FAQ\'s and guidelines', 'href' => '#')
      ))
  @endcomponent

  @component('components.molecules._m-title-bar')
      @slot('id', 'tours')
      Tours
  @endcomponent

  @component('components.atoms._hr')
  @endcomponent

  @component('components.organisms._o-grid-listing')
      @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
      @slot('cols_large','3')
      @slot('cols_xlarge','3')
      @slot('cols_xxlarge','3')
      @foreach ($tours as $item)
          @component('components.molecules._m-listing----multi-links')
              @slot('variation', 'm-listing--row@small m-listing--row@medium')
              @slot('item', $item)
          @endcomponent
      @endforeach
  @endcomponent

  @component('components.molecules._m-title-bar')
      @slot('id', 'familes_teens_educators')
      Families, Teens &amp; Educators
  @endcomponent

  @component('components.atoms._hr')
  @endcomponent

  @component('components.organisms._o-grid-listing')
      @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
      @slot('cols_large','3')
      @slot('cols_xlarge','3')
      @slot('cols_xxlarge','3')
      @foreach ($familiesTeensEducators as $item)
          @component('components.molecules._m-listing----multi-links')
              @slot('variation', 'm-listing--row@small m-listing--row@medium')
              @slot('item', $item)
          @endcomponent
      @endforeach
  @endcomponent

</section>

@endsection
