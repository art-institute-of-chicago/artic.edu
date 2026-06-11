@twillBlockTitle('Explorer Annotation')
@twillBlockIcon('info')
@twillBlockTitleField('label')

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

@if (auth()->user()->role->id == \App\Enums\UserRole::Admin->value ||
     auth()->user()->role->id == \App\Enums\UserRole::XDPublisher->value)
    <hr>
    <h2 style="margin-top: 2rem; margin-bottom: 1rem;">Developer Settings</h2>

    <x-twill::formColumns>
        <x-slot name="left">

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
        </x-slot>

        <x-slot name="right">
            <x-twill::input
                name='annotationZoom'
                label='Zoom Distance'
                placeholder="auto"
                note="Camera distance to annotation"
            />

            <x-twill::checkbox
                name='showLabel'
                label='Show Label'
            />
            <x-twill::checkbox
                name='sizeAttenuation'
                label='Fixed Size (no perspective scaling)'
                default="true"
            />
        </x-slot>
    </x-twill::formColumns>
@endif

@php
$blocks = BlockHelpers::getBlocksForEditor([
    'explorer_annotation_overlay_block',
]);
@endphp

<x-twill::block-editor
    name='annotation_block_blocks'
    :blocks='$blocks'
    withoutSeparator='true'
    label='Annotation Content'
    note='Content to display when the annotation is clicked'
/>
