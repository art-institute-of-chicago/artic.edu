@twillBlockTitle('Explorer Annotation')
@twillBlockIcon('info')

    <x-twill::medias
      name='icon'
      label='Icon'
      note='Replace the default icon'
    />

    <x-twill::input
      name='color'
      label='Icon color'
      note='Only applies if icon is not set'
      placeholder='#FFFFFF'
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
    />

    <x-twill::input
      name="rotation"
      label="Rotation"
      placeholder="[0, 0, 0]"
    />

    <x-twill::input
      name='scale'
      label='Scale'
      placeholder="1.0"
    />

<x-twill::multi-select
    name='annotationSettings'
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