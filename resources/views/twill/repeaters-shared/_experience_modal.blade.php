<x-twill::select
    name='modal_type'
    label='Modal Type'
    placeholder='Choose Modal Type'
    default='image'
    :options="[
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
            'value' => '3d_model',
            'label' => '3D Model'
        ]
    ]"
/>

<x-twill::formConnectedFields
        field-name='modal_type'
        field-values="image"
        :render-for-blocks='true'
        :keep-alive='true'
>
    <x-twill::checkbox
        name='zoomable'
        label='Zoomable'
    />

    <x-twill::repeater
        type="modal_experience_image"
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
        field-name='modal_type'
        field-values="video"
        :render-for-blocks='true'
        :keep-alive='true'
>
    @include('twill.experiences.slides._video_form')
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
        field-name='modal_type'
        field-values="image_sequence"
        :render-for-blocks='true'
        :keep-alive='true'
>
    <x-twill::files
        name='image_sequence_file'
        label='Image Sequence Zip'
        note='Upload a .zip file'
    />

    <x-twill::multi-select
        name='image_sequence_playback'
        label='playback'
        :options="[
            [
                'value' => 'reverse',
                'label' => 'Reverse'
            ],
            [
                'value' => 'infinite',
                'label' => 'Infinite'
            ]
        ]"
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
        field-name='modal_type'
        field-values="3d_model"
        :render-for-blocks='true'
        :keep-alive='true'
>
    <br />
    <a17-block-aic_3d_model :name="fieldName('aic_split_3d_model')" :thumbnail="false" :caption="false" :browser="false" :cc0="false" />
</x-twill::formConnectedFields>

<x-twill::wysiwyg
    name='image_sequence_caption'
    label='Caption'
    :maxlength='500'
/>
