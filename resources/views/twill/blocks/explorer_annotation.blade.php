@twillBlockTitle('Explorer Annotation')
@twillBlockIcon('info')

<x-twill::input
    name='label'
    label='Label Text'
    note='Text to display next to the annotation'
/>

<x-twill::medias
    name='icon'
    label='Icon'
    note='Replace the default icon'
/>

<x-twill::input
    name='color'
    label='Icon color'
    note='Only applies if icon is not set'
    placeholder='#4ecdc4'
/>

<x-twill::input
    name='annotationTarget'
    label='Annotation target ID'
    note='Reference the ID of a model or element to target'
/>

<x-twill::input
    name="coordinate"
    label="Position"
    placeholder="[0, 0, 0]"
    note="X, Y, Z coordinates"
/>

<x-twill::input
    name="rotation"
    label="Rotation"
    placeholder="[0, 0, 0]"
    note="Rotation in radians"
/>

<x-twill::input
    name='scale'
    label='Scale'
    placeholder="0.5"
    note="Size of the annotation icon"
/>

<x-twill::multi-select
    name='annotationSettings'
    label='Annotation Settings'
    :unpack='true'
    :options="[
        [
            'value' => 'showLabel',
            'label' => 'Show Label'
        ],
        [
            'value' => 'sizeAttenuation',
            'label' => 'Fixed Size (no perspective scaling)'
        ],
    ]"
/>

@php
$blocks = BlockHelpers::getBlocksForEditor([
    '3d_model',
    'accordion',
    'hr',
    'image',
    'link',
    'list',
    'media_embed',
    'membership_banner',
    'newsletter_signup_inline',
    'paragraph',
    'split_block',
    'timeline',
    'video',
    '360_embed'
]);
@endphp

<x-twill::block-editor
    name='annotation_block_blocks'
    :blocks='$blocks'
    withoutSeparator='true'
    label='Annotation Content'
    note='Content to display when the annotation is clicked'
/>
