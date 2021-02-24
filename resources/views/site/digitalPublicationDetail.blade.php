@extends('layouts.app')

@section('content')

<article class="o-article">
    @if (isset($item->sponsor_display))
        <hr>

        <div class="o-blocks">
            <h2>Sponsors</h2>

            {!! $item->sponsor_display !!}
        </div>
    @endif
</article>

@endsection
