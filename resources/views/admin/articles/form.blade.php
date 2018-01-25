@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Publishing date',
    ])

    @formField('select', [
        'name' => 'layout_type',
        'label' => 'Article layout',
        'options' => $articleLayoutsList,
        'default' => '0'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero'
    ])

    @formField('multi_select', [
        'name' => 'categories',
        'label' => 'Categories',
        'options' => $categoriesList,
        'placeholder' => 'Select some categories',
    ])

    @formField('input', [
        'name' => 'type',
        'label' => 'Article Type'
    ])

    @formField('input', [
        'name' => 'headline',
        'label' => 'Headline',
        'rows' => 3,
        'type' => 'textarea'
    ])

    @formField('input', [
        'name' => 'author',
        'label' => 'Author'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Author Thumbnail',
        'name' => 'hero'
    ])

    @formField('block_editor')
@stop

@section('fieldsets')
    <a17-fieldset id="attributes" title="Related">
        @formField('browser', [
            'routePrefix' => 'whatson',
            'name' => 'exhibitions',
            'moduleName' => 'exhibitions',
            'max' => 20,
            'label' => 'Related Exhibitions',
        ])

        @formField('browser', [
            'routePrefix' => 'whatson',
            'name' => 'articles',
            'moduleName' => 'articles',
            'max' => 20,
            'label' => 'Related Articles',
        ])

        @formField('browser', [
            'routePrefix' => 'whatson',
            'name' => 'artists',
            'moduleName' => 'artists',
            'max' => 20,
            'label' => 'Related Artists',
        ])

        @formField('browser', [
            'routePrefix' => 'whatson',
            'name' => 'selections',
            'moduleName' => 'selections',
            'max' => 20,
            'label' => 'Related Selections',
        ])
    </a17-fieldset>
@endsection
