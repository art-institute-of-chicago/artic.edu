@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Banner image',
        'name' => 'banner',
        'note' => 'Minimum image width 2000px'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Listing image',
        'name' => 'listing',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('wysiwyg', [
        'name' => 'listing_description',
        'label' => 'Listing description',
        'maxlength'  => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('input', [
        'name' => 'short_description',
        'label' => 'Short description',
        'type' => 'textarea',
        'maxlength' => 255
    ])

    @formField('input', [
        'name' => 'publication_year',
        'label' => 'Publication year',
    ])

    @formField('multi_select', [
        'name' => 'categories',
        'label' => 'Categories',
        'options' => $categoriesList,
        'placeholder' => 'Select some categories',
    ])

    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            'paragraph', 'image', 'video', 'media_embed', 'list',
            'accordion', 'membership_banner', 'timeline', 'link', 'newsletter_signup_inline',
            'hr', 'split_block'
        ])
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="metadata" title="Overwrite default metadata (optional)">
        @formField('input', [
            'name' => 'meta_title',
            'label' => 'Metadata Title'
        ])

        @formField('input', [
            'name' => 'meta_description',
            'label' => 'Metadata Description',
            'type' => 'textarea'
        ])
    </a17-fieldset>
@endsection
