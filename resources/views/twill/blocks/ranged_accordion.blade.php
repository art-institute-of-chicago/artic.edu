@php
    $blocks = BlockHelpers::getBlocksForEditor([
        '360_embed',
        '360_modal',
        '3d_embed',
        '3d_model',
        '3d_tour',
        'ranged_accordion',
        'artwork',
        'audio_player',
        'button',
        'citation',
        'digital_label',
        'gallery_new',
        'hr',
        'image',
        'image_slider',
        'layered_image_viewer',
        'links-bar',
        'list',
        'media_embed',
        'membership_banner',
        'mirador_embed',
        'mirador_modal',
        'mobile_app',
        'paragraph',
        'quote',
        'split_block',
        'table',
        'tombstone',
        'tour_stop',
        'video',
    ]);
@endphp

@twillBlockTitle('Ranged Accordion')
@twillBlockIcon('text')
    <x-twill::input
        name='title'
        label='Title'
    />

    <x-twill::block-editor name="accordion_items"
        :blocks='$blocks'
    />
