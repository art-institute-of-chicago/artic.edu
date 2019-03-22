@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Setting'
    ])

@section('contentFields')
    @include('admin.experiences.slides._asset_type')

    @formField('select', [
        'name' => 'module_type',
        'required' => true,
        'label' => 'Module Type',
        'placeholder' => 'Select a type',
        'options' => [
            [
                'value' => 'split',
                'label' => 'Split'
            ],
            [
                'value' => 'interstitial',
                'label' => 'Interstitial'
            ],
            [
                'value' => 'tooltip',
                'label' => 'Tooltip'
            ],
            [
                'value' => 'full-width-media',
                'label' => 'Full-Width Media'
            ],
            [
                'value' => 'compare',
                'label' => 'Compare'
            ],
        ]
    ])
@stop

@section('fieldsets')
    <a17-fieldset title="Content" id="content">
        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'module_type',
            'fieldValues' => 'split',
        ])
            @formField('multi_select', [
                'name' => 'attributes',
                'label' => 'Attributes',
                'options' => [
                    [
                        'value' => 'inset',
                        'label' => 'Inset'
                    ],
                    [
                        'value' => 'primary_modal',
                        'label' => 'Primary Modal'
                    ],
                    [
                        'value' => 'headline',
                        'label' => 'Headline'
                    ],
                    [
                        'value' => 'secondary_image',
                        'label' => 'Secondary Image'
                    ],
                    [
                        'value' => 'secondary_modal',
                        'label' => 'Secondary Modal'
                    ],
                    [
                        'value' => 'caption',
                        'label' => 'Caption'
                    ],
                ]
            ])

            @component('twill::partials.form.utils._connected_fields', [
                'fieldName' => 'attributes',
                'fieldValues' => 'headline',
            ])
                @formField('input', [
                    'name' => 'headline',
                    'label' => 'Headline'
                ])
            @endcomponent
        @endcomponent
    </a17-fieldset>
@stop

@push('extra_js')
    <script>
        console.log('test')
    </script>
@endpush