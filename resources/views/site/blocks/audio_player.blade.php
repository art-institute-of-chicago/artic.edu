@php
    use A17\Twill\Services\FileLibrary\FileService;

    $audioFile = $block->fileObject('audio_file');
@endphp

@if (isset($audioFile))
    @component('components.molecules._m-listing----sound')
        @slot('item', (object) [
            'title' => $block->input('title_display'),
            'href' => FileService::getUrl($audioFile->uuid),
            'transcript' => $block->input('transcript'),
            'subtitle' => null,
        ])
    @endcomponent
@endif
