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

                {{-- @formField('multi_select', [
                    'field' => 'selected_sectors',
                    'field_name' => 'Sectors',
                    'list' => $sectorsList,
                    'placeholder' => 'Select some sectors',
                ]) --}}

                {{-- @formField('multi_select', [
                    'field' => 'selected_disciplines',
                    'field_name' => 'Disciplines',
                    'list' => $disciplinesList,
                    'placeholder' => 'Select some disciplines',
                ]) --}}
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
            </section>
        </section>
    </section>

    {{-- @formField('medias', ['media_role' => 'media_role'])
    @formField('files', ['file_role' => 'file role', 'file_role_name' => 'Role name'])
    @formField('block_editor', ['field_name' => 'content']) --}}
@stop


