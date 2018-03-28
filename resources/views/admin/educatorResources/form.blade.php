@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Hero image',
        'name' => 'hero'
    ])

    @formField('input', [
        'name' => 'short_description',
        'label' => 'Short Description',
        'type' => 'textarea'
    ])
    @formField('block_editor', [
        'blocks' => [
            'paragraph', 'image', 'video', 'media_embed', 'list',
            'accordion', 'membership_banner', 'timeline', 'link', 'newsletter_signup_inline'
        ]
    ])
@stop

