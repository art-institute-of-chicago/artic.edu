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
        'name' => 'logo',
        'label' => 'Logo',
        'with_multiple' => false,
        'no_crop' => false
    ])
@stop
