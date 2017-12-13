@extends('cms-toolkit::layouts.resources.form')

@section('form')
    {{ Form::model($form_fields, $form_options) }}
    @formField('publish_status')

    <section class="columns with_right_sidebar">
        <section class="col">
            <section class="box">
                @formField('versions', ['with_preview' => isset($item)])

                @formField('date_picker', [
                     'field' => 'start_date',
                     'field_name' => 'Start date',
                ])
                @formField('date_picker', [
                     'field' => 'end_date',
                     'field_name' => 'End date',
                ])

                @formField('input', [
                    'field' => 'datahub_id',
                    'field_name' => 'Datahub ID',
                ])

                @formField('multi_select', [
                    'field' => 'site_tags',
                    'field_name' => 'Tags',
                    'list' => $siteTagsList,
                    'placeholder' => 'Select some tags',
                ])
            </section>
        </section>
        <section class="col">
            <section class="box">
                <header class="header_small">
                    <h3><b>{{ $form_fields['title'] or 'New item' }}</b></h3>
                </header>
                @formField('input', [
                    'field' => 'title',
                    'field_name' => 'Title',
                ])
                @formField('input', [
                    'field' => 'header_copy',
                    'field_name' => 'Header'
                ])
                @formField('textarea', [
                    'field' => 'short_copy',
                    'field_name' => 'Short Copy'
                ])
                @formField('medias', [
                    'media_role' => 'hero',
                    'media_role_name' => 'Hero',
                    'with_multiple' => false,
                    'no_crop' => false
                ])
            </section>
        </section>
    </section>

    @formField('browser', [
        'routePrefix' => 'whatson',
        'relationship' => 'events',
        'module_name' => 'events',
        'relationship_name' => 'related events',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'hint' => 'Select related events',
        'max' => 20
    ])
@stop
