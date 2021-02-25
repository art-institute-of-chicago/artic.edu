@extends('layouts.app')

@section('content')

<article class="o-article">
    <div class="o-article__body o-blocks">
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
