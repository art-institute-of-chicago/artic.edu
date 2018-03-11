@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'copy',
        'label' => 'Sponsor Copy',
    ])

    @formField('medias', [
        'name' => 'profile',
        'label' => 'Logo',
        'with_multiple' => false,
        'no_crop' => false
    ])
@stop
