<div class="m-results-title">
    @component('components.atoms._hr')
    @endcomponent
    @component('components.atoms._title')
        @slot('tag','h2')
        @slot('font', 'f-list-3')
    {!! $subtitle !!}
    @endcomponent

    @if (isset($links) and $links)
    <ul class="m-results-title__links">
    @foreach ($links as $link)
    <li>
        @if (isset($link['href']))
        <a href="{{ $link['href'] }}" class="f-link"{!! (isset($link['dataAttributes'])) ? ' '.$link['dataAttributes'] : '' !!}{!! (isset($link['gtmAttributes'])) ? ' '.$link['gtmAttributes'].'' : '' !!}>
            {!! $link['label'] ?? '' !!}{!! (!isset($link['dataAttributes'])) ? '&nbsp;&nbsp;&rsaquo;' : '' !!}
        </a>
        @else
            <span class="f-secondary">{!! $link['label'] ?? '' !!}</span>
        @endif
    </li>
    @endforeach
  </ul>
  @endif
</div>
