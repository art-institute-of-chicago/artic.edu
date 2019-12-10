@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Setting'
    ])

@section('contentFields')
    @include('admin.experiences.slides._setting')
@stop

@section('fieldsets')
    <a17-fieldset title="Content" id="content">
        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'module_type',
            'fieldValues' => '3dtour',
            'keepAlive' => true,
            'isEqual' => false
        ])
            @include('admin.experiences.slides._asset_type')
        @endcomponent

        @include('admin.experiences.slides._attract')
        @include('admin.experiences.slides._end')
        @include('admin.experiences.slides._split')
        @include('admin.experiences.slides._interstitial')
        @include('admin.experiences.slides._fullwidthmedia')
        @include('admin.experiences.slides._tooltip')
        @include('admin.experiences.slides._compare')
        @include('admin.experiences.slides._3dtour')
    </a17-fieldset>
@stop
@push('extra_js')
    <script>
        const attributesField = window.STORE.form.fields.find(field => field.name == 'split_attributes');
        if (attributesField) {
            attributesField.value.forEach(function (option) {
                const e = document.getElementById(option);
                if (e) {
                    e.style.display = 'block';
                }
            });
        }
        window.vm.$store.watch(
            function (state) {
                return state.form.fields;
            },
            function (newVal, oldVal) {
                const attributes = newVal.find(field => field.name == 'split_attributes');
                if (attributes) {
                    const options = ['inset', 'primary_modal', 'headline', 'secondary_image', 'secondary_modal', 'caption'];
                    options.forEach(function (option) {
                        const e = document.getElementById(option);
                        if (e) {
                            if (attributes.value.includes(option)) {
                                e.style.display = 'block';
                            } else {
                                e.style.display = 'none';
                            }
                        }
                    });
                }
            }
        )
    </script>
@endpush

@push('vuexStore')
    @foreach($form_fields['repeaterFields']['modal_experience_image'] ?? [] as $field)
        window.STORE.form.fields.push({!! json_encode($field) !!})
    @endforeach

    @foreach($form_fields['repeaterMedias']['modal_experience_image'] ?? [] as $name => $medias)
        window.STORE.medias.selected["{{ $name }}"] = {!! json_encode($medias) !!}
    @endforeach

    @foreach($form_fields['repeaterFiles']['modal_experience_image'] ?? [] as $name => $files)
        window.STORE.medias.selected["{{ $name }}"] = {!! json_encode($files) !!}
    @endforeach

    @foreach($form_fields['repeaterBrowsers']['modal_experience_image'] ?? [] as $name => $fields)
        window.STORE.browser.selected["{{ $name }}"] = {!! json_encode($fields) !!}
    @endforeach
@endpush