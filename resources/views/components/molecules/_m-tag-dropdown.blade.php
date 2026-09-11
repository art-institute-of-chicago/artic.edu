@if (isset($tags) && count($tags) > 0)
<div class="m-tag-dropdown" data-behavior="dropdown" tabindex="0">
    <h2 class="m-tag-dropdown__heading f-module-title-2">Explore More</h2>
    <div class="dropdown__trigger">
        <button class="button f-link" aria-expanded="false" type="button">All Tags<svg class="icon--plus"><use xlink:href="#icon--plus" /></svg><svg class="icon--minus"><use xlink:href="#icon--minus" /></svg></button>
    </div>
    <ul class="m-tag-dropdown__list">
        @foreach ($tags as $tag)
            <li>
                <a class="tag f-tag" href="{{ $tag->url }}">{{ $tag->label }}</a>
            </li>
        @endforeach
    </ul>
</div>
@endif
