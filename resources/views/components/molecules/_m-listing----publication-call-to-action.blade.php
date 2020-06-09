<{{ $tag ?? 'li' }} class="m-listing m-listing--publication m-listing--publication-call-to-action m-listing--w-meta-bottom{{ (isset($variation)) ? ' '.$variation : '' }}">
  <a href="{{ $href ?? '' }}" class="m-listing__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
    <span class="m-listing__meta">
        @component('components.atoms._type')
            {!! $type !!}
        @endcomponent
        <br>
        @component('components.atoms._title')
            @slot('font', 'f-headline')
            @slot('title_display', $title_display)
            @slot('itemprop', 'name')
        @endcomponent
        <br>
        @if ($link_text)
            <span class="m-listing__meta-bottom">
                <span class="f-module-title-2">{{ $link_text }}</span>
            </span>
        @endif
    </span>
  </a>
</{{ $tag ?? 'li' }}>
