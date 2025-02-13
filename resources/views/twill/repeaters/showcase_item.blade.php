@twillRepeaterTitle('Showcase Item')
@twillRepeaterMax('4')

<x-twill::select
    name='media_type'
    label='Media Type'
    :required='true'
    :unpack='true'
    :options="[
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

<x-twill::medias
    name='image'
    label='Media'
    :max='1'
    :required='true'
    :withVideoUrl='false'
/>

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
    :toolbar-options="[ 'bold', 'italic', 'underline', 'link', 'bullet', 'ordered' ]"
/>

<x-twill::formColumns>
    <x-slot:left>
        <x-twill::input
            name='link_label'
            label='Link Label'
        />
    </x-slot:left>
    <x-slot:right>
        <x-twill::input
            name='link_url'
            label='Link Url'
        />
    </x-slot:right>
</x-twill::formColumns>
