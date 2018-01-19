@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'datahub_id',
        'label' => 'Datahub ID',
        'required' => true
    ])
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
        'required' => true
    ])
    @formField('multi_select', [
        'name' => 'site_tags',
        'label' => 'Tags',
        'options' => $siteTagsList,
        'placeholder' => 'Select some tags',
    ])
    @formField('input', [
        'name' => 'subtitle',
        'label' => 'Subtitle',
    ])
    @formField('input', [
        'name' => 'copy',
        'label' => 'Copy',
        'type' => 'textarea'
    ])

    @formField('browser', [
        'label' => 'Selections',
        'routePrefix' => 'whatson',
        'name' => 'selections',
        'moduleName' => 'selections',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => false,
        'max' => 20
    ])

    @formField('browser', [
        'label' => 'Exhibitions',
        'routePrefix' => 'whatson',
        'name' => 'exhibitions',
        'moduleName' => 'exhibitions',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'max' => 20
    ])

    @formField('browser', [
        'label' => 'Articles',
        'routePrefix' => 'whatson',
        'name' => 'articles',
        'moduleName' => 'articles',
        'custom_title_prefix' => 'Add',
        'with_multiple' => true,
        'with_sort' => true,
        'max' => 20
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="related" title="API Fields">
        @foreach($item->getApiFields() as $field => $value)
            @formField('input', [
                'name' => $field,
                'label' => $field,
                'disabled' => true
            ])
        @endforeach
    </a17-fieldset>
@endsection
