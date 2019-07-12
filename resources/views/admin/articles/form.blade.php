@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'attributes', 'label' => 'Attributes'],
        ['fieldset' => 'related', 'label' => 'Further Reading'],
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related']
    ]
])

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Display date',
    ])

    @formField('select', [
        'name' => 'layout_type',
        'label' => 'Article layout',
        'options' => $articleLayoutsList,
        'default' => '0'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('multi_select', [
        'name' => 'categories',
        'label' => 'Categories',
        'options' => $categoriesList,
        'placeholder' => 'Select some categories',
    ])

    @formField('input', [
        'name' => 'subtype',
        'label' => 'Article Label'
    ])

    @formField('wysiwyg', [
        'name' => 'heading',
        'label' => 'Header',
        'maxlength' => 255,
        'note' => 'Max 255 characters. Will be used on the article detail page.',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'list_description',
        'label' => 'List Description',
        'maxlength' => 255,
        'note' => 'Max 255 characters. Will be used on the article landing and listing pages, and social media.',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('input', [
        'name' => 'author',
        'label' => 'Author',
        'maxlength' => 255
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Author thumbnail',
        'name' => 'author',
        'note' => 'Minimum image width 600px'
    ])

    @formField('checkbox', [
        'name' => 'is_boosted',
        'label' => 'Boost this article on search results'
    ])

    @formField('wysiwyg', [
        'name' => 'citations',
        'label' => 'Citation',
        'maxlength' => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic',
        ],
    ])

    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            'paragraph', 'image', 'video', 'gallery', 'media_embed', 'quote',
            'list', 'artwork', 'artworks', 'hr', 'citation', 'split_block',
            'membership_banner', 'digital_label', 'tour_stop', 'button', 'mobile_app'
        ])
    ])

@stop

@section('fieldsets')
    <a17-fieldset id="related" title="Further Reading">

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'name' => 'further_reading_items',
            'moduleName' => 'articles',
            'endpoints' => [
                [
                    'label' => 'Article',
                    'value' => '/collection/articles_publications/articles/browser'
                ],
                [
                    'label' => 'Interactive feature',
                    'value' => moduleRoute('interactiveFeatures.experiences', 'collection', 'browser')
                ]
            ],
            'max' => 4,
            'label' => 'Related items',
        ])

    </a17-fieldset>

    <a17-fieldset id="side_related" title="Sidebar Related - Only one will show up randomly">
        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'videos',
            'max' => 1,
            'name' => 'videos',
            'label' => 'Related video'
        ])

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'articles',
            'max' => 1,
            'name' => 'sidebarArticle',
            'label' => 'Related article',
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 1,
            'name' => 'sidebarExhibitions',
            'label' => 'Related Exhibition',
            'moduleName' => 'exhibitions',
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'events',
            'name' => 'sidebarEvent',
            'label' => 'Related event',
            'max' => 1
        ])
    </a17-fieldset>

    @php
        $relatedTos = $item->relatedTos;
    @endphp
    @if ($relatedTos->isNotEmpty())
        <a17-fieldset id="related" title="Related">

            <p>The following content has been related to this one. These will be used to bring this item into global search results.</p>

            <ol style="margin: 1em 0; padding-left: 40px">
                @foreach($relatedTos as $related)
                    <li style="list-style-type: decimal; margin-bottom: 0.5em">
                        {!! Str::title($related->subject_type) !!}: <a href="{!! route($related->subject_type .'.show', $related->subject) !!}">{{ $related->subject->title }}</a>
                    </li>
                @endforeach
            </ol>
        </a17-fieldset>
    @endif

    @include('admin.partials.meta')

@endsection
