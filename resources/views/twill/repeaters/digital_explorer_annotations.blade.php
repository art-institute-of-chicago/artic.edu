@twillRepeaterTitle('Annotation')
@twillRepeaterTrigger('Add Annotation')
@twillRepeaterComponent('a17-block-digital_explorer_annotation')

    <x-twill::medias
      name='icon'
      label='Icon'
      note='Replace the default icon'
    />

    <x-twill::input
      name='settings.annotationTarget'
      label='Annotation target ID'
      note='Reference the ID of a model or element to target'
    />

    <x-twill::input
      name='settings.position'
      label='Position'
    />

    <x-twill::input
      name='settings.rotation'
      label='Rotation'
    />

    <x-twill::input
      name='settings.scale'
      label='Scale'
    />

    <x-twill::input
      name='settings.color'
      label='Icon color'
      note='Only applies if icon is not set'
    />

<x-twill::multi-select
    name='settings.annotationSettings'
    label='Scene Settings'
    :unpack='true'
    :options="[
      [
        'value' => 'showLabel',
        'label' => 'Show Label'
      ],
      [
        'value' => 'sizeAttenuation',
        'label' => 'Fixed Size'
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
    ]);
@endphp

<x-twill::block-editor
  name='block'
  :blocks='$blocks'
  withoutSeparator='true'
/>