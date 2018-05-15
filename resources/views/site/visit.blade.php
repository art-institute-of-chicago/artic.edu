@extends('layouts.app')

@section('content')

  <section class="o-visit">

    @component('components.molecules._m-media')
        @slot('item', $headerMedia)
        @slot('imageSettings', array(
            'srcset' => array(300,600,1000,1500,3000),
            'sizes' => '100vw',
        ))
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
        @slot('tag', 'div')

        <div class="o-blocks">
          @component('components.molecules._m-media')
            @slot('item', $hours['media'])
            @slot('imageSettings', array(
                'fit' => 'crop',
                'ratio' => '16:9',
                'srcset' => array(300,600,800,1200,1600,3000,4500),
                'sizes' => aic_imageSizes(array(
                      'xsmall' => '58',
                      'small' => '58',
                      'medium' => '38',
                      'large' => '28',
                      'xlarge' => '28',
                )),
            ))
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
          @slot('variation', 'o-grid-listing--gridlines-rows o-grid-listing--info-block')
          @slot('cols_small','2')
          @slot('cols_medium','2')
          @slot('cols_large','2')
          @slot('cols_xlarge','2')
          @slot('tag', 'div')
          <div class="o-blocks">
            @component('components.blocks._title')
                @slot('font','f-list-3')
                @slot('tag','h3')
                @component('components.atoms._arrow-link')
                    @slot('font','f-null')
                    @slot('href', $section['external_link'])
                    {{ $section['title'] }}
                @endcomponent
            @endcomponent
          </div>
          <div class="o-blocks">
            @component('components.blocks._text')
                @slot('font','f-secondary')
                {!! $section['copy'] !!}
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
            @foreach ($admission['titles'] as $category)
              <th>
                @component('components.blocks._text')
                    @slot('font', 'f-module-title-1')
                    @slot('tag','span')
                    {{ $category['title'] }}
                @endcomponent
                @if (isset($category['tooltip']))
                  &nbsp;
                  @component('components.atoms._info-button-trigger')
                      {{ $category['tooltip'] }}
                  @endcomponent
                @endif
              </th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($admission['ageGroups'] as $ageGroup)
            @if (strtolower($ageGroup['title']) !== 'children' and strtolower($ageGroup['title']) !== 'members')
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
                @foreach ($admission['keys'] as $ageGroupPrice)
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
                          ${{ $ageGroup['prices'][$ageGroupPrice] }}
                      @endcomponent
                    @endif
                  </td>
                @endforeach
            @endif
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
        @slot('variation', 'o-grid-listing--info-block')
        @slot('cols_medium','2')
        @slot('cols_large','2')
        @slot('cols_xlarge','2')
        @slot('tag', 'div')

        <div class="o-blocks">
          @component('components.blocks._text')
              @slot('font','f-secondary')
              {{ $admission['text'] }}
          @endcomponent
        </div>
        <div class="o-blocks">
          <ul class="m-ticket-actions o-blocks__block">
              <li class="m-ticket-actions__action">
                  @component('components.atoms._btn')
                      @slot('variation', 'btn--full')
                      @slot('tag', 'a')
                      @slot('href', $admission['buy_tickets']['link'])
                      {{ $admission['buy_tickets']['label'] }}
                  @endcomponent
              </li>
              <li class="m-ticket-actions__action">
                  @component('components.atoms._btn')
                      @slot('variation', 'btn--secondary btn--full')
                      @slot('tag', 'a')
                      @slot('href', $admission['become_member']['link'])
                      {{ $admission['become_member']['label'] }}
                  @endcomponent
              </li>
          </ul>
        </div>
    @endcomponent

    <div class="m-mini-promo">
      @component('components.atoms._img')
          @slot('image', $admission['cityPass']['image'])
          @slot('settings', array(
              'fit' => 'crop',
              'ratio' => '1:1',
              'srcset' => array(200,400,600),
              'sizes' => aic_imageSizes(array(
                    'xsmall' => '23',
                    'small' => '13',
                    'medium' => '13',
                    'large' => '13',
                    'xlarge' => '13',
              )),
          ))
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
        <figure class="m-media">
            <a href="{{ $directions['links'][0]['href'] ?? '#' }}" class="m-media__img">
                @include('partials._map')
            </a>
        </figure>
      </div>
      <div class="m-directions-block__text o-blocks">
        @foreach ($directions['locations'] as $location)
          <p class="f-secondary">
            {!! $location['name'] !!}<br />
            {!! $location['street'] !!} {!! $location['addres'] !!}<br />
            {!! $location['city'] !!} {!! $location['state'] !!} {!! $location['zip'] !!}
          </p>
        @endforeach
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
        @foreach ($dining as $item)
            @component('components.molecules._m-listing----multi-links')
                @slot('variation', 'm-listing--row@small m-listing--row@medium')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '58',
                          'small' => '23',
                          'medium' => '22',
                          'large' => '18',
                          'xlarge' => '18',
                    )),
                ))
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
          array('label' => 'Accessibility information', 'href' => $faq['accesibility_link']),
          array('label' => 'More FAQ\'s and guidelines', 'href' => $faq['more_link'])
        ))
        @slot('id', 'faq')
        FAQ
    @endcomponent

    @component('components.molecules._m-link-list')
        @slot('links', $faq['questions'])
    @endcomponent

    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--title-bar-companion')
        @slot('linksPrimary', array(
          array('label' => 'Accessibility information', 'href' => $faq['accesibility_link']),
          array('label' => 'More FAQ\'s and guidelines', 'href' => $faq['more_link'])
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
        @foreach ($tours as $item)
            @component('components.molecules._m-listing----multi-links')
                @slot('variation', 'm-listing--row@small m-listing--row@medium')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '58',
                          'small' => '23',
                          'medium' => '22',
                          'large' => '18',
                          'xlarge' => '18',
                    )),
                ))
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
        @foreach ($families as $item)
            @component('components.molecules._m-listing----multi-links')
                @slot('variation', 'm-listing--row@small m-listing--row@medium')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => aic_imageSizes(array(
                          'xsmall' => '58',
                          'small' => '23',
                          'medium' => '22',
                          'large' => '18',
                          'xlarge' => '18',
                    )),
                ))
            @endcomponent
        @endforeach
    @endcomponent

  </section>

@endsection
