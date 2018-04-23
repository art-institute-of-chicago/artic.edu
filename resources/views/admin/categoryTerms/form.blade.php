@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'datahub_id',
        'label' => 'Datahub ID',
        'disabled' => true
    ])
    @formField('input', [
        'name' => 'title',
        'label' => 'API Title',
        'disabled' => true
    ])

{{--
    @formField('input', [
        'name' => 'local_title',
        'label' => 'Augmented Title',
    ])
 --}}

    @formField('input', [
        'name' => 'subtype',
        'label' => 'Sub Type',
        'disabled' => true
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Thumbnail Image',
        'name' => 'thumb'
    ])
@stop
