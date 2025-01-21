@twillRepeaterTitle('Showcase Item')
@twillRepeaterMax('4')

<x-twill::select
    name='media_type'
    label='Media Type'
    :required='true'
    :unpack='true'
    :options='[
        [
            'value' => 'image',
            'label' => 'Image'
        ],
        [
            'value' => 'video',
            'label' => 'Video'
        ]
    ]"
/>

@formField('medias', [
    'name' => 'image',
    'label' => 'Media',
    'max' => 1,
    'withVideoUrl' => false,
    'required' => true,
])

<x-twill::input
    name='tag'
    label='Tag'
    :maxlength='100'
/>

<x-twill::wysiwyg
    name='title'
    label='Title'
    :maxlength='100'
    :required='true'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::wysiwyg
    name='description'
    label='Description'
    :required='true'
    :toolbar-options="[ 'bold', 'italic', 'underline', 'link', ['list' => 'bullet'], ['list' => 'ordered'] ]"
/>

@component('twill::partials.form.utils._columns')
    @slot('left')
        <x-twill::input
            name='link_label'
            label='Link Label'
        />
    @endslot
    @slot('right')
        <x-twill::input
            name='link_url'
            label='Link Url'
        />
    @endslot
@endcomponent
