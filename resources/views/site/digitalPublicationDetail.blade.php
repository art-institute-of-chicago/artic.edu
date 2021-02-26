@extends('layouts.app')

@section('content')

<article class="o-article">
    <div class="o-article__body o-blocks">
        @if ($item->welcome_note_display && $welcomeNote)
            <div class="o-issue__intro">
                @component('components.organisms._o-editors-note----digital-publication')
                    @slot('description', $item->welcome_note_display)
                    @slot('articleLink', $welcomeNote->present()->getSectionUrl($item))
                @endcomponent
            </div>
        @endif

        @if (isset($item->sponsor_display))
            @component('components.molecules._m-title-bar', [
                'variation' => 'm-title-bar--compact m-title-bar--light',
            ])
                Sponsors
            @endcomponent

            {!! $item->sponsor_display !!}
        @endif
    </div>
</article>

@endsection
