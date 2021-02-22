@extends('layouts.app')

@section('content')

    <article class="o-article o-article--video">

        <div class="o-article__primary-actions o-article__primary-actions--video">
            @component('components.atoms._title')
                @slot('tag','p')
                @slot('font', 'f-tag-2')
                Mirador Kiosk
            @endcomponent

            @component('components.molecules._m-article-actions')
                @slot('articleType', 'video')
            @endcomponent
        </div>

        @component('components.molecules._m-article-header')
            @slot('title', $item->present()->title)
            @slot('formattedDate', $item->present()->date)
        @endcomponent

        <div class="o-article__body o-blocks">
            @component('components.molecules._m-media')
                @slot('variation', 'o-blocks__block')
                @slot('item', [
                    'type' => 'miradorKiosk',
                    'size' => 'l',
                    'media' => [
                        'miradorManifest' => $item->getMiradorManifest(),
                    ],
                    'default_view' => $item->getMiradorView(),
                    'fullscreen' => false,
                ])
            @endcomponent
        </div>

    </article>

@endsection
