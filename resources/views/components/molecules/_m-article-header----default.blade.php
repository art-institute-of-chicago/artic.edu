<{{ $tag or 'header' }} class="m-article-header{{ (isset($variation)) ? ' '.$variation : '' }}">
  @if (isset($title))
    @component('components.atoms._title')
        @slot('tag','h1')
        @slot('font','f-headline')
        {{ $title }}
    @endcomponent
  @endif
  @if (isset($date))
    @component('components.atoms._date')
        @slot('tag','p')
        {{ $date }}
    @endcomponent
  @endif
  @if (isset($type))
    @component('components.atoms._type')
        @slot('tag','p')
        {{ $type }}
    @endcomponent
  @endif
</{{ $tag or 'header' }}>
