@twillBlockTitle('Collection Block')
@twillBlockIcon('Image')

<x-twill::input
    name='collection_heading'
    label='Heading'
/>

@formField('browser', [
    'name' => 'artworks',
    'routePrefix' => 'collection',
    'moduleName' => 'artworks',
    'label' => 'Artworks',
    'max' => 20,
])

@formField('wysiwyg', [
    'name' => 'bottom_desc',
    'label' => 'Description',
    'type' => 'textarea'
])

@component('twill::partials.form.utils._columns')
    @slot('left')
        <x-twill::input
            name='primary_button_label'
            label='Primary Button Label'
        />
    @endslot

    @slot('right')
        <x-twill::input
            name='primary_button_link'
            label='Primary Button Link'
        />
    @endslot
@endcomponent

@component('twill::partials.form.utils._columns')
    @slot('left')
        <x-twill::input
            name='secondary_button_label'
            label='Secondary Button Label'
        />
    @endslot

    @slot('right')
        <x-twill::input
            name='secondary_button_link'
            label='Secondary Button Link'
        />
    @endslot
@endcomponent
