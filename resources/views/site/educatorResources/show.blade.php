@extends('layouts.app')

@section('content')

<article class="o-educator-resource">

    @component('components.molecules._m-article-header')
        @slot('headerType', 'generic')
        @slot('breadcrumb', $breadcrumb ?? null)
    @endcomponent

    <div class="o-educator-resource__body">
      <h1 class="title f-headline">{!! $item->present()->title !!}</h1>
      <div class="intro">{!! $item->present()->listing_description !!}</div>

        @if ((request()->getDefaultLocale() == 'en' && empty(request('locale'))) && $item->file('pdf', 'en'))
          <div class="m-show__secondary-action__links">
              <a class="btn f-buttons f-tertiary" href="{{$item->file('pdf', 'en')}}" download="{{Str::slug($item->title) . '.pdf'}}">Download (.pdf)</a>
              <a class="f-link f-tertiary" target="_blank" rel="noopener noreferrer" href="{{$item->file('pdf', 'en')}}">Preview <svg aria-hidden="true" class="icon--new-window"><use xlink:href="#icon--new-window" /></svg></a>
              <a class="f-link" data-behavior="sharePage">Share <svg class="icon--share--24"><use xlink:href="#icon--share--24"></use></svg></a>
          </div>
        @endif
        @if ((request('locale') == 'es' || request()->getDefaultLocale() == 'es') && $item->file('pdf', 'es'))
          <div class="m-show__secondary-action__links">
            <a class="btn f-buttons f-tertiary" href="{{$item->file('pdf', 'es')}}" download="{{Str::slug($item->title) . '.pdf'}}">Download (.pdf)</a>
            <a class="f-link" target="_blank" rel="noopener noreferrer" href="{{$item->file('pdf', 'es')}}">Preview <svg aria-hidden="true" class="icon--new-window"><use xlink:href="#icon--new-window" /></svg></a>
            <a class="f-link" data-behavior="sharePage">Share <svg class="icon--share--24"><use xlink:href="#icon--share--24"></use></svg></a>
          </div>
        @endif

      <div class="o-blocks">
        {!! $item->renderBlocks() !!}
      </div>

    </div>

</article>

@endsection
