
@if ($item->url_without_slug)
    <{{ $tag ?? 'li' }} class="stories-custom-listing m-listing--article{{ (isset($variation)) ? ' '.$variation : '' }}">
        <a href="{{ $item->url_without_slug }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
            <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}">
                @if ($item->type == 'custom')
                    @if (isset($item->image) && $item->image)
                        @component('components.atoms._img')
                            @slot('image', $item->image)
                            @slot('settings', $imageSettings ?? '')
                            @if ($isHero ?? false)
                                @slot('class', 'img-hero-desktop')
                            @endif
                        @endcomponent
                        @if ($isHero ?? false)
                            @component('components.atoms._img')
                                @slot('image', $item->image)
                                @slot('settings', $imageSettings ?? '')
                                @slot('class', 'img-hero-mobile')
                            @endcomponent
                        @endif
                    @else
                        <span class="default-img"></span>
                    @endif
                @else
                    @if (isset($image) || isset($item->image) || (method_exists($item, 'imageFront') && $item->imageFront('listing')) || (method_exists($item, 'imageFront') && $item->imageFront('hero')))
                        @if ($isHero ?? false)
                            @component('components.atoms._img')
                                @slot('image', $image ?? $item->image ?? (method_exists($item, 'imageFront') ? $item->imageFront('listing') : null) ?? (method_exists($item, 'imageFront') ? $item->imageFront('hero') : null))
                                @slot('settings', $imageSettings ?? '')
                                @slot('class', 'img-hero-desktop')
                            @endcomponent
                            @component('components.atoms._img')
                                @slot('image', $imageMobile ?? $item->image ?? (method_exists($item, 'imageFront') ? $item->imageFront('listing') : null) ?? $image ?? (method_exists($item, 'imageFront') ? $item->imageFront('mobile_hero') : null) ?? (method_exists($item, 'imageFront') ? $item->imageFront('listing_mobile') : null) ?? (method_exists($item, 'imageFront') ? $item->imageFront('hero') : null))
                                @slot('settings', $imageSettings ?? '')
                                @slot('class', 'img-hero-mobile')
                            @endcomponent
                        @else 
                            @component('components.atoms._img')
                                @slot('image', $image ?? $item->image ?? (method_exists($item, 'imageFront') ? $item->imageFront('listing') : null) ?? (method_exists($item, 'imageFront') ? $item->imageFront('hero') : null))
                                @slot('settings', $imageSettings ?? '')
                            @endcomponent
                        @endif
                    @else
                        <span class="default-img"></span>
                    @endif
                @endif
                <div class="m-listing__img__overlay" style="display: block">
                @if ($item->type === 'video')
                    <svg class="icon--play--{!! (isset($isFeatured) && $isFeatured) ? '64' : '48' !!}">
                        <use xlink:href="#icon--play--{!! (isset($isFeatured) && $isFeatured) ? '64' : '48' !!}"></use>
                    </svg>
                @endif
                </div>
            </span>
            <div class="m-listing__meta"{{ (isset($variation) and strrpos($variation, "--hero") > -1) ? ' data-blur-clip-to' : '' }}>
                @if ($item->type === 'custom' && isset($item->label) && $item->label)
                    @component('components.atoms._type')
                        {{ $item->label }}
                    @endcomponent
                    <br>
                @elseif ((isset($item->type) && ($item->type === 'digital_publication')))
                    @component('components.atoms._type')
                        {!! method_exists($item, 'present') ? $item->present()->subtype : (isset($item->subtype) ? $item->subtype : $item->type) !!}
                    @endcomponent
                    <br>
                @endif
                @component('components.atoms._title')
                    @slot('font', $titleFont ?? 'f-list-3')
                    @slot('title', $item->title)
                    @slot('title_display', $item->type === 'custom' ? $item->title : (method_exists($item, 'present') ? $item->present()->title_display : (isset($item->title_display) ? $item->title_display : $item->title)))
                @endcomponent
                <br>
                @if ($isFeatured)
                    @if ($item->type === 'custom' || $item->type === 'augmented')
                        @if (isset($item->list_description) && $item->list_description)
                            <div class="intro {{ $captionFont ?? 'f-caption' }}">{!! $item->list_description !!}</div>
                        @endif
                    @else
                        @if ((isset($item->authors) && (count($item->authors) > 0)) || isset($item->author_display))
                            <div class="author f-body-editorial">
                                @if (isset($item->author_display))
                                    by ⁠{!! $item->author_display !!}
                                @elseif (isset($item->authors) && count($item->authors) > 0)
                                    <span class="author__name">
                                        by {{StringHelpers::summation($item->authors->pluck('title')->all())}}
                                    </span>
                                @endif
                            </div>
                        @endif
                        @if (method_exists($item, 'present') ? $item->present()->list_description : (isset($item->list_description) ? $item->list_description : ''))
                            <div class="intro {{ $captionFont ?? 'f-caption' }}">{!! method_exists($item, 'present') ? $item->present()->list_description : $item->list_description !!}</div>
                        @endif
                    @endif
                @endif
                @if ($item->type !== 'custom' && ((isset($item->authors) && (count($item->authors) > 0)) || isset($item->author_display)) && !$isFeatured)
                    <div class="author f-body-editorial">
                        @if (isset($item->author_display))
                            by ⁠{!! $item->author_display !!}
                        @elseif (isset($item->authors) && count($item->authors) > 0)
                            <span class="author__name">
                                by {{StringHelpers::summation($item->authors->pluck('title')->all())}}
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </a>
    </{{ $tag ?? 'li' }}>
@endif