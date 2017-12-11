@extends('cms-toolkit::layouts.resources.form')

@section('form')
    {{ Form::model($form_fields, $form_options) }}
    @formField('publish_status')

    <section class="columns with_right_sidebar">
        <section class="col">
            <section class="box">
                @formField('versions', ['with_preview' => isset($item)])

                @formField('date_picker', [
                     'field' => 'date',
                     'field_name' => 'Publishing date',
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
                @formField('textarea', [
                    'field' => 'copy',
                    'field_name' => 'Short Copy'
                ])
            </section>
        </section>
    </section>

    @formField('browser', [
        'routePrefix' => 'whatson',
        'relationship' => 'exhibitions',
        'module_name' => 'exhibitions',
        'relationship_name' => 'related exhibitions',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'hint' => 'Select related exhibitions',
        'max' => 20
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'relationship' => 'articles',
        'module_name' => 'articles',
        'relationship_name' => 'related articles',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'hint' => 'Select related articles',
        'max' => 20
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'relationship' => 'artists',
        'module_name' => 'artists',
        'relationship_name' => 'related artists',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'hint' => 'Select related artists',
        'max' => 20
    ])
@stop
