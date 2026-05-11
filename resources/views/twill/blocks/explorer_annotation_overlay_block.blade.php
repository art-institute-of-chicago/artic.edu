@twillBlockTitle('Annotation Overlay')
@twillBlockIcon('image')

<x-twill::checkbox
    name='full_width'
    label='Full Width Toggle (for 360 embed, video, or image)'
    default="0"
/>

@php
    $leftBlocks = BlockHelpers::getBlocksForEditor([
        'image',
        'video',
        '360_embed',
    ]);

    $rightBlocks = BlockHelpers::getBlocksForEditor([
        '3d_model',
        'accordion',
        'hr',
        'image',
        'link',
        'list',
        'media_embed',
        'paragraph',
        'split_block',
        'video',
        '360_embed'
    ]);

    $fullBlocks = BlockHelpers::getBlocksForEditor([
        '360_embed',
        'video',
        'image'
    ]);
@endphp

<x-twill::formConnectedFields fieldName='full_width' :fieldValues="false" :renderForBlocks='true' :keepAlive='true'>
    <x-twill::formColumns>
        <x-slot name="left">
            <x-twill::block-editor
                name='left_block'
                label='Left Side (Limit 1)'
                :blocks="$leftBlocks"
                withoutSeparator='true'
            />
        </x-slot>

        <x-slot name="right">
            <x-twill::block-editor
                name='right_blocks'
                label='Right Side'
                :blocks="$rightBlocks"
                withoutSeparator='true'
            />
        </x-slot>
    </x-twill::formColumns>
</x-twill::formConnectedFields>

<x-twill::formConnectedFields fieldName='full_width' :fieldValues="true" :renderForBlocks='true' :keepAlive='true'>
    <x-twill::block-editor
        name='full_width_block'
        label='Full Width Content'
        :blocks="$fullBlocks"
        withoutSeparator='true'
    />
</x-twill::formConnectedFields>
