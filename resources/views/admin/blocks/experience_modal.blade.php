@formField('select', [
    'name' => 'modal_type',
    'label' => 'Modal Type',
    'placeholder' => 'Choose Modal Type',
    'default' => 'image',
    'options' => [
        [
            'value' => 'image',
            'label' => 'Image'
        ],
        [
            'value' => 'video',
            'label' => 'Video'
        ],
        [
            'value' => 'image_sequence',
            'label' => 'Image Sequence'
        ],
        [
            'value' => '3d_modal',
            'label' => '3D Model'
        ]
    ]
])

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'modal_type',
        'fieldValues' => 'image',
        'renderForBlocks' => true,
        'keepAlive' => true
])
    @formField('checkbox', [
        'name' => 'zoomable',
        'label' => 'Zoomable'
    ])

    @formField('repeater', ['type' => 'modal_experience_image'])
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'modal_type',
        'fieldValues' => 'video',
        'renderForBlocks' => true,
        'keepAlive' => true
])
    @include('admin.experiences.slides._video_form')
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'modal_type',
        'fieldValues' => 'image_sequence',
        'renderForBlocks' => true,
        'keepAlive' => true
])
    @formField('files', [
        'name' => 'image_sequence_file',
        'label' => 'Image Sequence Zip',
        'note' => 'Upload a .zip file'
    ])

    @formField('multi_select', [
        'name' => 'image_sequence_playback',
        'label' => 'playback',
        'options' => [
            [
                'value' => 'reverse',
                'label' => 'Reverse'
            ],
            [
                'value' => 'infinite',
                'label' => 'Infinite'
            ]
        ]
    ])
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'modal_type',
        'fieldValues' => '3d_modal',
        'renderForBlocks' => true,
        'keepAlive' => true
])
    <br />
    <a17-block-if_3d_model name="aic_split_3d_model" />
    @push('vuexStore')
        @php($aic3DModel = $item->AIC3DModel)
        @foreach (['model_url', 'model_id', 'camera_position', 'camera_target', 'annotation_list'] as $name)
            window.STORE.form.fields.push({
                name: "{{ 'aic_3d_model[' . $name . ']' }}",
                value: {!! json_encode($aic3DModel ? $aic3DModel->$name : '') !!}
            })
        @endforeach
    @endpush
@endcomponent

@formField('wysiwyg', [
    'name' => 'image_sequence_caption',
    'label' => 'Caption',
    'maxlength' => 500,
])