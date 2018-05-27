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
        'maxlength' => 190
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
        'name' => 'thumb',
        'note' => 'Minimum image width 1500px'
    ])
@stop
