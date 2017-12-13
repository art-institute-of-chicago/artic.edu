@extends('cms-toolkit::layouts.resources.form')

@section('form')
    {{ Form::model($form_fields, $form_options) }}
    @formField('publish_status')

    <section class="box">
        <header class="header_small">
            <h3><b>Closure</b></h3>
        </header>

        @formField('input', [
            'field' => 'title',
            'field_name' => 'Title',
            'required' => true
        ])

        @formField('input', [
            'field' => 'copy',
            'field_name' => 'Sponsor Copy',
        ])

        @formField('medias', [
            'media_role' => 'logo',
            'media_role_name' => 'Logo',
            'with_multiple' => false,
            'no_crop' => false
        ])
    </section>
@stop
