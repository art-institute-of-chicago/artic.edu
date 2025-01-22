<x-twill::formConnectedFields
    field-name='module_type'
    field-values="interstitial"
    :keep-alive='true'
>
    <x-twill::wysiwyg
        name='article_title'
        label='Article Title'
        :maxlength='150'
    />

    <x-twill::wysiwyg
        name='interstitial_headline'
        label='Headline'
        :maxlength='150'
    />

    <x-twill::wysiwyg
        name='body_copy'
        label='Body Copy'
        :maxlength='500'
    />

    <x-twill::formConnectedFields
        field-name='asset_type'
        field-values="standard"
        :keep-alive='true'
    >
        <x-twill::repeater
            type="interstitial_experience_image"
        />
    </x-twill::formConnectedFields>
</x-twill::formConnectedFields>
