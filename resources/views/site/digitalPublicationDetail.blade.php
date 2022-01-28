@php
    use App\Models\DigitalPublicationSection;
@endphp

@extends('layouts.app')

@section('content')

<article class="o-article">
    @component('components.molecules._m-article-header----feature')
        @slot('variation', 'm-article-header--digital-publication')
        @slot('title', $item->present()->title)
        @slot('title_display', $item->present()->headerTitle())
        @slot('subtitle_display', $item->present()->headerSubtitle())
        @slot('img', $item->imageFront('listing'))
        @slot('imgMobile', $item->imageFront('mobile_listing'))
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
        @if ($item->welcome_note_display && $welcomeNote)
            <div class="o-issue__intro">
                @component('components.organisms._o-editors-note----publication')
                    @slot('description', $item->welcome_note_display)
                    @slot('articleLink', $welcomeNote->present()->getSectionUrl($item))
                @endcomponent
            </div>
        @endif

        @if ($item->present()->hasSections(DigitalPublicationSection::TEXT))
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--compact m-title-bar--light',
            ])
                {{ DigitalPublicationSection::$types[DigitalPublicationSection::TEXT] }}
            @endcomponent

            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--journal')
                @slot('cols_xsmall','1')
                @slot('cols_small','2')
                @slot('cols_medium','2')
                @slot('cols_large','2')
                @slot('cols_xlarge','2')
                @foreach ($item->present()->getSections(DigitalPublicationSection::TEXT) as $section)
                    @component('components.molecules._m-listing----publication')
                        @slot('variation', 'm-listing--journal')
                        @slot('href', $section->present()->getSectionUrl($item))
                        @slot('image', $section->imageFront('hero'))
                        @slot('type', $section->present()->getSectionType())
                        @slot('title', $section->present()->title)
                        @slot('title_display', $section->present()->title_display)
                        @slot('list_description', $section->present()->list_description)
                        @slot('author_display', $section->showAuthors())
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
                @endforeach
            @endcomponent
        @endif

        @if ($item->present()->hasSections(DigitalPublicationSection::WORK))
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--compact m-title-bar--light',
            ])
                {{ DigitalPublicationSection::$types[DigitalPublicationSection::WORK] }}
            @endcomponent

            @component('components.organisms._o-grid-listing')
                @slot('variation', 'o-grid-listing--journal')

                @foreach ($item->present()->getSections(DigitalPublicationSection::WORK) as $section)
                    @component('components.molecules._m-listing----publication')
                        @slot('variation', 'm-listing--work')
                        @slot('href', $section->present()->getSectionUrl($item))
                        @slot('image', $section->imageFront('hero'))
                        @slot('type', $section->present()->getSectionType())
                        @slot('title', $section->present()->title)
                        @slot('title_display', $section->present()->title_display)
                        @slot('list_description', $section->present()->list_description)
                        @slot('author_display', $section->showAuthors())
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
                @endforeach
            @endcomponent
        @endif

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
