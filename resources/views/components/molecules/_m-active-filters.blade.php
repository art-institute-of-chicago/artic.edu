@if (isset($links) and sizeof($links) > 0)
<div class="m-active-filters">
    <ul class="m-active-filters__items" data-behavior="dragScroll">
    @foreach ($links as $link)
        <li class="m-active-filters__item">
            @component('components.atoms._tag')
                @slot('font', 'f-tag-2')
                @slot('variation', 'tag--quaternary tag--l')
                @slot('href', $link['href'])
                {{ $link['label'] }}
                <svg class="icon--close"><use xlink:href="#icon--close" /></svg>
            @endcomponent
        </li>
    @endforeach
    </ul>
    <p class="m-active-filters__clear">
        <a href="{{ $clearAllLink }}" class="f-link">Clear All</a>
    </p>
</div>
@endif
