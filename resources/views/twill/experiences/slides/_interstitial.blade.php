@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'module_type',
    'fieldValues' => 'interstitial',
    'keepAlive' => true,
])
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

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'asset_type',
        'fieldValues' => 'standard',
        'keepAlive' => true,
    ])
        <x-twill::repeater
            type="interstitial_experience_image"
        />
    @endcomponent
@endcomponent
