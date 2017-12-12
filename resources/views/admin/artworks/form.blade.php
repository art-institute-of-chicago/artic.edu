@extends('cms-toolkit::layouts.resources.form')

@section('form')
    {{ Form::model($form_fields, $form_options) }}
    <section class="box">
        <header class="header_small">
            <h3><b>{{ $form_fields['title'] or 'New item' }}</b></h3>
        </header>
        @formField('input', [
            'field' => 'datahub_id',
            'field_name' => 'Datahub ID',
            'required' => true
        ])
        @formField('input', [
            'field' => 'title',
            'field_name' => 'Title',
            'required' => true
        ])
        @formField('multi_select', [
            'field' => 'site_tags',
            'field_name' => 'Tags',
            'list' => $siteTagsList,
            'placeholder' => 'Select some tags',
        ])
        @formField('input', [
            'field' => 'subtitle',
            'field_name' => 'Subtitle',
        ])
        @formField('textarea', [
            'field' => 'copy',
            'field_name' => 'Copy'
        ])
    </section>
@stop


