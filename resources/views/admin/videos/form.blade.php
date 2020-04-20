@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'video_url',
        'label' => 'Video URL'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Display date',
    ])

    @formField('input', [
        'name' => 'heading',
        'label' => 'Heading',
        'rows' => 3,
        'type' => 'textarea'
    ])

    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            'paragraph', 'quote',
            'list', 'artwork', 'artworks', 'hr', 'split_block',
            'membership_banner', 'tour_stop', 'button', 'mobile_app'
        ])
    ])
@stop

@section('fieldsets')

    @include('admin.partials.related')

@endsection
