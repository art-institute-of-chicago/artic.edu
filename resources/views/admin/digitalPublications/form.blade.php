@extends('twill::layouts.form')

@section('sideFieldsets')
    @formFieldset([
        'id' => 'digital-publication-links',
        'title' => 'Links',
    ])
        {{-- TODO: add links to groupings when the index page is created --}}
        <ul>
            <li>
                <a>About</a>
            </li>
            <li>
                <a>Contributions</a>
            </li>
            <li>
                <a>Works</a>
            </li>
            <li>
                <a>etc</a>
            </li>
            <li class="see-all">
                <a href="{{ url('/collection/articles_publications/digitalPublications/' . $item->id . '/articles') }}">
                    See all
                </a>
            </li>
        </ul>
    @endformFieldset
@stop
@push('extra_css')
    <style>
        #digital-publication-links li {
            margin-top: 1em;
        }
        #digital-publication-links li.see-all {
            font-weight: bold;
        }
    </style>
@endPush

@section('contentFields')
    @formField('wysiwyg', [
        'name' => 'header_title_display',
        'label' => 'Title lockup for header',
        'note' => 'Use Shift+Enter to add linebreak instead of starting a new paragraph',
        'toolbarOptions' => [
            'italic',
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'header_subtitle_display',
        'label' => 'Subtitle lockup for header',
        'toolbarOptions' => [
            'italic',
        ],
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Hero image',
        'name' => 'listing',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Hero image, mobile',
        'name' => 'mobile_listing',
        'note' => 'Minimum image width 2000px',
    ])

    @formField('color_select', [
        'name' => 'bgcolor',
        'label' => 'Hero background color',
        'options' => $heroBackgroundColors,
    ])

    @formField('wysiwyg', [
        'type' => 'textarea',
        'name' => 'hero_caption',
        'label' => 'Hero image caption',
        'note' => 'Usually used for copyright',
        'maxlength' => 255,
        'toolbarOptions' => [
            'italic', 'link',
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'listing_description',
        'label' => 'Listing description',
        'maxlength' => 300,
        'toolbarOptions' => [
            'italic',
        ],
    ])

    @formField('checkbox', [
        'name' => 'is_dsc_stub',
        'label' => 'This page is a stub that links out to publications.artic.edu',
    ])
@stop

@section('fieldsets')
    @formConnectedFields([
        'fieldName' => 'is_dsc_stub',
        'fieldValues' => true,
    ])
        @formFieldset([
            'id' => 'fields_for_dsc_stub',
            'title' => 'DSC Stub Fields',
        ])
            <p style="margin-bottom: -20px">This content is only shown when the page is a DSC stub.</p>
            <hr>

            @formField('medias', [
                'with_multiple' => false,
                'label' => 'Banner image',
                'name' => 'banner',
                'note' => 'Minimum image width 3000px'
            ])

            @formField('block_editor', [
                'blocks' => BlockHelpers::getBlocksForEditor([
                    '3d_model',
                    'accordion',
                    'hr',
                    'image',
                    'link',
                    'list',
                    'media_embed',
                    'membership_banner',
                    'newsletter_signup_inline',
                    'paragraph',
                    'split_block',
                    'timeline',
                    'video',
                ]),
            ])
        @endformFieldset
    @endformConnectedFields

    @formFieldset([
        'id' => 'fields_for_full_publication',
        'title' => 'Publication Fields',
    ])
        @formField('wysiwyg', [
            'name' => 'welcome_note_display',
            'label' => 'Welcome note text',
            'toolbarOptions' => [
                'italic',
            ],
        ])

        @formField('browser', [
            'name' => 'welcome_note_section',
            'label' => 'Welcome note section',
            'endpoint' => route('admin.collection.articles_publications.digitalPublications.articles.subbrowser',[
                'digitalPublication' => $item->id,
            ]),
            'max' => 1,
        ])

        @formField('wysiwyg', [
            'name' => 'sponsor_display',
            'label' => 'Sponsors',
            'toolbarOptions' => [
                'italic',
            ],
        ])

        @formField('wysiwyg', [
            'name' => 'cite_as',
            'label' => 'How to Cite',
            'toolbarOptions' => [
                'italic',
            ],
        ])
    @endformConnectedFields

    @include('admin.partials.related')

    @include('admin.partials.meta')

@endsection
