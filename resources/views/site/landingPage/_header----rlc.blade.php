<section class="rlc" itemscope itemtype="http://schema.org/TouristAttraction">
    <link itemprop="additionalType" href="http://schema.org/Museum" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LandmarksOrHistoricalBuildings" aria-hidden="true"/>
    <link itemprop="additionalType" href="http://schema.org/LocalBusiness" aria-hidden="true"/>

    @component('components.organisms._o-header-landing')
        @slot('mainFeatures', $mainFeatures)
        @slot('headerMedia', $headerMedia)
        @slot('variation', 'rlc')
    @endcomponent

    <h2 class="f-title">{{ $title }}</h2>
    <p class="f-intro">{{ $intro }}</p>
    <div class="o-menu-bar">
        @if(!empty($item->menuItems))
            <ul>
                @foreach($item->menuItems as $item)
                    <li class="m-links-bar__item">
                        <a class="m-links-bar__item-trigger f-link" href={{ $item->link }}>
                            {{ $item->label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="o-info-grid">
        <div class="row">
            <div class="col">
                <div class="spacer">
                    <div class="semicircle">
                    </div>
                </div>
            </div>
            <div class="col">
                <h3 id="hours" class="title">{{ $hours['primary'] }}</h3>
                <hr>
                <table class="hours">
                    <caption class="intro">{!! $hours['intro'] !!}</caption>
                    <tr class="s-hidden">
                        <th scope="row">
                            <td>days</td>
                            <td>hours</td>
                        </th>
                    </tr>
                    @if (!empty($hours['hours']))
                        @foreach ($hours['hours']->present()->getHoursTableForHeader() as $item)
                            @php
                                $hourClass = $item['hours'] === 'Closed' ? 'closed' : '';
                            @endphp
                            <tr>
                                <th scope="row" class="{{ $hourClass }}">
                                    <span>{{ $item['days'] }}</span>
                                </th>
                                <td>
                                    <span>{{ $item['hours'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
            <div class="col">
                <h3 id="location" class="title">{{ $location_header }}</h3>
                <hr>
                <div class="location">
                    <div class="location-image">
                        @component('components.atoms._img')
                            @slot('image', $location_image['default'])
                            @slot('srcset', $location_image['default']['src'])
                            @slot('class', 'role-default')
                        @endcomponent
                        @component('components.atoms._img')
                            @slot('image', $location_image['mobile'])
                            @slot('srcset', $location_image['mobile']['src'])
                            @slot('class', 'role-mobile')
                        @endcomponent
                    </div>
                    <div class="location-information">
                        <div class="intro">
                            {!! $location_intro !!}
                        </div>
                        <div class="directions-link">
                            <a class="f-link" target="_blank" rel="noopener"  href="{{ $directions_link }}">
                                {{ $directions_label }}
                            </a>
                        </div>
                        <div class="visit-button">
                            <a href="{{ $visit_museum_button_link }}" class="btn btn--secondary f-buttons">
                                {{ $visit_museum_button_label }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
