@php
  $files = $item->getLocalizedFiles();
@endphp

@extends('layouts.app')

@section('content')

<article class="o-educator-resource">

    {{-- @component('components.molecules._m-article-header')
        @slot('headerType', 'generic')
        @slot('breadcrumb', $breadcrumb ?? null)
    @endcomponent --}}

    <div class="o-educator-resource__body">
      <h1 class="title f-headline">{{$item->present()->title}}</h1>
      <p>{!! $item->present()->listing_description !!}</p>

      <div class="o-blocks">
        {!! $item->renderBlocks() !!}
      </div>

                  @if (isset($files['en']))
                <div class="m-listing__secondary-action__links">
                    <span class="f-secondary">English:</span>
                    <a class="f-link f-tertiary" href="{{$item->url}}">View</a>
                    @if (isset($files['en']) && $files['en'])
                        <a class="f-link f-tertiary" href="{{$files['en']}}" download>Download</a>
                    @endif
                </div>
            @endif
            @if ($item->hasTranslation('es'))
                <div class="m-listing__secondary-action__links">
                    <span class="f-secondary">Español:</span>
                    <a class="f-link f-tertiary" href="{{$item->getUrlAttribute('es')}}">View</a>
                    @if (isset($files['es']) && $files['es'])
                        <a class="f-link f-tertiary" href="{{$files['es']}}" download>Download</a>
                    @endif
                </div>
            @endif
    </div>

</article>

@endsection
