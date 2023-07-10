@php
    $newHoursStartAt = Carbon\Carbon::parse('2022-01-02T00:00:00-0600');
    $showNewHours = Carbon\Carbon::now()->gt($newHoursStartAt);
@endphp

<section class="visit" itemscope itemtype="http://schema.org/TouristAttraction">
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
        @slot('variation', 'm-visit-header')
    @endcomponent

    @if (!empty($hour))
    <div class="o-hours f-secondary">
        <div class="o-hours__clock">
            <svg class="icon--clock" aria-hidden="true">
                <use xlink:href="#icon--clock"></use>
            </svg>
        </div>
        <div class="o-hours__text">
            <span class="o-hours__status o-hours__status--mobile">{{
                $hour->present()->getStatusHeader(null, true)
            }}</span>
            <span class="o-hours__status o-hours__status--desktop">{{
                $hour->present()->getStatusHeader()
            }}</span>
            @if ($hoursHeader = $hour->present()->getHoursHeader())
                <span class="o-hours__hours">{{ $hoursHeader }}</span>
            @endif
        </div>
    </div>
    @endif
    <h2 class="f-headline">VISIT</h2>
        <div class="menu-links">
            @if(!empty($menuItems))
                <ul>
                    @foreach($menuItems as $item)
                            <li class="m-links-bar__item"><a class="m-links-bar__item-trigger f-link" href={{ $item->link }}>{{ $item->label }}</a></li>
                    @endforeach
                </ul>
            @endif
                <a href={{ $visit_nav_buy_tix_link }} class="btn f-buttons">{{ $visit_nav_buy_tix_label }}</a>
        </div>

    <div class="info-grid">
        <div class="row">
            <div class="col">
                <h3 id="hours" class="title f-module-title-2">Hours</h3>
                <hr>
                <span class="f-secondary">{!! $visit_members_intro !!}</span>
                <table class="visit-hours">
                    <caption class="s-hidden">Hours the museum is open each day</caption>
                    <tr class="s-hidden">
                        <th scope="row">
                            <td>Days</td>
                            <td>Hours</td>
                        </th>
                    </tr>
                    @if (!empty($hour))
                        @foreach ($hour->present()->getHoursTableForHeader() as $item)
                            @php
                                $hourClass = '';
                                if ($item['hours'] === 'Closed') {
                                    $hourClass = 'closed';
                                }
                            @endphp
                            <tr>
                                <th scope="row">
                                    <span class="f-module-title-1 {{$hourClass}}">{{ $item['days'] }}</span>
                                </th>
                                <td>
                                    <span class="f-secondary {{$hourClass}}">{{ $item['hours'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
                <span class="f-secondary">{!! $visit_hours_intro !!}</span>
            </div>
            <div class="col">
                <h3 id="location" class="title f-module-title-2">Location</h3>
                <hr>
                <div class="visit-location">
                    <div>
                        @component('components.atoms._img')
                            @slot('image', $visit_map)
                            @slot('settings', $imageSettings ?? '')
                        @endcomponent
                    </div>
                    <div>
                        @foreach($locations as $location)
                            <div>
                                <span class="f-module-title-1">{{ $location->name }}</span>
                                <span class="f-secondary">{{ $location->street }} {{ $location->address }} {{ $location->state }} {{ $location->zip }}</span>
                                <a class="f-link" href="/visit/directions-and-parking">Get directions&nbsp;<svg aria-hidden="true" class="icon--new-window"><use xlink:href="#icon--new-window" /></svg></a>
                            </div>
                        @endforeach
                        @if($visit_parking_link && $visit_parking_label)
                            <a href="{{ $visit_parking_link }}" class="btn btn--secondary f-buttons parking_label">{{ $visit_parking_label }}</a>
                        @endif
                    </div>
                    @if($visit_parking_link && $visit_parking_label)
                        <a href="{{ $visit_parking_link }}" class="btn btn--secondary f-buttons parking_label">{{ $visit_parking_label }}</a>
                    @endif
                </div>
            </div>
        </div>
        <h3 id="admission" class="title f-module-title-2">Admission</h3>
        <hr>
        <div class="row">
            <div class="col">
                <div class="visit-fee">
                    <table class="visit-fee-category">
                        <caption class="s-hidden">Types of admissions to visit the museum</caption>
                        <tr class="s-hidden">
                            <th class="s-hidden">
                                <td class="s-hidden">Category</td>
                            </th>
                        </tr>
                        {{-- get first index and add selected class to it --}}
                        @if (!empty($admission))
                            @foreach ($admission['titles'] as $category)
                                @if ($loop->first)
                                    <tr id='b-{!! $category['id'] !!}' data-target='{!! array_search($category, $admission['titles']) !!}' class="selected" data-behavior="toggleFee">
                                @else
                                    </tr>
                                    <tr id='b-{!! $category['id'] !!}' data-target='{!! array_search($category, $admission['titles']) !!}' data-behavior="toggleFee">
                                @endif
                                    <td>
                                        <span class="f-module-title-1">{{$category['title']}}</span><svg><use xlink:href="#icon--info"/></svg>
                                    </td>
                                </tr>
                            @endforeach
                            <span class="select__select">
                                <select class="visit-fee-category-select" data-behavior="toggleFee">
                                    @foreach ($admission['titles'] as $category)
                                        <option label='{!! $category['title'] !!}' value='{!! array_search($category, $admission['titles']) !!}'>
                                    @endforeach
                                </select>
                            </span>
                        @endif
                    </table>
                        <div class="visit-separator"></div>
                        <table class="visit-fee-price">
                            <caption class="s-hidden">Admission costs for visits to the museum</caption>
                            <tr class="s-hidden">
                                <th scope="row">
                                    <td>Age group</td>
                                    <td>Price</td>
                                </th>
                            </tr>
                            @php $categoryFirst = true; @endphp
                            @foreach ($admission['prices'] as $price => $ageGroup)
                                @foreach ($ageGroup as $age)
                                    @if ($loop->first)
                                        @if ($categoryFirst)
                                            <tbody class="fee-ages selected" id="{!! $price !!}">
                                            @php $categoryFirst = false; @endphp
                                        @else
                                            <tbody class="fee-ages" id="{!! $price !!}">
                                        @endif
                                    @endif

                                    @php
                                        $formattedPrice = ($age[$price] == 0) ? 'Free' : '$' . $age[$price];
                                    @endphp

                                    <tr>
                                        <td>
                                            <span class="f-module-title-1">{{ $age['title'] }}</span>
                                            <span class="f-module-title-1">{!! $formattedPrice !!}</span>
                                        </td>
                                    </tr>

                                    @if ($loop->last)
                                        </tbody>
                                    @endif
                                @endforeach
                            @endforeach
                        </table>
                </div>
            </div>
                <div class="col">
                    <div class="visit-admission-info">
                        <span class="f-secondary">{!! $visit_admission_intro !!}</span>
                        <div class="btn-section">
                            <a href="#" class="btn f-buttons">Buy tickets</a>
                            <a href="#" class="btn f-buttons btn--secondary">Become a Member</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
