<ul id="shorts-list">
    @foreach ($items as $index => $item)
        <li
            id="{{ $item->id }}"
            @class(['short-video'])
            {!! $dataAttributes[$item->id] !!}
        >
            @component('components.molecules._m-media')
                @slot('variation', 'variation--short')
                @slot('item', [
                    'type' => 'image',
                    'size' => 'l',
                    'media' => ImageHelpers::youtubeItemAsArray($item),
                    'hideCaption' => true,
                    'fullscreen' => false,
                ])
            @endcomponent
        </li>
    @endforeach
</ul>
