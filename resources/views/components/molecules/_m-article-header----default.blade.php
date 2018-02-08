<{{ $tag or 'header' }} class="m-article-header{{ (isset($variation)) ? ' '.$variation : '' }}">
  @if (isset($title))
    @component('components.atoms._title')
        @slot('tag','h1')
        @slot('font', (isset($editorial) && $editorial) ? 'f-headline-editorial' : 'f-headline')
        {{ $title }}
    @endcomponent
  @endif
  @if (isset($dateStart) and isset($dateEnd))
    @component('components.atoms._date')
        {{ date('M j, Y', intval($dateStart)) }} &ndash; {{ date('M j, Y', intval($dateEnd)) }}
    @endcomponent
  @elseif (!empty($date))
    @component('components.atoms._date')
        @slot('tag','p')
        {{ $date->format('F j, Y') }}
        {{-- {{ date('F j, Y', intval($date)) }} --}}
    @endcomponent
  @endif
  @if (isset($type))
    @component('components.atoms._type')
        @slot('tag','p')
        {{ $type }}
    @endcomponent
  @endif
</{{ $tag or 'header' }}>
