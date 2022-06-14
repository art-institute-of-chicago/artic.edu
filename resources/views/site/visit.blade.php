@php
use Carbon\Carbon;

$newHoursStartAt = Carbon::parse('2022-01-02T00:00:00-0600');
$showNewHours = Carbon::now()->gt($newHoursStartAt);
@endphp

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
        @slot('tag', 'span')
        @slot('imageSettings', array(
            'srcset' => array(300,600,1000,1500,3000),
            'sizes' => '100vw',
        ))
    @endcomponent

    @component('components.molecules._m-links-bar')
        @slot('overflow', true)
        @slot('variation', 'm-links-bar--nav-bar')
        @slot('isPrimaryPageNav', true)
        @slot('linksPrimary', array(
          array('label' => __('Hours'), 'href' => '#hours'),
          array('label' => __('What to Expect'), 'href' => '#expect'),
          array('label' => __('Admission'), 'href' => '#admission'),
          array('label' => __('FAQs'), 'href' => '#faqs'),
          array('label' => __('Accessibility'), 'href' => '#accessibility'),
          array('label' => __('Directions'), 'href' => '#directions'),
          array('label' => __('Ways to Explore'), 'href' => '#explore'),
        ))
    @endcomponent

    @component('components.molecules._m-header-block')
        {{ $title }}
    @endcomponent

    @component('components.molecules._m-title-bar')
        @slot('id', 'hours')
        @lang('Hours')
    @endcomponent

    @if ($hours['intro'])
        @component('components.atoms._hr')
        @endcomponent

        @component('components.molecules._m-intro-block')
            @slot('itemprop','description')
            {!! SmartyPants::defaultTransform($hours['intro']) !!}
        @endcomponent
    @endif

    @if (!$hours['hide_hours'])
        @component('components.organisms._o-grid-listing')
            @slot('cols_large','2')
            @slot('cols_xlarge','2')
            @slot('tag', 'div')
            <div class="o-blocks u-hide@medium-">
                @component('components.molecules._m-media')
                    @slot('item', $hours['media'])
                    @slot('imageSettings', array(
                        'fit' => 'crop',
                        'ratio' => '16:9',
                        'srcset' => array(300,600,800,1200,1600,3000,4500),
                        'sizes' => ImageHelpers::aic_imageSizes(array(
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
                <div class="m-table m-table--minimal">
                    <table>
                        <thead>
                            <tr>
                                <th> </th>
                                <th aria-labelledby="h-member-hours"><span class="f-module-title-1" id="h-member-hours">Members</span></th>
                                <th aria-labelledby="h-public-hours"><span class="f-module-title-1" id="h-public-hours">Public</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($hour))
                                @foreach ($hour->present()->getHoursTableForVisit() as $item)
                                    <tr>
                                        <th>
                                            <span class="f-module-title-1">{{ $item['days'] }}</span>
                                        </th>
                                        <td>
                                            <span class="f-secondary">{{ $item['member_hours'] }}</span>
                                        </td>
                                        <td>
                                            <span class="f-secondary">{{ $item['public_hours'] }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th>
                                        <span class="f-module-title-1">Monday</span>
                                    </th>
                                    <td>
                                        <span class="f-secondary">10&ndash;11 a.m.</span>
                                    </td>
                                    <td>
                                        <span class="f-secondary">11 a.m.&ndash;5 p.m.</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <span class="f-module-title-1">Tuesday&ndash;<div class="u-hide@small+"></div>Wednesday</span>
                                    </th>
                                    <td>
                                        <span class="f-secondary">Closed</span>
                                    </td>
                                    <td>
                                        <span class="f-secondary">Closed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        <span class="f-module-title-1">Thursday&ndash;<div class="u-hide@small+"></div>Sunday</span>
                                    </th>
                                    <td>
                                        <span class="f-secondary">10&ndash;11 a.m.</span>
                                    </td>
                                    <td>
                                        <span class="f-secondary">11 a.m.&ndash;5 p.m.</span>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @component('components.blocks._text')
                    @slot('font','f-body')
                    {!! SmartyPants::defaultTransform($hours['primary']) !!}
                @endcomponent
                @component('components.blocks._text')
                    @slot('tag','span')
                    @slot('font','f-secondary')
                    {!! SmartyPants::defaultTransform($hours['secondary']) !!}
                @endcomponent
            </div>
        @endcomponent
    @endif

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
                    @slot('gtmAttributes', 'data-gtm-event="'.StringHelpers::getUtf8Slug($section['title'] ?? 'unknown title').'" data-gtm-event-category="nav-link"')
                    {!! SmartyPants::defaultTransform($section['title']) !!}
                @endcomponent
            @endcomponent
          </div>
          <div class="o-blocks">
            {!! SmartyPants::defaultTransform(preg_replace('/<p>/i', '<p class="f-secondary">', $section['copy'])); !!}
          </div>
      @endcomponent

    @endforeach

    <hr>

    @if (isset($page->visit_cta_module_header) && isset($page->visit_cta_module_body) && isset($page->visit_cta_module_button_text) && isset($page->visit_cta_module_action_url))
        @component('components.molecules._m-cta-banner')
            @slot('href', $page->visit_cta_module_action_url)
            @slot('header', $page->visit_cta_module_header)
            @slot('body', $page->visit_cta_module_body)
            @slot('button_text', $page->visit_cta_module_button_text)
            @slot('gtmAttributes', 'data-gtm-event="'. $page->visit_cta_module_button_text . '" data-gtm-event-category="internal-ad-click"')
        @endcomponent
    @endif

    @component('components.molecules._m-title-bar')
        @slot('links', array(
            array('label' => $whatToExpect['more_text'], 'href' => $whatToExpect['more_link'], 'gtmAttributes' => 'data-gtm-event="What to Expect" data-gtm-event-category="nav-link"')
        ))
        @slot('id', 'expect')
        @lang('What to Expect')
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_small','2')
        @slot('cols_medium','2')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @slot('ariaLabel', 'h-familes_teens_educators')
        @foreach ($whatToExpect['items'] as $item)
            @component('components.molecules._m-listing----icon')
                @slot('variation', 'm-listing--row@small m-listing--row@medium')
                @slot('item', $item)
            @endcomponent
        @endforeach
    @endcomponent

    @if (!empty($page->visit_capacity_text))
        <hr/>

        <div class="o-visit-capacity">
            <div class="o-visit-capacity__graph">
                @if ($showNewHours)
                    <svg role="img" aria-label="{{ $page->visit_capacity_alt }}" class="icon--visit-capacity-2">
                        <use xlink:href="#icon--visit-capacity-2"></use>
                    </svg>
                @else
                    <svg role="img" aria-label="{{ $page->visit_capacity_alt }}" class="icon--visit-capacity">
                        <use xlink:href="#icon--visit-capacity"></use>
                    </svg>
                @endif
            </div>
            <div class="o-visit-capacity__text">
                @if (!empty($page->visit_capacity_heading))
                    <h2 class="f-list-3">{{ $page->visit_capacity_heading }}</h2>
                @endif
                {!! $page->visit_capacity_text !!}
             </div>
            <div class="o-visit-capacity__actions">
                @if (!empty($page->visit_capacity_btn_text_1) && !empty($page->visit_capacity_btn_url_1))
                    @component('components.atoms._btn')
                        @slot('variation', 'btn--secondary btn--full')
                        @slot('tag', 'a')
                        @slot('href', $page->visit_capacity_btn_url_1)
                        @slot('gtmAttributes', 'data-gtm-event="capacity-btn-1" data-gtm-event-category="nav-cta-button"')
                        {!! SmartyPants::defaultTransform($page->visit_capacity_btn_text_1) !!}
                    @endcomponent
                @endif

                @if (!empty($page->visit_capacity_btn_text_2) && !empty($page->visit_capacity_btn_url_2))
                    @component('components.atoms._btn')
                        @slot('variation', 'btn--secondary btn--full')
                        @slot('tag', 'a')
                        @slot('href', $page->visit_capacity_btn_url_2)
                        @slot('gtmAttributes', 'data-gtm-event="capacity-btn-2" data-gtm-event-category="nav-cta-button"')
                        {!! SmartyPants::defaultTransform($page->visit_capacity_btn_text_2) !!}
                    @endcomponent
                @endif
            </div>
        </div>
    @endif

    <div class="m-table">
      <table>
        <caption>
            @component('components.molecules._m-title-bar')
                @slot('id', 'admission')
                @lang('Admission')
            @endcomponent
        </caption>
        <thead>
          <tr>
            <th>&nbsp;</th>
            @foreach ($admission['titles'] as $categoryId => $categoryData)
              <th aria-labelledby="h-{{ $categoryData['id'] }}">
                @component('components.blocks._text')
                    @slot('font', 'f-module-title-1')
                    @slot('tag','span')
                    @slot('id', 'h-' .$categoryData['id'])
                    {!! SmartyPants::defaultTransform($categoryData['title']) !!}
                @endcomponent
                @if (isset($categoryData['tooltip']))
                  &nbsp;
                  @component('components.atoms._info-button')
                      @slot('id', $categoryData['id'])
                      {!! SmartyPants::defaultTransform($categoryData['tooltip']) !!}
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
                          {!! SmartyPants::defaultTransform($ageData['title']) !!}
                      @endcomponent
                      @if (isset($ageData['subtitle']))
                        @component('components.blocks._text')
                            @slot('font', 'f-secondary')
                            @slot('tag','em')
                            &nbsp;({!! SmartyPants::defaultTransform($ageData['subtitle']) !!})
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
                </tr>
            @endif
          @endforeach
          <tr>
            <th>
              @component('components.blocks._text')
                  @slot('font', 'f-module-title-1')
                  @slot('tag','span')
                  @lang('Children')
              @endcomponent
            </th>
            <td rowspan="2" colspan="4" aria-label="Children and members are free">
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
          {!! SmartyPants::defaultTransform($admission['text']) !!}
        </div>
        <div class="o-blocks">
          <h3 class="sr-only" id="h-ticket-actions">Buy ticket options</h3>
          <ul class="m-ticket-actions o-blocks__block" aria-labelledby="h-ticket-actions">
              <li class="m-ticket-actions__action">
                  @component('components.atoms._btn')
                      @slot('variation', 'btn--full')
                      @slot('tag', 'a')
                      @slot('href', $admission['buy_tickets']['link'])
                      @slot('gtmAttributes', 'data-gtm-event="'. StringHelpers::getUtf8Slug($admission['buy_tickets']['label']) .'" data-gtm-event-category="nav-cta-button"')
                      {!! SmartyPants::defaultTransform($admission['buy_tickets']['label']) !!}
                  @endcomponent
              </li>
              <li class="m-ticket-actions__action">
                  @component('components.atoms._btn')
                      @slot('variation', 'btn--secondary btn--full')
                      @slot('tag', 'a')
                      @slot('href', $admission['become_member']['link'])
                      @slot('gtmAttributes', 'data-gtm-event="become-a-member" data-gtm-event-category="nav-cta-button"')
                      {!! SmartyPants::defaultTransform($admission['become_member']['label']) !!}
                  @endcomponent
              </li>
          </ul>
        </div>
    @endcomponent

    @if (isset($admission['cityPass']['title']))
        <div class="m-mini-promo">
            @component('components.atoms._img')
                @slot('image', $admission['cityPass']['image'])
                @slot('settings', array(
                    'fit' => 'crop',
                    'ratio' => '9:5',
                    'srcset' => array(200,400,600),
                    'sizes' => ImageHelpers::aic_imageSizes(array(
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
                    @slot('tag','h3')
                    {!! SmartyPants::defaultTransform($admission['cityPass']['title']) !!}
                @endcomponent
                @component('components.blocks._text')
                    @slot('font', 'f-secondary')
                    {!! SmartyPants::defaultTransform($admission['cityPass']['text']) !!}
                @endcomponent
            </div>
            @component('components.atoms._btn')
                @slot('variation', 'btn--tertiary')
                @slot('tag', 'a')
                @slot('href', $admission['cityPass']['link']['href'])
                @slot('gtmAttributes', 'data-gtm-event="' . StringHelpers::getUtf8Slug( $admission['cityPass']['link']['label']) . ' " data-gtm-event-action="' . $seo->title . '"  data-gtm-event-category="nav-cta-button"')
                {!! SmartyPants::defaultTransform($admission['cityPass']['link']['label']) !!}
            @endcomponent
        </div>
    @endif

    @component('components.molecules._m-title-bar')
        @slot('links', array(
          array('label' => __('More FAQs'), 'href' => $faq['more_link'], 'gtmAttributes' => 'data-gtm-event="faq" data-gtm-event-category="nav-link"')
        ))
        @slot('id', 'faqs')
        @lang('FAQs')
    @endcomponent

    @component('components.molecules._m-link-list')
        @slot('screenreaderTitle', 'Example questions')
        @slot('links', $faq['questions'])
    @endcomponent

    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--title-bar-companion')
        @slot('linksPrimary', array(
        array('label' => __('Accessibility information'), 'href' => $faq['accesibility_link'], 'variation' => 'btn--secondary'),
        array('label' => __('More FAQs and guidelines'), 'href' => $faq['more_link'], 'variation' => 'btn--secondary', 'gtmAttributes' => 'data-gtm-event="faq" data-gtm-event-category="nav-link"')
        ))
    @endcomponent

    @component('components.molecules._m-title-bar')
        @slot('id', 'accessibility')
        @lang('Accessibility')
    @endcomponent

    <div class="m-mini-promo">
        @component('components.atoms._img')
            @slot('image', $accessibility['image'])
            @slot('settings', array(
                'fit' => 'crop',
                'ratio' => '9:5',
                'srcset' => array(200,400,600),
                'sizes' => ImageHelpers::aic_imageSizes(array(
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
                @slot('tag','h3')
            @endcomponent
            @component('components.blocks._text')
                @slot('font', 'f-secondary')
                {!! SmartyPants::defaultTransform($accessibility['text']) !!}
          @endcomponent
        </div>
        @component('components.atoms._btn')
            @slot('variation', 'btn--secondary')
            @slot('tag', 'a')
            @slot('href', $accessibility['link_url'])
            @slot('gtmAttributes', 'data-gtm-event="' . strip_tags($accessibility['link_text']) . ' " data-gtm-event-category="nav-cta-button"')
            {!! SmartyPants::defaultTransform($accessibility['link_text']) !!}
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
        {!! SmartyPants::defaultTransform($directions['intro']) !!}
    @endcomponent

    <div class="m-directions-block">
      <div class="m-directions-block__map">
        <figure class="m-media">
            <a itemprop="hasMap" href="{{ $directions['links'][0]['href'] ?? '#' }}" class="m-media__img ratio-img ratio-img--16:9" aria-label="Directions to the Art Institute of Chicago">
                @include('partials._map')
            </a>
        </figure>
      </div>
      <div class="m-directions-block__text o-blocks">
        @foreach ($directions['locations'] as $location)
          <div class="f-secondary" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
            <h3>{!! SmartyPants::defaultTransform($location['name']) !!}</h3>
            <p>
              <span itemprop="streetAddress">{!! $location['street'] !!} {!! $location['addres'] !!}</span><br />
              <span itemprop="addressLocality">{!! $location['city'] !!}</span> <span itemprop="addressRegion">{!! $location['state'] !!}</span> <span itemprop="postalCode">{!! $location['zip'] !!}</span>
            </p>
          </div>
        @endforeach
      </div>
      <div class="m-directions-block__links o-blocks">
        <span class="f-secondary">
          @component('components.atoms._arrow-link')
              @slot('href', $directions['link']['href'])
              @slot('itemprop','hasMap')
              {{ $directions['link']['label'] }}
          @endcomponent

          @component('components.atoms._arrow-link')
              @slot('href', $directions['accessibility_link']['href'])
              @slot('itemprop','hasMap')
              {{ $directions['accessibility_link']['label'] }}
          @endcomponent
        </span>
      </div>
    </div>

    @component('components.molecules._m-title-bar')
        @slot('id', 'explore')
        @lang('Ways to Explore')
    @endcomponent

    @component('components.atoms._hr')
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-cols o-grid-listing--gridlines-top')
        @slot('cols_large','3')
        @slot('cols_xlarge','3')
        @slot('ariaLabel', 'h-familes_teens_educators')
        @foreach ($explore as $item)
            @component('components.molecules._m-listing----multi-links')
                @slot('variation', 'm-listing--row@small m-listing--row@medium')
                @slot('item', $item)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,400,600),
                    'sizes' => ImageHelpers::aic_imageSizes(array(
                        'xsmall' => '58',
                        'small' => '23',
                        'medium' => '22',
                        'large' => '18',
                        'xlarge' => '18',
                    )),
                ))
                @slot('gtmAttributes', 'data-gtm-event="explore-on-your-own" data-gtm-event-category="nav-link"')
            @endcomponent
        @endforeach
    @endcomponent

  </section>

@endsection
