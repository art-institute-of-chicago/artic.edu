@php
    $newHoursStartAt = Carbon\Carbon::parse('2022-01-02T00:00:00-0600');
    $showNewHours = Carbon\Carbon::now()->gt($newHoursStartAt);
@endphp

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
                <div class="m-table m-table--minimal m-table--hide-columns">
                    <table>
                        <thead>
                            <tr>
                                <td></td>
                                <th
                                    aria-labelledby="h-member-hours"
                                    scope="col"
                                >
                                    <span class="f-module-title-1" id="h-member-hours">Members</span>
                                </th>
                                <th
                                    aria-labelledby="h-public-hours"
                                    scole="col"
                                >
                                    <span class="f-module-title-1" id="h-public-hours">Public</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($hour))
                                @foreach ($hour->present()->getHoursTableForVisit() as $hour)
                                    <tr>
                                        <th scope="row">
                                            <span class="f-module-title-1">{{ $hour['days'] }}</span>
                                        </th>
                                        <td>
                                            <span class="f-secondary">{{ $hour['member_hours'] }}</span>
                                        </td>
                                        <td>
                                            <span class="f-secondary">{{ $hour['public_hours'] }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th scope="row">
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
                                    <th scope="row">
                                        <span class="f-module-title-1">
                                            Tuesday&ndash;<div class="u-hide@small+"></div>Wednesday
                                        </span>
                                    </th>
                                    <td>
                                        <span class="f-secondary">Closed</span>
                                    </td>
                                    <td>
                                        <span class="f-secondary">Closed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">
                                        <span class="f-module-title-1">
                                            Thursday&ndash;<div class="u-hide@small+"></div>Sunday
                                        </span>
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
