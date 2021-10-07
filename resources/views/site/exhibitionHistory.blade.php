@extends('layouts.app')

@section('content')

    @component('components.molecules._m-header-block')
        Exhibition History
    @endcomponent

    @component('components.molecules._m-intro-block')
        {!! $page->present()->exhibition_history_sub_heading !!}
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--gridlines-rows')
        @slot('cols_medium', '2')
        @slot('cols_large', '2')
        @slot('cols_xlarge', '2')
        @slot('tag', 'div')

        <div class="o-blocks">
            @component('components.molecules._m-media')
                @slot('item', $page->present()->exhibitionHistoryMedia)
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => array(200,300,600,1000,1500),
                    'sizes' => ImageHelpers::aic_imageSizes(array(
                        'xsmall' => 58,
                        'small' => 58,
                        'medium' => 28,
                        'large' => 28,
                        'xlarge' => 28,
                    )),
                ))
            @endcomponent
        </div>
        <div class="o-blocks">
            @component('components.blocks._blocks')
                @slot('blocks', $page->present()->introBlocks)
            @endcomponent
        </div>
    @endcomponent

    @component('components.molecules._m-links-bar')
        @slot('id', 'listing')
        @slot('variation', 'm-links-bar--filters')
        @slot('primaryHtml')
            <li class="m-links-bar__item m-links-bar__item--primary">
                @component('components.atoms._dropdown')
                    @slot('prompt', 'Decade: '.$decade_prompt)
                    @slot('ariaTitle', 'Select decade')
                    @slot('variation', 'dropdown--filter f-link')
                    @slot('font', null)
                    @slot('options', $decades)
                @endcomponent
            </li>
            <li class="m-links-bar__item m-links-bar__item--primary">
                @component('components.atoms._dropdown')
                    @slot('prompt', 'Year: '. $activeYear)
                    @slot('ariaTitle', 'Select decade')
                    @slot('variation', 'dropdown--filter f-link')
                    @slot('font', null)
                    @slot('options', $years)
                @endcomponent
            </li>
            <li class="m-links-bar__item m-links-bar__item--search">
                @component('components.molecules._m-search-bar')
                    @slot('variation', 'm-search-bar--subtle')
                    @slot('placeholder', 'Keyword')
                    @slot('name', 'q')
                    @slot('action', route('exhibitions.history', request()->all()))
                    @slot('clearLink', route('exhibitions.history', request()->except('q')))
                    @slot('value', request()->get('q'))
                    @slot('hiddenFields', ['year' => $activeYear])
                    @slot('behaviors', 'ajaxFormSubmit')
                    @slot('dataAttributes', 'data-ajax-scroll-target="listing"')
                @endcomponent
            </li>
        @endslot
    @endcomponent

    @component('components.molecules._m-title-bar')
        @if ($exhibitions->count() > 0)
            @slot('links', [
                [
                    'label' => 'Showing ' . $exhibitions->count() . ' out of ' . $exhibitions->total() . ' Exhibitions'
                ]
            ])
        @endif
        @slot('titleFont', 'f-display-1')
        {{ $activeYear }}
    @endcomponent

    @if ($exhibitions->count() > 0)
        @component('components.atoms._hr')
        @endcomponent
        @component('components.organisms._o-row-listing')
            @foreach ($exhibitions as $item)
                @component('components.molecules._m-listing----exhibition-history-row')
                    @slot('variation', 'm-listing--row')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        // WEB-1880: This one will always be a CMS image, not a IIIF image
                        'srcset' => array(108,216,400,600),
                        'sizes' => ImageHelpers::aic_imageSizes(array(
                            'xsmall' => 58,
                            'small' => 58,
                            'medium' => 13,
                            'large' => 13,
                            'xlarge' => 13,
                        )),
                    ))
                @endcomponent
            @endforeach
        @endcomponent
    @else
        {{-- Extracted from components.molecules._m-no-results--}}
        <div class="m-no-results">
            @component('components.atoms._hr')
            @endcomponent
            @component('components.atoms._title')
                @slot('tag', 'h2')
                @slot('font', 'f-list-3')
                @if ($extraResults && !$extraResults->isEmpty())
                    There are no results in this year. However, there are <a href={!! route('search.exhibitions', request()->only('q')) !!}>{{ $extraResults->total() }} results</a> across the rest of the archive.
                @else
                    Sorry, we couldn't find any results matching your criteria
                @endif
            @endcomponent
        </div>
    @endif

    {!! $exhibitions->appends(request()->all())->links() !!}

    <div class="o-injected-container" data-behavior="injectContent" data-injectContent-url="{!! route('artworks.recentlyViewed') !!}" data-user-artwork-history></div>

@endsection
