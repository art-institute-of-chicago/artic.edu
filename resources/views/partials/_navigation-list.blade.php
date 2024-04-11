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
                <svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
            @endif
        </a>
        @if(($hasImage && $hasDescription) || $hasChildren)
            <div class="details">
                @if($hasUrl)
                    <a
                        href="{{ $item['url'] }}"
                        @if($isCurrentPage)
                            aria-current="page"
                        @endif
                    >
                @else
                    <span>
                @endif
                @if($hasImage)
                    <img src="{{ $item['image'] }}" aria-describedby="{{ $id }}-description" alt="">
                @endif
                @if($hasDescription)
                    <div class="description">
                        <div class="title">{!! $item['name'] !!}</div>
                        <p id="{{ $id }}-description">{!! $item['description'] !!}</p>
                        @if($hasCta)
                            <p class="cta">
                                {!! $item['cta'] !!}
                                <svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
                            </p>
                        @endif
                    </div>
                @endif
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
            </div>
        @endif
    </li>
@endforeach
