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

                @formField('multi_select', [
                    'field' => 'site_tags',
                    'field_name' => 'Tags',
                    'list' => $siteTagsList,
                    'placeholder' => 'Select some tags',
                ])

                @formField('checkbox', [
                     'field' => 'recurring',
                     'field_name' => 'Recurring event',
                ])

                @formField('date_picker', [
                     'field' => 'recurring_start_date',
                     'field_name' => 'Recurring Start date',
                ])
                @formField('date_picker', [
                     'field' => 'recurring_end_date',
                     'field_name' => 'Recurring end date',
                ])

                @formField('input', [
                    'field' => 'recurring_days',
                    'field_name' => 'Recurring days',
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
                    'field' => 'admission',
                    'field_name' => 'Admission',
                ])
                @formField('input', [
                    'field' => 'price',
                    'field_name' => 'Price'
                ])
                @formField('input', [
                    'field' => 'datahub_id',
                    'field_name' => 'Datahub ID'
                ])
                @formField('input', [
                    'field' => 'location',
                    'field_name' => 'Location'
                ])
                @formField('input', [
                    'field' => 'latitude',
                    'field_name' => 'Latitude'
                ])
                @formField('input', [
                    'field' => 'longitude',
                    'field_name' => 'Longitude'
                ])
            </section>
        </section>
    </section>

    {{-- @formField('medias', ['media_role' => 'media_role'])
    @formField('files', ['file_role' => 'file role', 'file_role_name' => 'Role name'])
    @formField('block_editor', ['field_name' => 'content']) --}}
@stop


