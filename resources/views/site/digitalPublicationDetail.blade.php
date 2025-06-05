@extends('layouts.app')

@section('content')

<article class="o-article">
    @component('components.molecules._m-article-header----feature')
        @slot('variation', 'm-article-header--digital-publication')
        @slot('title', $item->present()->title)
        @slot('title_href', (request()->url() !== $item->present()->url) ? $item->present()->url : null)
        @slot('title_display', $item->present()->headerTitle())
        @slot('title_tag', (request()->url() !== $item->present()->url) ? 'a' : 'h1')
        @slot('subtitle_display', $item->present()->headerSubtitle())
        @slot('img', $item->imageAsArray('listing', 'banner') ?? $item->imageFront('listing'))
        @slot('imgMobile', $item->imageFront('mobile_listing'))
        @slot('credit', $item->hero_caption ?? null)
        @slot('editorial', true)
        @slot('bgcolor', $item->bgcolor)
    @endcomponent

    @component('components.molecules._m-sidebar-toggle')
        @slot('title', 'Table of Contents')
    @endcomponent

    <div class="o-article__primary-actions o-article__primary-actions--digital-publication">
        @component('components.molecules._m-article-actions----digital-publication')
            @slot('digitalPublication', $item)
            @slot('isLogoAnimated', true)
            @slot('citeAs', $item->cite_as)
        @endcomponent
    </div>

    <div class="o-article__body o-blocks">
        @if ($item->welcome_note_display && $showAll == false)
            <div class="o-issue__intro">
                @component('components.organisms._o-editors-note----publication')
                    @slot('description', $item->welcome_note_display)
                @endcomponent
            </div>
        @endif

        @foreach ($item->present()->topLevelArticles() as $topLevelArticle)

                @switch($topLevelArticle->listing_display)

                    @case('feature')

                        {{-- Title Component --}}
                        @if (!$topLevelArticle->hide_title)
                            @component('components.molecules._m-title-bar', [
                                'variation' => 'm-title-bar--compact m-title-bar--light',
                            ])
                            @slot('links', (count($topLevelArticle->children) > 4) ? $topLevelArticle->present()->getBrowseMoreLink($showAll) : [])
                            {!! $topLevelArticle->title !!}
                            @endcomponent
                        @endif

                        {{-- Listing Component --}}
                        @if (!$topLevelArticle->suppress_listing)
                            @if(count($topLevelArticle->children) > 0)
                                @foreach ($topLevelArticle->children->filter(function($articleItem) {
                                    return !$articleItem->suppress_listing;
                                    })->sortBy('position') as $articleItem)
                                    @if ($loop->iteration <= 4)
                                        @if($loop->first)
                                            @component('components.molecules._m-showcase')
                                                @slot('variation', 'showcase--digital-publication')
                                                @slot('tag', $articleItem->present()->label ?: null)
                                                @slot('title', $articleItem->present()->title_display ?? $articleItem->present()->title)
                                                @slot('author_display', $articleItem->showAuthors())
                                                @slot('description', $articleItem->present()->list_description)
                                                @slot('linkLabel', 'Read more')
                                                @slot('linkUrl', $articleItem->present()->url)
                                                @slot('image', $articleItem->imageFront('hero'))
                                                @slot('imageSettings', array(
                                                    'fit' => 'crop',
                                                    'ratio' => '16:9',
                                                    'srcset' => array(200,400,600),
                                                    'sizes' => ImageHelpers::aic_imageSizes(array(
                                                        'xsmall' => '216px',
                                                        'small' => '216px',
                                                        'medium' => '18',
                                                        'large' => '13',
                                                        'xlarge' => '13',
                                                    )),
                                                ))
                                            @endcomponent
                                        @else
                                            @if($loop->iteration == 2)
                                                @component('components.organisms._o-grid-listing')
                                                    @slot('cols_small','2')
                                                    @slot('cols_medium','3')
                                                    @slot('cols_large','3')
                                                    @slot('cols_xlarge','3')
                                            @endif
                                                @component('components.molecules._m-listing----digital-publication-article')
                                                    @slot('href', $articleItem->present()->url)
                                                    @slot('image', $articleItem->imageFront('hero'))
                                                    @slot('type', $articleItem->present()->label ?: null)
                                                    @slot('title', $articleItem->present()->title)
                                                    @slot('title_display', $articleItem->present()->title_display)
                                                    @slot('list_description', $articleItem->present()->list_description)
                                                    @slot('author_display', $articleItem->showAuthors())
                                                    @slot('imageSettings', array(
                                                        'fit' => 'crop',
                                                        'ratio' => '16:9',
                                                        'srcset' => array(200,400,600),
                                                        'sizes' => ImageHelpers::aic_imageSizes(array(
                                                            'xsmall' => '216px',
                                                            'small' => '216px',
                                                            'medium' => '18',
                                                            'large' => '13',
                                                            'xlarge' => '13',
                                                        )),
                                                    ))
                                                @endcomponent
                                            @if($loop->last || ($loop->iteration == 4 && $showAll == false))
                                                @endcomponent
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            @else
                                @component('components.molecules._m-showcase')
                                    @slot('variation', 'showcase--digital-publication')
                                    @slot('tag', $topLevelArticle->present()->label ?: null)
                                    @slot('title', $topLevelArticle->present()->title_display ?? $topLevelArticle->present()->title)
                                    @slot('author_display', $topLevelArticle->showAuthors())
                                    @slot('description', $topLevelArticle->present()->list_description)
                                    @slot('linkLabel', 'Read more')
                                    @slot('linkUrl', $topLevelArticle->present()->url)
                                    @slot('image', $topLevelArticle->imageFront('hero'))
                                    @slot('imageSettings', array(
                                        'fit' => 'crop',
                                        'ratio' => '16:9',
                                        'srcset' => array(200,400,600),
                                        'sizes' => ImageHelpers::aic_imageSizes(array(
                                            'xsmall' => '216px',
                                            'small' => '216px',
                                            'medium' => '18',
                                            'large' => '13',
                                            'xlarge' => '13',
                                        )),
                                    ))
                                @endcomponent
                            @endif
                        @endif
                    @break

                    @case('3-across')

                        {{-- Title Component --}}
                        @if (!$topLevelArticle->hide_title)
                            @component('components.molecules._m-title-bar', [
                                'variation' => 'm-title-bar--compact m-title-bar--light',
                            ])
                            @slot('links', (count($topLevelArticle->children) > 3) ? $topLevelArticle->present()->getBrowseMoreLink($showAll) : [])
                            {!! $topLevelArticle->title !!}
                            @endcomponent
                        @endif

                        {{-- Listing Component --}}
                        @if (!$topLevelArticle->suppress_listing)
                            @component('components.organisms._o-grid-listing')
                                @slot('cols_small','2')
                                @slot('cols_medium','3')
                                @slot('cols_large','3')
                                @slot('cols_xlarge','3')

                                @foreach ($topLevelArticle->children->filter(function($articleItem) {
                                    return !$articleItem->suppress_listing;
                                })->sortBy('position') as $articleItem)
                                    @if ($loop->iteration <= 3 || $showAll == true)
                                    @component('components.molecules._m-listing----digital-publication-article')
                                        @slot('href', $articleItem->present()->url)
                                        @slot('image', $articleItem->imageFront('hero'))
                                        @slot('type', $articleItem->present()->label ?: null)
                                        @slot('title', $articleItem->present()->title)
                                        @slot('title_display', $articleItem->present()->title_display)
                                        @slot('list_description', $articleItem->present()->list_description)
                                        @slot('author_display', $articleItem->showAuthors())
                                        @slot('imageSettings', array(
                                            'fit' => 'crop',
                                            'ratio' => '16:9',
                                            'srcset' => array(200,400,600),
                                            'sizes' => ImageHelpers::aic_imageSizes(array(
                                                'xsmall' => '216px',
                                                'small' => '216px',
                                                'medium' => '18',
                                                'large' => '13',
                                                'xlarge' => '13',
                                            )),
                                        ))
                                    @endcomponent
                                    @endif
                                @endforeach
                            @endcomponent
                        @endif
                    @break

                    @case('entries')

                        {{-- Title Component --}}
                        @if (!$topLevelArticle->hide_title)
                            @component('components.molecules._m-title-bar', [
                                'variation' => 'm-title-bar--compact m-title-bar--light',
                            ])
                                @slot('links', (count($topLevelArticle->children) > 4 && count($topLevelArticle->children) != 8) ? $topLevelArticle->present()->getBrowseMoreLink($showAll) : [])
                            {!! $topLevelArticle->title !!}
                            @endcomponent
                        @endif

                        {{-- Listing Component --}}
                        @if (!$topLevelArticle->suppress_listing)
                            @php
                                $children = $topLevelArticle->children->filter(function($articleItem) use($topLevelArticle) {
                                    return !$articleItem->suppress_listing && $articleItem->published;
                                })->sortBy('position');

                                $limitedChildren = isset($showAll) && $showAll
                                    ? $children
                                    : $children->take(count($children) >= 8 ? 8 : 4);
                            @endphp

                            @component('components.organisms._o-grid-listing')
                                @slot('cols_xsmall','2')
                                @slot('cols_small','2')
                                @slot('cols_medium','4')
                                @slot('cols_large','4')
                                @slot('cols_xlarge','4')

                                @foreach ($limitedChildren as $articleItem)
                                    @if (count($articleItem->children) > 0)
                                        @php
                                            $publishedChildren = $articleItem->children->filter(function($childItem) {
                                                return !$childItem->suppress_listing && $childItem->published;
                                            })->sortBy('position');
                                        @endphp

                                        @foreach ($publishedChildren as $childItem)
                                            @component('components.molecules._m-listing----digital-publication-article-entry')
                                                @slot('href', $childItem->present()->url)
                                                @slot('image', $childItem->imageFront('hero', 'square') ?? $childItem->imageFront('hero'))
                                                @slot('title', $childItem->present()->title)
                                                @slot('title_display', $childItem->present()->title_display)
                                                @slot('label', $childItem->present()->label)
                                                @slot('imageSettings', array(
                                                    'fit' => 'crop',
                                                    'ratio' => $childItem->imageFront('hero', 'square') ? '1' : '16:9',
                                                    'srcset' => array(200,400,600),
                                                    'sizes' => ImageHelpers::aic_imageSizes(array(
                                                        'xsmall' => '216px',
                                                        'small' => '216px',
                                                        'medium' => '18',
                                                        'large' => '13',
                                                        'xlarge' => '13',
                                                    )),
                                                ))
                                            @endcomponent
                                        @endforeach
                                    @else
                                        @component('components.molecules._m-listing----digital-publication-article-entry')
                                            @slot('href', $articleItem->present()->url)
                                            @slot('image', $articleItem->imageFront('hero', 'square') ?? $articleItem->imageFront('hero'))
                                            @slot('title', $articleItem->present()->title)
                                            @slot('title_display', $articleItem->present()->title_display)
                                            @slot('label', $articleItem->present()->label)
                                            @slot('imageSettings', array(
                                                'fit' => 'crop',
                                                'ratio' => $articleItem->imageFront('hero', 'square') ? '1' : '16:9',
                                                'srcset' => array(200,400,600),
                                                'sizes' => ImageHelpers::aic_imageSizes(array(
                                                    'xsmall' => '216px',
                                                    'small' => '216px',
                                                    'medium' => '18',
                                                    'large' => '13',
                                                    'xlarge' => '13',
                                                )),
                                            ))
                                        @endcomponent
                                    @endif
                                @endforeach
                            @endcomponent
                        @endif
                    @break

                    @case('group_entries')

                        {{-- Title Component --}}
                        @if (!$topLevelArticle->hide_title)
                            @component('components.molecules._m-title-bar', [
                                'variation' => 'm-title-bar--compact m-title-bar--light  m-digipub-grouping-title-bar',
                            ])
                            @slot('links', $topLevelArticle->present()->getBrowseMoreLink($showAll))
                            {!! $topLevelArticle->title !!}
                            @endcomponent
                        @endif
                        <br/>

                        {{-- Listing Component --}}
                        @if (!$topLevelArticle->suppress_listing)

                            @if ($showAll == true)

                                    @foreach ($topLevelArticle->children->filter(function($articleItem) {
                                        return !$articleItem->suppress_listing;
                                    })->sortBy('position') as $articleItem)

                                        @if ($articleItem->children && $articleItem->children->count() > 0)
                                            @component('components.molecules._m-title-bar', [
                                                'variation' => 'm-title-bar--no-hr m-digipub-subgrouping-title-bar',
                                                'titleFont' => 'f-list-2',
                                            ])
                                            {!! $articleItem->title !!}
                                            @endcomponent

                                            @component('components.organisms._o-grid-listing')
                                                @slot('cols_xsmall','2')
                                                @slot('cols_small','2')
                                                @slot('cols_medium','4')
                                                @slot('cols_large','4')
                                                @slot('cols_xlarge','4')

                                                @foreach ($articleItem->children->filter(function($articleItemChild) {
                                                    return !$articleItemChild->suppress_listing && $articleItemChild->published;
                                                })->sortBy('position') as $child)
                                                    @component('components.molecules._m-listing----digital-publication-article-entry')
                                                        @slot('href', $child->present()->url)
                                                        @slot('image', $child->imageFront('hero', 'square'))
                                                        @slot('title', $child->present()->title)
                                                        @slot('title_display', $child->present()->title_display)
                                                        @slot('label', $child->present()->label)
                                                    @endcomponent
                                                @endforeach

                                            @endcomponent
                                        @endif
                                    @endforeach
                            @else
                                @component('components.organisms._o-grid-listing')
                                    @slot('cols_xsmall','1')
                                    @slot('cols_small','1')
                                    @slot('cols_medium','3')
                                    @slot('cols_large','3')
                                    @slot('cols_xlarge','3')

                                    @foreach ($topLevelArticle->children->filter(function($articleItem) {
                                        return !$articleItem->suppress_listing;
                                    })->sortBy('position') as $articleItem)
                                        @if($loop->iteration <= 12 || $showAll == true)
                                            @component('components.molecules._m-listing----cover')
                                                @slot('variation', 'm-listing--cover--digital-publication')
                                                @slot('href', route(
                                                    'collection.publications.digital-publications.showListing',
                                                    [
                                                        'id' => $articleItem->digitalPublication->id,
                                                        'slug' => $articleItem->digitalPublication->getSlug()
                                                    ]
                                                ) . '#' . Str::kebab($articleItem->title))
                                                @slot('image', $articleItem->imageFront('grouping_hero') ?? $articleItem->imageFront('hero'))
                                                @slot('title', $articleItem->present()->title)
                                            @endcomponent
                                        @endif
                                    @endforeach


                                @endcomponent
                            @endif
                        @endif
                    @break

                    @case('list')

                        {{-- Title Component --}}
                        @if (!$topLevelArticle->hide_title)
                            @component('components.molecules._m-title-bar', [
                                'variation' => 'm-title-bar--compact m-title-bar--light',
                            ])
                            @slot('links', (count($topLevelArticle->children) > 3) ? $topLevelArticle->present()->getBrowseMoreLink($showAll) : [])
                            {!! $topLevelArticle->title !!}
                            @endcomponent
                        @endif

                        {{-- Listing Component --}}
                        @if (!$topLevelArticle->suppress_listing)
                            @component('components.organisms._o-grid-listing')
                                @slot('cols_small','1')

                                @foreach ($topLevelArticle->children->filter(function($articleItem) {
                                    return !$articleItem->suppress_listing;
                                })->sortBy('position') as $articleItem)
                                    @if ($loop->iteration <= 3 || $showAll == true)
                                        @component('components.molecules._m-listing----digital-publication-article')
                                            @slot('variation', 'm-listing--seventy-thirty')
                                            @slot('href', $articleItem->present()->url)
                                            @slot('image', $articleItem->imageFront('hero'))
                                            @slot('type', $articleItem->present()->label ?: null)
                                            @slot('title', $articleItem->present()->title)
                                            @slot('title_display', $articleItem->present()->title_display)
                                            @slot('list_description', $articleItem->present()->list_description)
                                            @slot('author_display', $articleItem->showAuthors())
                                            @slot('imageSettings', array(
                                                'fit' => 'crop',
                                                'ratio' => '16:9',
                                                'srcset' => array(200,400,600),
                                                'sizes' => ImageHelpers::aic_imageSizes(array(
                                                    'xsmall' => '216px',
                                                    'small' => '216px',
                                                    'medium' => '18',
                                                    'large' => '13',
                                                    'xlarge' => '13',
                                                )),
                                            ))
                                        @endcomponent
                                    @endif
                                @endforeach

                            @endcomponent
                        @endif
                    @break
                    @case('simple_list')

                        {{-- Title Component --}}
                        @if (!$topLevelArticle->hide_title)
                            @component('components.molecules._m-title-bar', [
                                'variation' => 'm-title-bar--compact m-title-bar--light',
                            ])
                            @slot('links', (count($topLevelArticle->children) > 3) ? $topLevelArticle->present()->getBrowseMoreLink($showAll) : [])
                            {!! $topLevelArticle->title !!}
                            @endcomponent
                        @endif

                        {{-- Listing Component --}}
                        @if (!$topLevelArticle->suppress_listing)

                            @if ($showAll == true)
                                @component('components.organisms._o-grid-listing')
                                    @slot('cols_small','2')
                                    @slot('cols_medium','3')
                                    @slot('cols_large','3')
                                    @slot('cols_xlarge','3')
                            @endif

                                @if(count($topLevelArticle->children) > 0)
                                    @foreach ($topLevelArticle->children->filter(function($articleItem) {
                                        return !$articleItem->suppress_listing;
                                    })->sortBy('position')->take($showAll ? count($topLevelArticle->children) : 3) as $articleItem)
                                        @if ($showAll !== true)
                                            @component('components.molecules._m-digipub-title-bar', [
                                                'variation' => 'm-title-bar--compact m-title-bar--no-hr',
                                            ])
                                                @slot('item', $articleItem)
                                                {!! $articleItem->present()->label ?: null !!}
                                            @endcomponent
                                        @else
                                            @component('components.molecules._m-listing----digital-publication-article')
                                                @slot('variation', 'm-listing--title-only')
                                                @slot('href', $articleItem->present()->url)
                                                @slot('image', $articleItem->imageFront('hero'))
                                                @slot('type', $articleItem->present()->label ?: null)
                                                @slot('title', $articleItem->present()->title)
                                                @slot('title_display', $articleItem->present()->title_display)
                                                @slot('list_description', $articleItem->present()->list_description)
                                                @slot('author_display', $articleItem->showAuthors())
                                                @slot('imageSettings', array(
                                                    'fit' => 'crop',
                                                    'ratio' => '16:9',
                                                    'srcset' => array(200,400,600),
                                                    'sizes' => ImageHelpers::aic_imageSizes(array(
                                                        'xsmall' => '216px',
                                                        'small' => '216px',
                                                        'medium' => '18',
                                                        'large' => '13',
                                                        'xlarge' => '13',
                                                    )),
                                                ))
                                            @endcomponent
                                        @endif
                                    @endforeach
                                @else
                                    @component('components.molecules._m-digipub-title-bar', [
                                        'variation' => 'm-title-bar--compact m-title-bar--no-hr',
                                    ])
                                        @slot('item', $topLevelArticle)
                                        {!! $topLevelArticle->present()->label ?: null !!}
                                    @endcomponent
                                @endif

                            @if ($showAll == true)
                                @endcomponent
                            @endif

                        @endif

                @break
                @default

                    {{-- Title Component --}}
                    @if (!$topLevelArticle->hide_title)
                        @component('components.molecules._m-title-bar', [
                            'variation' => 'm-title-bar--compact m-title-bar--light',
                        ])
                        @slot('links', (count($topLevelArticle->children) > 3) ? $topLevelArticle->present()->getBrowseMoreLink($showAll) : [])
                        {!! $topLevelArticle->title !!}
                        @endcomponent
                    @endif

                    {{-- Listing Component --}}
                    @if (!$topLevelArticle->suppress_listing)
                        @component('components.organisms._o-grid-listing')
                            @slot('cols_small','2')
                            @slot('cols_medium','3')
                            @slot('cols_large','3')
                            @slot('cols_xlarge','3')

                            @foreach ($topLevelArticle->children->filter(function($articleItem) {
                                return !$articleItem->suppress_listing;
                            })->sortBy('position') as $articleItem)
                                @if ($loop->iteration <= 3 || $showAll == true)
                                @component('components.molecules._m-listing----digital-publication-article')
                                    @slot('href', $articleItem->present()->url)
                                    @slot('image', $articleItem->imageFront('hero'))
                                    @slot('type', $articleItem->present()->label ?: null)
                                    @slot('title', $articleItem->present()->title)
                                    @slot('title_display', $articleItem->present()->title_display)
                                    @slot('list_description', $articleItem->present()->list_description)
                                    @slot('author_display', $articleItem->showAuthors())
                                    @slot('imageSettings', array(
                                        'fit' => 'crop',
                                        'ratio' => '16:9',
                                        'srcset' => array(200,400,600),
                                        'sizes' => ImageHelpers::aic_imageSizes(array(
                                            'xsmall' => '216px',
                                            'small' => '216px',
                                            'medium' => '18',
                                            'large' => '13',
                                            'xlarge' => '13',
                                        )),
                                    ))
                                @endcomponent
                                @endif
                            @endforeach
                        @endcomponent
                    @endif

                @endswitch
        @endforeach

        @if (isset($item->sponsor_display))
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--compact m-title-bar--light',
            ])
                Sponsors
            @endcomponent

            {!! $item->sponsor_display !!}
        @endif

        @if ($item->cite_as)
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--compact m-title-bar--light',
            ])
                How to Cite
            @endcomponent

            {!! $item->cite_as !!}
        @endif
    </div>
</article>

@endsection

@section('extra_scripts')
    <script src="{{FrontendHelpers::revAsset('scripts/blocks360.js')}}"></script>
    <script src="{{FrontendHelpers::revAsset('scripts/blocks3D.js')}}"></script>
@endsection
