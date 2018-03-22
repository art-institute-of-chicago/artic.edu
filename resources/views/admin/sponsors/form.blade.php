@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'copy',
        'label' => 'Sponsor copy',
    ])

    @formField('medias', [
        'name' => 'profile',
        'label' => 'Logo',
        'with_multiple' => false,
        'no_crop' => false
    ])
@stop
