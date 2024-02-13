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

    @component('components.organisms._o-header-landing')
        @slot('mainFeatures', $mainFeatures)
        @slot('headerMedia', $headerMedia)
        @slot('variation', 'visit')
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
            @include('components.molecules._m-auto-subnav', ['subnav' => $subnav])
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
                <span class="f-secondary">{!! $hours['intro'] !!}</span>
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
                                <a class="f-link" target="_blank" rel="noopener" href="{{ $location->directions_link }}">Get directions&nbsp;<svg aria-hidden="true" class="icon--new-window"><use xlink:href="#icon--new-window" /></svg></a>
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
                            <th scope="row" class="s-hidden">
                                <td class="s-hidden">Category</td>
                            </th>
                        </tr>
                        {{-- get first index and add selected class to it --}}
                        @if (!empty($admission))
                            @foreach ($admission['titles'] as $category)
                                @if (!$loop->first)
                                    </tr>
                                @endif
                                <tr id='b-{!! $category['id'] !!}' data-target='{!! array_search($category, $admission['titles']) !!}' {{ $loop->first ? 'class="selected"' : '' }} data-behavior="toggleFee">
                                    <td>
                                        <span class="f-module-title-1">{{$category['title']}}</span>
                                        @if ($category['tooltip'])
                                            <span class="admission-info-button-container">
                                                <button data-tooltip-target='t-{!! $category['id'] !!}' class="admission-info-button-trigger" data-behavior="showAdmissionTooltip" aria-label="Info" aria-expanded="false">
                                                    <svg class="icon--info"><use xlink:href="#icon--info" /></svg>
                                                </button>
                                                <div class="admission-info-button-info" id='t-{!! $category['id'] !!}'>
                                                    <div class="f-caption">
                                                        {{ $category['tooltip'] }}
                                                    </div>
                                                </div>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            <span class="select__select">
                                <select class="visit-fee-category-select" data-behavior="toggleFee">
                                    @foreach ($admission['titles'] as $category)
                                        <option label='{!! $category['title'] !!}' value='{!! array_search($category, $admission['titles']) !!}'>{!! $category['title'] !!}</option>
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
                            <hr>
                            @php $categoryFirst = true; @endphp
                            @foreach ($admission['titles'] as $category)
                                <p id='{!! array_search($category, $admission['titles']) !!}' class="f-secondary admission-info-text {{ $loop->first ? 'selected' : '' }}">
                                    {{ $category['tooltip'] }}
                                </p>
                            @endforeach
                            @foreach ($admission['prices'] as $price => $ageGroup)
                                @if ($ageGroup['description'])
                                    <tbody class="fee-ages admission-description {{ $categoryFirst ? 'selected' : '' }}" id="{!! $price !!}">
                                        @php $categoryFirst = false; @endphp
                                        <tr>
                                            <td>
                                                <span class="f-module-title-1">
                                                    {!! $ageGroup['description'] !!}
                                                </span>

                                                <a href="{{ $ageGroup['link_url'] }}" class="btn btn--tertiary btn--w-icon f-buttons">
                                                    {{ $ageGroup['link_label'] }} <svg aria-hidden="true" class="icon--new-window"><use xlink:href="#icon--new-window" /></svg>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                @else
                                    @foreach ($ageGroup as $key => $age)
                                        @if (is_numeric($key))
                                            @if ($loop->first)
                                                <tbody class="fee-ages {{ $categoryFirst ? 'selected' : '' }}" id="{!! $price !!}">
                                                @php $categoryFirst = false; @endphp
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
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </table>
                </div>
            </div>
                <div class="col">
                    <div class="visit-admission-info">
                        <span class="f-secondary">{!! $visit_admission_intro !!}</span>
                        <div class="btn-section">
                            <a href="{{ $visit_admission_tix_link }}" class="btn f-buttons">{!! $visit_admission_tix_label !!}</a>
                            <a href="{{ $visit_admission_members_link }}" class="btn f-buttons btn--secondary">{!! $visit_admission_members_label !!}</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
