@php
    $blocks = BlockHelpers::getBlocksForEditor([
        '3d_model',
        'accordion',
        'hr',
        'image',
        'layout_block',
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

    // Values now reflect actual CSS units
    $spacingOptions = [
        ['label' => 'None', 'value' => '0'],
        ['label' => 'XS (0.25rem)', 'value' => '0.25rem'],
        ['label' => 'SM (0.5rem)', 'value' => '0.5rem'],
        ['label' => 'MD (0.75rem)', 'value' => '0.75rem'],
        ['label' => 'LG (1rem)', 'value' => '1rem'],
        ['label' => 'XL (1.5rem)', 'value' => '1.5rem'],
        ['label' => '2XL (2rem)', 'value' => '2rem'],
        ['label' => '3XL (3rem)', 'value' => '3rem'],
        ['label' => '4XL (4rem)', 'value' => '4rem'],
    ];
@endphp

@twillBlockTitle('Layout Block')
@twillBlockIcon('image')

<x-twill::formColumns>
    <x-slot name="left">
        <x-twill::select
            name='layout_type'
            label='Layout Type'
            default='default'
            :options="[
                ['label' => 'Default', 'value' => 'default'],
                ['label' => '2 Columns', 'value' => 'repeat(2, 1fr)'],
                ['label' => '3 Columns', 'value' => 'repeat(3, 1fr)'],
                ['label' => '4 Columns', 'value' => 'repeat(4, 1fr)'],
            ]"
        />

        <x-twill::select
            name='display'
            label='Display Type'
            default='flex'
            :options="[
                ['label' => 'Flex', 'value' => 'flex'],
                ['label' => 'Grid', 'value' => 'grid'],
                ['label' => 'Block', 'value' => 'block'],
                ['label' => 'Inline Block', 'value' => 'inline-block'],
            ]"
        />

        <x-twill::select
            name='gap'
            label='Gap Between Items'
            default='1rem'
            :options="$spacingOptions"
        />
    </x-slot>

    <x-slot name="right">
        <x-twill::input name='custom_id' label='Custom HTML ID' />
        <x-twill::input name='custom_class' label='Custom CSS Classes' />
        <x-twill::formConnectedFields
            field-name='layout_type'
            field-values="default"
            :renderForBlocks='true'
            :keepAlive='true'
        >
            <x-twill::input placeholder="50%" name='width' label='Custom width percentage' />

        </x-twill::formConnectedFields>
    </x-slot>
</x-twill::formColumns>

<x-twill::formConnectedFields fieldName='display' fieldValues="flex" :renderForBlocks='true'>
    <x-twill::formColumns>
        <x-slot name="left">
            <x-twill::select
                name='flex_direction'
                label='Flex Direction'
                default='row'
                :options="[
                    ['label' => 'Row', 'value' => 'row'],
                    ['label' => 'Row Reverse', 'value' => 'row-reverse'],
                    ['label' => 'Column', 'value' => 'column'],
                    ['label' => 'Column Reverse', 'value' => 'column-reverse'],
                ]"
            />

            <x-twill::select
                name='justify_content'
                label='Justify Content (Horizontal)'
                default='flex-start'
                :options="[
                    ['label' => 'Start', 'value' => 'flex-start'],
                    ['label' => 'Center', 'value' => 'center'],
                    ['label' => 'End', 'value' => 'flex-end'],
                    ['label' => 'Space Between', 'value' => 'space-between'],
                    ['label' => 'Space Around', 'value' => 'space-around'],
                    ['label' => 'Space Evenly', 'value' => 'space-evenly'],
                ]"
            />
        </x-slot>

        <x-slot name="right">
            <x-twill::select
                name='align_items'
                label='Align Items (Vertical)'
                default='flex-start'
                :options="[
                    ['label' => 'Start', 'value' => 'flex-start'],
                    ['label' => 'Center', 'value' => 'center'],
                    ['label' => 'End', 'value' => 'flex-end'],
                    ['label' => 'Stretch', 'value' => 'stretch'],
                    ['label' => 'Baseline', 'value' => 'baseline'],
                ]"
            />

            <x-twill::checkbox
                name='flex_wrap'
                label='Enable Flex Wrap'
                default="0"
            />
        </x-slot>
    </x-twill::formColumns>
</x-twill::formConnectedFields>

<x-twill::formColumns>
    <x-slot name="left">
        <x-twill::select
            name='padding_top'
            label='Padding Top'
            default='0'
            :options="$spacingOptions"
        />

        <x-twill::select
            name='padding_bottom'
            label='Padding Bottom'
            default='0'
            :options="$spacingOptions"
        />

        <x-twill::select
            name='padding_left'
            label='Padding Left'
            default='0'
            :options="$spacingOptions"
        />

        <x-twill::select
            name='padding_right'
            label='Padding Right'
            default='0'
            :options="$spacingOptions"
        />
    </x-slot>

    <x-slot name="right">
        <x-twill::select
            name='margin_top'
            label='Margin Top'
            default='0'
            :options="$spacingOptions"
        />

        <x-twill::select
            name='margin_bottom'
            label='Margin Bottom'
            default='0'
            :options="$spacingOptions"
        />

        <x-twill::select
            name='margin_left'
            label='Margin Left'
            default='0'
            :options="$spacingOptions"
        />

        <x-twill::select
            name='margin_right'
            label='Margin Right'
            default='0'
            :options="$spacingOptions"
        />
    </x-slot>
</x-twill::formColumns>

<x-twill::block-editor
    name='layout_block_blocks'
    :blocks="$blocks"
/>
