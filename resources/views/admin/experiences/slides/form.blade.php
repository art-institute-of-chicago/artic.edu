@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Setting'
    ])

@section('contentFields')
    @include('admin.experiences.slides._setting')
@stop

@section('fieldsets')
    <a17-fieldset title="Content" id="content">
        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'standard_media_type',
            'fieldValues' => 'type_video',
            'keepAlive' => true,
        ])
            <br/>
            <a17-fieldset title="Video" id="video">
                @include('admin.experiences.slides._youtube_form')
            </a17-fieldset>
        @endcomponent

        @include('admin.experiences.slides._attract')
        @include('admin.experiences.slides._end')
        @include('admin.experiences.slides._split')
        @include('admin.experiences.slides._interstitial')
        @include('admin.experiences.slides._fullwidthmedia')
        @include('admin.experiences.slides._tooltip')
        @include('admin.experiences.slides._compare')
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