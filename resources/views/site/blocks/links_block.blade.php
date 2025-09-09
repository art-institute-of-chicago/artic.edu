@php

$links = $block->children;

@endphp

<div class="links_block">
  <ul>
      @foreach($links as $link)
          <li class="m-links-bar__item"><a class="m-links-bar__item-trigger f-link" href="{!! Str::lower($link->content['url']) !!}">{!! Str::ucfirst(($link->content['label'])) !!}</a></li>
      @endforeach
  </ul>
</div>