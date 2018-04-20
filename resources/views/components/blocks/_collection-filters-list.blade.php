@if (isset($filterCategory['listSearch']) and $filterCategory['listSearch'])
    <form class="m-filters__whittle-down" data-behavior="filterWhittleDown" data-filter-whittle-down-url="{{ $filterCategory['listSearchUrl'] }}">
        <label>{{$filterCategory['placeholder'] ?? 'Find Location'}}</label>
        <input type="text" class="f-secondary" placeholder="{{$filterCategory['placeholder'] ?? 'Find Location'}}">
        <button><svg class="icon--search--24"><use xlink:href="#icon--search--24" /></svg></button>
    </form>
    <ul class="m-filters__list">
@else
    <ul class="m-filters__list{{ (sizeof($filterCategory['list']) > 8) ? ' s-capped' : '' }}">
@endif
    @foreach ($filterCategory['list'] as $link)
    <li>
        <a href="{{ $link['href'] }}" class="checkbox f-secondary {{ $link['enabled'] ? 's-checked' : '' }}">
            {{ $link['label'] }} @unless(isset($link['disableCount'])) <em>({{ $link['count'] }})</em> @endunless
        </a>
    </li>
    @endforeach
</ul>
@if ( (!isset($filterCategory['listSearch']) or !$filterCategory['listSearch']) and sizeof($filterCategory['list']) > 8)
<button class="m-filters__show-more-toggle f-secondary" data-behavior="filterToggleShowMore">
    <svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
    <span>Show more</span>
</button>
@endif
