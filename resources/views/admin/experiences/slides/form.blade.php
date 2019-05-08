@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Setting'
    ])

@section('contentFields')
    @include('admin.experiences.slides._setting')
@stop

@section('fieldsets')
    <a17-fieldset title="Content" id="content">
        @include('admin.experiences.slides._asset_type')

        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'asset_type',
            'fieldValues' => 'standard',
            'keepAlive' => true,
            ])
            @foreach(['split', 'fullwidthmedia'] as $moduleType)
                @component('twill::partials.form.utils._connected_fields', [
                    'fieldName' => $moduleType . '_standard_media_type',
                    'fieldValues' => 'type_video',
                    'keepAlive' => true,
                ])
                    @component('twill::partials.form.utils._connected_fields', [
                        'fieldName' => 'module_type',
                        'fieldValues' => $moduleType,
                        'renderForBlocks' => false,
                        'keepAlive' => true,
                    ])
                        <br/>
                        <a17-fieldset title="Video" id="video">
                            @include('admin.experiences.slides._youtube_form', ['moduleType' => $moduleType])
                        </a17-fieldset>
                    @endcomponent
                @endcomponent
            @endforeach
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