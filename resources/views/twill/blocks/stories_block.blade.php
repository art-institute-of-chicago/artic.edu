@twillBlockTitle('Stories Block')
@twillBlockTitleField('stories_heading')
@twillBlockIcon('Image')

<x-twill::input
    name='stories_heading'
    label='Heading'
/>

<x-twill::formColumns>
    <x-slot:left>
        <x-twill::input
            name='browse_label'
            label='Browse More Label'
        />
    </x-slot:left>
    <x-slot:right>
        <x-twill::input
            name='browse_link'
            label='Browse More Link'
        />
    </x-slot:right>
</x-twill::formColumns>

<x-twill::browser
    name='content'
    label='Stories'
    :max='5'
    :modules="[
        [
            'label' => 'Article',
            'name' => 'collection.articlesPublications.articles',
        ],
        [
            'label' => 'Video',
            'name' => 'collection.articlesPublications.videos'
        ],
        [
            'label' => 'Highlight',
            'name' => 'collection.highlights'
        ],
        [
            'label' => 'Interactive Feature',
            'name' => 'collection.interactiveFeatures.experiences'
        ],
    ]"
    :params="[ 'is_unlisted' => false ]"
/>
