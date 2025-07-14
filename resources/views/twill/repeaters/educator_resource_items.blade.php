@twillRepeaterTitle('Educator Resource Item')
@twillRepeaterTrigger('Add educator resource')

<x-twill::formColumns>

    <x-slot:left>
        <x-twill::browser
            name='educator_resource_item'
            label="Resource"
            note='Highlighted Resource'
            :max='1'
            :endpoints="[
              [
                  'label' => 'Article',
                  'value' => '/collection/articlesPublications/articles/browser?published=true&is_published=true'
              ],
              [
                  'label' => 'Educator Resources',
                  'value' => '/collection/researchResources/educatorResources/browser?published=true&is_published=true'
              ],
              [
                  'label' => 'Highlight',
                  'value' => '/collection/highlights/browser?published=true&is_published=true'
              ],
              [
                  'label' => 'Interactive feature',
                  'value' => '/collection/interactiveFeatures/experiences/browser?published=true&is_published=true'
              ],
              [
                  'label' => 'Video',
                  'value' => '/collection/articlesPublications/videos/browser?published=true&is_published=true'
              ],
            ]"
        />
    </x-slot>

    <x-slot:right>
        <x-twill::medias
            name='listing_image'
            label='Custom Image'
            note='Overrides Item Image'
            :max='1'
        />
    </x-slot>

</x-twill::formColumns>

<x-twill::formColumns>

    <x-slot:left>
        <x-twill::input
            name='title'
            label='Title'
            note='Overrides Item Title'
        />
        <x-twill::input
            name='linkUrl'
            label='Link Url'
            note='Overrides Item Link'
        />
    </x-slot>

    <x-slot:right>
        <x-twill::input
            name='label'
            label='Eyebrow label'
            note='Overrides Type Label'
        />
    </x-slot>

</x-twill::formColumns>

<x-twill::wysiwyg
    name='description'
    label='Description'
    note='Overrides item description'
    :toolbar-options="[ 'italic', 'link' ]"
/>
