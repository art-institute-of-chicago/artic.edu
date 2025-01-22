@twillBlockTitle('Stories Block')
@twillBlockIcon('Image')

<x-twill::input
    name='stories_heading'
    label='Heading'
/>

@component('twill::partials.form.utils._columns')
    @slot('left')
        <x-twill::input
            name='browse_label'
            label='Browse More Label'
        />
    @endslot
    @slot('right')
        <x-twill::input
            name='browse_link'
            label='Browse More Link'
        />
    @endslot
@endcomponent

<x-twill::browser
    name='content'
    label='Stories'
    :max='5'
    :modules="[
        [
            'label' => 'Article',
            'value' => moduleRoute('articles', 'collection.articlesPublications', 'browser', ['is_unlisted' => false]),
        ],
        [
            'label' => 'Video',
            'value' => moduleRoute('videos', 'collection.articlesPublications', 'browser'),
        ],
        [
            'label' => 'Highlight',
            'value' => moduleRoute('highlights', 'collection', 'browser'),
        ],
        [
            'label' => 'Interactive Feature',
            'value' => moduleRoute('experiences', 'collection.interactiveFeatures', 'browser'),
        ],
    ]"
/>
