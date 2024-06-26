@php
    $level = ($parentLevel ?? 0) + 1;
    $hasEventCategory = isset($eventCategory);
@endphp
@foreach ($list as $item)
    @php
        $slug = Str::slug($item['name']);
        $id = "$role-level-$level-$slug";
        $hasUrl = isset($item['url']) && !empty($item['url']);
        $isCurrentPage = $hasUrl ? (Request::url() == str(url($item['url']))->before('#')) : false;
        $hasImage = isset($item['image']);
        $hasDescription = isset($item['description']);
        $hasCta = isset($item['cta']);
        $hasChildren = isset($item['children']);
    @endphp
    <li @class(["level-$level", $item['class'] ?? null]) role="none">
        <a
            id="{{ $id }}"
            role="menuitem"
            @if($hasUrl)
                href="{{ $item['url'] }}"
                @if($isCurrentPage)
                    aria-current="page"
                @endif
            @else
                href="#"
            @endif
            @if($hasEventCategory)
                data-gtm-event-category="{{ $eventCategory }}"
                data-gtm-event="{{ $slug }}"
            @endif
            @if($hasChildren)
                aria-haspopup="true"
                aria-expanded="false"
            @endif
        >
            {!! $item['name'] !!}
            @if ($hasChildren)
                <span class="g-nav-expand-icon" data-nav-trigger>
                    <svg aria-hidden="true" class="icon--arrow">
                        <use xlink:href="#icon--arrow" />
                    </svg>
                </span>
            @endif
        </a>
        @if(($hasImage && $hasDescription) || $hasChildren)
            <div class="details">
                <a href="#" class="g-nav-collapse-icon arrow-link arrow-link--back" data-nav-back>
                    <svg aria-hidden="true" class="icon--arrow">
                        <use xlink:href="#icon--arrow" />
                    </svg>
                </a>
                <span class="details__container">
                @if($hasUrl)
                    <a
                        class="title-link"
                        href="{{ $item['url'] }}"
                        @if($isCurrentPage)
                            aria-current="page"
                        @endif
                    >
                @else
                    <span>
                @endif
                    @if($hasImage)
                        @component('components.atoms._img')
                            @slot('image', ['src' => $item['image']])
                            @slot('class', 'details-image')
                            @slot('dataAttributes', "aria-describedby='$id-description'")
                            @slot('settings', [
                                'srcset' => [240, 480, 960],
                                'sizes' => '240px',
                            ])
                        @endcomponent
                    @endif
                    <div class="description__container">
                        <div class="title">{!! $item['name'] !!}</div>
                        @if($hasDescription)
                            <p id="{{ $id }}-description" class="description">{!! $item['description'] !!}</p>
                        @endif
                        @if($hasCta)
                            <p class="cta">
                                {!! $item['cta'] !!}
                                <svg aria-hidden="true" class="icon--arrow">
                                    <use xlink:href="#icon--arrow" />
                                </svg>
                            </p>
                        @endif
                    </div>
                @if($hasUrl)
                    </a>
                @else
                    </span>
                @endif
                @if ($hasChildren)
                    <ul aria-labelledby="{{ $id }}" role="menu">
                        @include('partials._navigation-list', [
                            'role' => $role,
                            'parentLevel' => $level,
                            'eventCategory' => $eventCategory,
                            'list' => $item['children'],
                        ])
                    </ul>
                @endif
                </span>
            </div>
        @endif
    </li>
@endforeach
