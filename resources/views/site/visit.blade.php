@extends('layouts.app')

@section('content')

  <section class="o-visit" itemscope itemtype="http://schema.org/TouristAttraction">
    <link itemprop="additionalType" href="http://schema.org/Museum" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LandmarksOrHistoricalBuildings" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LocalBusiness" aria-hidden="true"/>
    @component('site.shared._schemaItemProps')
      @slot('itemprops',$itemprops ?? null)
    @endcomponent

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
        @slot('navType', 'primary')
        @slot('linksPrimary', array(
          array('label' => __('Hours'), 'href' => '#hours'),
          array('label' => __('Admission'), 'href' => '#admission'),
          array('label' => __('Directions'), 'href' => '#directions'),
          array('label' => __('Dining'), 'href' => '#dining'),
          array('label' => __('FAQs'), 'href' => '#faqs'),
          array('label' => __('Tours'), 'href' => '#tours'),
          array('label' => __('Families, Teens, and Educators'), 'href' => '#familes_teens_educators'),
        ))
         @slot('secondaryHtml')
          <li class="m-links-bar__item  m-links-bar__item--primary">
              @component('components.atoms._dropdown')
                @slot('prompt', 'Select language')
                @slot('ariaTitle', 'Select language')
                @slot('variation','dropdown--filter f-link')
                @slot('font', null)
                @slot('options', array(
                  array('active' => request('lang') === 'en', 'href' => currentUrlWithQuery([]), 'label' => 'English'),
                  array('active' => request('lang') === 'es', 'href' => currentUrlWithQuery(['lang' => 'es']), 'label' => 'Español'),
                  array('active' => request('lang') === 'fr', 'href' => currentUrlWithQuery(['lang' => 'fr']), 'label' => 'Français'),
                  array('active' => request('lang') === 'de', 'href' => currentUrlWithQuery(['lang' => 'de']), 'label' => 'Deutsch'),
                  array('active' => request('lang') === 'zh', 'href' => currentUrlWithQuery(['lang' => 'zh']), 'label' => '中文'),
                  array('active' => request('lang') === 'ja', 'href' => currentUrlWithQuery(['lang' => 'ja']), 'label' => '日本語'),
                  array('active' => request('lang') === 'pt', 'href' => currentUrlWithQuery(['lang' => 'pt']), 'label' => 'Português'),
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
        @lang('Hours')
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

    @foreach($hours['sections'] as $section)

      @component('components.organisms._o-grid-listing')
          @slot('variation', 'o-grid-listing--gridlines-rows o-grid-listing--info-block')
          @slot('cols_small','2')
          @slot('cols_medium','2')
          @slot('cols_large','2')
          @slot('cols_xlarge','2')
          @slot('tag', 'div')
          <div class="o-blocks">
            @component('components.atoms._title')
                @slot('font','f-list-3')
                @slot('tag','h3')
                @component('components.atoms._arrow-link')
                    @slot('font','f-null')
                    @slot('href', $section['external_link'])
                    @slot('gtmAttributes', 'data-gtm-event="'.getUtf8Slug($section['title'] ?? 'unknown title').'" data-gtm-event-action="Visit" data-gtm-event-category="nav-link"')
                    {{ $section['title'] }}
                @endcomponent
            @endcomponent
          </div>
          <div class="o-blocks">
            {!! preg_replace('/<p>/i', '<p class="f-secondary">', $section['copy']); !!}
          </div>
      @endcomponent

    @endforeach

    @component('components.molecules._m-title-bar')
        @slot('id', 'admission')
        @lang('Admission')
    @endcomponent

    <div class="m-table">
      <table>
        <thead>
          <tr>
            <td>&nbsp;</td>
            @foreach ($admission['titles'] as $categoryId => $categoryData)
              <th aria-labelledby="{{ $categoryData['id'] }}">
                @component('components.blocks._text')
                    @slot('font', 'f-module-title-1')
                    @slot('tag','span')
                    @slot('id', $categoryData['id'])
                    {{ $categoryData['title'] }}
                @endcomponent
                @if (isset($categoryData['tooltip']))
                  &nbsp;
                  @component('components.atoms._info-button-trigger')
                      @slot('describedBy', $categoryData['id'])
                      {{ $categoryData['tooltip'] }}
                  @endcomponent
                @endif
              </th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($admission['prices'] as $ageId => $ageData)
            @if (strtolower($ageData['title_en']) !== 'children' and strtolower($ageData['title_en']) !== 'members')
                <tr>
                    <th>
                      @component('components.blocks._text')
                          @slot('font', 'f-module-title-1')
                          @slot('tag','span')
                          {{ $ageData['title'] }}
                      @endcomponent
                      @if (isset($ageData['subtitle']))
                        @component('components.blocks._text')
                            @slot('font', 'f-secondary')
                            @slot('tag','em')
                            &nbsp;({{ $ageData['subtitle'] }})
                        @endcomponent
                      @endif
                    </th>

                @foreach ($admission['titles'] as $categoryId => $data)
                  <td>
                    @if (strtolower($ageData['title']) === 'free')
                      @component('components.blocks._text')
                          @slot('font','f-tag')
                          @slot('tag','span')
                          @lang('Free')
                      @endcomponent
                    @else
                      @component('components.blocks._text')
                          @slot('font', 'f-secondary')
                          @slot('tag','span')
                          @if($ageData[$categoryId] == 0)
                          @lang('Free')
                          @else
                          ${{ $ageData[$categoryId] }}
                          @endif
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
                  @lang('Children')
              @endcomponent
            </th>
            <td rowspan="2" colspan="4">
              @component('components.blocks._text')
                  @slot('font','f-tag')
                  @slot('tag','span')
                  @lang('Free')
              @endcomponent
            </td>
          </tr>
          <tr>
            <th>
              @component('components.blocks._text')
                  @slot('font', 'f-module-title-1')
                  @slot('tag','span')
                  @lang('Members')
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
          {!! $admission['text'] !!}
        </div>
        <div class="o-blocks">
          <h3 class="sr-only" id="h-ticket-actions">Buy ticket options</h3>
          <ul class="m-ticket-actions o-blocks__block" aria-labelledby="h-ticket-actions">
              <li class="m-ticket-actions__action">
                  @component('components.atoms._btn')
                      @slot('variation', 'btn--full')
                      @slot('tag', 'a')
                      @slot('href', $admission['buy_tickets']['link'])
                      @slot('gtmAttributes', 'data-gtm-event="buy-tickets" data-gtm-event-action="Visit" data-gtm-event-category="nav-cta-button"')
                      {{ $admission['buy_tickets']['label'] }}
                  @endcomponent
              </li>
              <li class="m-ticket-actions__action">
                  @component('components.atoms._btn')
                      @slot('variation', 'btn--secondary btn--full')
                      @slot('tag', 'a')
                      @slot('href', $admission['become_member']['link'])
                      @slot('gtmAttributes', 'data-gtm-event="become-member" data-gtm-event-action="Visit" data-gtm-event-category="nav-cta-button"')
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
              'ratio' => '9:5',
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
          @slot('gtmAttributes', 'data-gtm-event="buy-city-pass" data-gtm-event-action="Visit"  data-gtm-event-category="nav-cta-button"')
          {{ $admission['cityPass']['link']['label'] }}
      @endcomponent
    </div>

    @component('components.molecules._m-title-bar')
        @slot('id', 'directions')
        @lang('Directions')
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    @component('components.molecules._m-intro-block')
        @slot('itemprop','description')
        {{ $directions['intro'] }}
    @endcomponent

    <div class="m-directions-block">
      <div class="m-directions-block__map">
        <figure class="m-media">
            <a itemprop="hasMap" href="{{ $directions['links'][0]['href'] ?? '#' }}" class="m-media__img ratio-img ratio-img--16:9" aria-label="click to get directions to the Art Institute of Chicago">
                @include('partials._map')
            </a>
        </figure>
      </div>
      <div class="m-directions-block__text o-blocks">
        @foreach ($directions['locations'] as $location)
          <p class="f-secondary" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            {!! $location['name'] !!}<br />
            <span itemprop="streetAddress">{!! $location['street'] !!} {!! $location['addres'] !!}</span><br />
            <span itemprop="addressLocality">{!! $location['city'] !!}</span> <span itemprop="addressRegion">{!! $location['state'] !!}</span> <span itemprop="postalCode">{!! $location['zip'] !!}
          </p>
        @endforeach
      </div>
      <div class="m-directions-block__links o-blocks">
        <h3 class="sr-only" id="h-map-options">Map options</h3>
        <ul class="f-secondary" aria-labelledby="h-map-options">
          @foreach ($directions['links'] as $link)
          <li>
            @component('components.atoms._arrow-link')
                @slot('href', $link['href'])
                @slot('itemprop','hasMap')
                {{ $link['label'] }}
            @endcomponent
          </li>
          @endforeach
        </ul>
      </div>
    </div>

    @component('components.molecules._m-title-bar')
        @slot('links', [
            [
                'label' => __('Explore all dining'),
                'href'  => $page->visit_dining_link,
                'gtmAttributes' => 'data-gtm-event="dining" data-gtm-event-action="Visit"  data-gtm-event-category="nav-link"'
            ]
        ]
        )
        @slot('id', 'dining')
        @lang('Dining')
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
          array('label' => __('Explore all dining'), 'href' => $page->visit_dining_link, 'variation' => 'btn--secondary', 'gtmAttributes' => 'data-gtm-event="dining" data-gtm-event-action="Visit"  data-gtm-event-category="nav-link"'),
        ))
    @endcomponent

    @component('components.molecules._m-title-bar')
        @slot('links', array(
          array('label' => __('Accessibility information'), 'href' => $faq['accesibility_link']),
          array('label' => __('More FAQs and guidelines'), 'href' => $faq['more_link'], 'gtmAttributes' => 'data-gtm-event="faq" data-gtm-event-action="Visit" data-gtm-event-category="nav-link"')
        ))
        @slot('id', 'faqs')
        @lang('FAQs')
    @endcomponent

    @component('components.molecules._m-link-list')
        @slot('links', $faq['questions'])
    @endcomponent

    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--title-bar-companion')
        @slot('linksPrimary', array(
          array('label' => __('Accessibility information'), 'href' => $faq['accesibility_link'], 'variation' => 'btn--secondary'),
          array('label' => __('More FAQs and guidelines'), 'href' => $faq['more_link'], 'variation' => 'btn--secondary', 'gtmAttributes' => 'data-gtm-event="faq" data-gtm-event-action="Visit" data-gtm-event-category="nav-link"')
        ))
    @endcomponent

    @component('components.molecules._m-title-bar')
        @slot('id', 'tours')
        @lang('Tours')
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
                @slot('gtmAttributes', 'data-gtm-event="tours" data-gtm-event-action="Visit" data-gtm-event-category="nav-link"')
            @endcomponent
        @endforeach
    @endcomponent

    @component('components.molecules._m-title-bar')
        @slot('id', 'familes_teens_educators')
        @lang('Families, Teens, and Educators')
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
                @slot('gtmAttributes', 'data-gtm-event="special-audiences" data-gtm-event-action="Visit"  data-gtm-event-category="nav-link"')
            @endcomponent
        @endforeach
    @endcomponent

  </section>

@endsection
