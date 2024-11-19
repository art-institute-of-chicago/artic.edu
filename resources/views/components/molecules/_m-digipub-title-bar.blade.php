<?php
use Illuminate\Support\Str;
?>

<div class="m-title-bar m-digipub-title-bar"{!! isset($id) ? ' id="'.$id.'"' : '' !!}>
  @if ($item->children && count($item->children) >= 1)
  <a href="{{ $item->present()->url }}" class="f-link">
    <h2 class="title {{ $titleFont ?? 'f-list-2' }}" id="{{ isset($id) ? $id : Str::snake(strip_tags($item->present()->title), '-') }}">{!! $item->present()->title !!}</h2>
      <span class="link">{{ 'View all ' . $item->present()->articleType }}
        <span aria-hidden="true">&rsaquo;</span>
      </span>
    </a>
  @else
    <a href="{{ $item->present()->url }}" class="f-link">
      <h2 class="title {{ $titleFont ?? 'f-list-2' }}" id="{{ isset($id) ? $id : Str::snake(strip_tags($item->present()->title ), '-') }}">{!! $item->present()->title  !!}</h2>
    </a>
  @endif

</div>
