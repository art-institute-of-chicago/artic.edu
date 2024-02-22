<{{ $tag ?? 'li' }} class="m-listing m-listing--highlight{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{!! route('highlights.show', $item) !!}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        @if (!isset($hideImage) || (isset($hideImage) && !($hideImage)))
            <span class="m-listing__img m-listing__img--no-bg{{ (isset($imgVariation)) ? ' '.$imgVariation : ' m-listing__img' }}">
                @if ($image ?? $item->imageFront('hero') ?? $item->images[0] ?? false)
                    @if ($isHero ?? false)
                        @component('components.atoms._img')
                            @slot('image', $image ?? $item->imageFront('hero') ?? $item->images[0])
                            @slot('class', 'img-hero-desktop')
                            @slot('settings', !isset($imageSettings) ? null : array_merge($imageSettings, [
                                'ratio' => isset($imgVariation) ? null : ($imageSettings['ratio'] ?? '1:1'),
                            ]))
                        @endcomponent
                        @component('components.atoms._img')
                            @slot('image', $imageMobile ?? $item->imageFront('mobile_hero') ?? $image ?? $item->imageFront('hero') ?? $item->images[0])
                            @slot('class', 'img-hero-mobile')
                            @slot('settings', !isset($imageSettings) ? null : array_merge($imageSettings, [
                                'ratio' => isset($imgVariation) ? null : ($imageSettings['ratio'] ?? '1:1'),
                            ]))
                        @endcomponent
                    @else
                        @component('components.atoms._img')
                            @slot('image', $imageMobile ?? $item->imageFront('mobile_hero') ?? $image ?? $item->imageFront('hero') ?? $item->images[0])
                            @slot('settings', !isset($imageSettings) ? null : array_merge($imageSettings, [
                                'ratio' => isset($imgVariation) ? null : ($imageSettings['ratio'] ?? '1:1'),
                            ]))
                        @endcomponent
                    @endif
                @else
                    <span class="default-img"></span>
                @endif
                <span class="m-listing__img__overlay">
                    <svg class="icon--slideshow--24">
                        <use xlink:href="#icon--slideshow--24"></use>
                    </svg>
                </span>
            </span>
        @endif
        <span class="m-listing__meta">
            <em class="type f-tag">{{isset($variation) && $variation == 'm-listing--feature' ? 'Collection ' : '' }}{!! $item->present()->subtype !!}</em>
            <br>
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                @slot('title', $item->present()->title)
                @slot('title_display', $item->present()->title_display)
            @endcomponent
            {{-- WEB-2018: No list description anywhere? --}}
        </span>
    </a>
</{{ $tag ?? 'li' }}>
