{{--
  -- There are a few things happening here that may be worth refactoring at some point:
  --   1. If there are more than one $links, they will be output in a <ul>. If there is
  --      only one it will be put in a <span>. This is to reduce the redundant list
  --      that a screenreader would add functionality to.
  --   2. Add an aria-labelledby to the list of links that points to the heading. We do
  --      our best to come up with an ID that will be unique to the DOM so other templates
  --      do not have to pass in as much information. But it adds a repeated inline
  --      conditional which is not very DRY.
  --}}
<div class="m-title-bar {{ $variation ?? '' }}"{!! isset($id) ? ' id="'.$id.'"' : '' !!}>
  <h2 class="title {{ $titleFont ?? 'f-module-title-2' }}" id="{!! isset($id) ? 't-' .$id : 't-' .str_slug($slot) !!}">{{ $slot }}</h2>
  @if (isset($links) and $links)
  <{!! count($links) > 1 ? 'ul' : 'span' !!} class="m-title-bar__links" aria-labelledby="{!! isset($id) ? 't-' .$id : 't-' .str_slug($slot) !!}">
    @foreach ($links as $link)
    {!! count($links) > 1 ? '<li>' : '<span>' !!}
        @if (isset($link['href']))
        <a href="{{ $link['href'] }}" class="f-link"{!! (isset($link['dataAttributes'])) ? ' '.$link['dataAttributes'] : '' !!}{!! (isset($link['gtmAttributes'])) ? ' '.$link['gtmAttributes'].'' : '' !!}>
            {!! $link['label'] ?? '' !!}{!! (!isset($link['dataAttributes'])) ? '<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>' : '' !!}
        </a>
        @else
            <span class="f-secondary">{!! $link['label'] ?? '' !!}</span>
        @endif
    {!! count($links) > 1 ? '</li>' : '</span>' !!}
    @endforeach
  {!! count($links) > 1 ? '</ul>' : '</span>' !!}
  @endif
</div>
