@php
    $itemCategories = isset($item) && isset($item->categories) ? collect($item->categories->pluck('name'))->values() : collect([]);
@endphp

<{{ $tag ?? 'li' }}
    class="m-listing m-listing--educator-resource{{ isset($isIndex) ? '__index' : '' }} m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}"
    data-filter-values="{{
        $itemCategories->map(function($item) {
            $slug = Str::slug($item);
            $lower = Str::lower($slug);
            return $lower;
        })->values()->implode(',')
    }},{{
        $item->hasActiveTranslation('es') ? 'es' : ''
    }}"
    data-filter-date="{{
        isset($item) && isset($item->publish_start_date) ? date('d-m-Y', strtotime($item->publish_start_date)) : ''
    }}"
    data-filter-title="{{
        isset($item) && isset($item->title) ? htmlspecialchars($item->title) : ''
    }}"
>
    <a href="{!! route(($module ?? 'collection.resources.educator-resources') .'.show', ($routeParameters ?? $item)) !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        @if (!isset($hideImage) || (isset($hideImage) && !($hideImage)))
            <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}{{ ($item->videoFront) ? ' m-listing__img--video' : '' }}"{{ (isset($variation) and strrpos($variation, "--hero") > -1 and !$item->videoFront) ? ' data-blur-img' : '' }}>
                @if (isset($image) || $item->imageFront('hero') || $item->imageFront('listing'))
                    @if ($isHero ?? false)
                        @component('components.atoms._img')
                            @slot('image', $image ?? $item->imageFront('hero') ?? $item->imageFront('listing'))
                            @slot('settings', $imageSettings ?? '')
                            @slot('class', 'img-hero-desktop')
                        @endcomponent
                        @component('components.atoms._img')
                            @slot('image', $imageMobile ?? $item->imageFront('mobile_hero') ?? $image ?? $item->imageFront('hero'))
                            @slot('settings', $imageSettings ?? '')
                            @slot('class', 'img-hero-mobile')
                        @endcomponent
                    @else
                        @component('components.atoms._img')
                            @slot('image', $image ?? $item->imageFront('hero') ?? $item->imageFront('listing'))
                            @slot('settings', $imageSettings ?? '')
                        @endcomponent
                    @endif
                    @component('components.molecules._m-listing-video')
                        @slot('item', $item)
                        @slot('image', $image ?? null)
                    @endcomponent
                @else
                    <span class="default-img"></span>
                @endif
                <div class="m-listing__img__overlay" style="display: block">
                    @if ($item->hasMediaContent)
                        <svg class="icon--play--{!! (isset($isFeatured) && $isFeatured) ? '64' : '48' !!}">
                            <use xlink:href="#icon--play--{!! (isset($isFeatured) && $isFeatured) ? '64' : '48' !!}"></use>
                        </svg>
                    @endif
                </div>
            </span>
        @endif
        <div class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
            @if (isset($item->subtype) && !$isIndex)
                <em class="type f-tag">{!! $subtype ?? $item->present()->subtype !!}</em>
                <br>
            @endif
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                @slot('title', $item->present()->title)
                @slot('title_display', $item->present()->title_display)
            @endcomponent
            <br>
            @if (!isset($hideDescription) || (isset($hideDescription) && !($hideDescription)))
                @if ($item->present()->listing_description)
                    <div class="intro {{ $captionFont ?? 'f-caption' }}">{!! $item->present()->listing_description !!}</div>
                @endif
            @endif
        </div>
    </a>
    @if ((isset($isIndex) && $isIndex))
        @php
            // Check if we have any content for either English or Spanish
            $hasEnglishContent = $item->hasActiveTranslation('en') || $item->file('pdf', 'en');
            $hasSpanishContent = $item->hasActiveTranslation('es') || $item->file('pdf', 'es');
        @endphp

        @if ($hasEnglishContent || $hasSpanishContent)
            <div class="m-listing__secondary-actions">

                @if ($hasEnglishContent)
                    <div class="m-listing__secondary-action__links">
                        <span class="f-secondary">English:</span>

                        @if ($item->hasActiveTranslation('en'))
                            <a class="f-link f-tertiary" href="{{ $item->url }}">View</a>
                        @endif

                        @if ($item->file('pdf', 'en'))
                            <a class="f-link f-tertiary" href="{{ $item->file('pdf', 'en') }}" download="{{ $item->title . '.pdf' }}">Download</a>
                        @endif
                    </div>
                @endif

                @if ($hasSpanishContent)
                    <div class="m-listing__secondary-action__links">
                        <span class="f-secondary">Español:</span>

                        @if ($item->hasActiveTranslation('es'))
                            <a class="f-link f-tertiary" href="{{ $item->url . '?locale=es' }}">View</a>
                        @endif

                        @if ($item->file('pdf', 'es'))
                            <a class="f-link f-tertiary" href="{{ $item->file('pdf', 'es') }}" download="{{ $item->title . '.pdf' }}">Download</a>
                        @endif
                    </div>
                @endif

            </div>
        @endif
    @endif
</{{ $tag ?? 'li' }}>
