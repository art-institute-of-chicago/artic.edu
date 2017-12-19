@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
        'required' => true
    ])

    @formField('input', [
        'name' => 'copy',
        'label' => 'Sponsor Copy',
    ])

    @formField('medias', [
        'media_role' => 'logo',
        'media_role_name' => 'Logo',
        'with_multiple' => false,
        'no_crop' => false
    ])
@stop
