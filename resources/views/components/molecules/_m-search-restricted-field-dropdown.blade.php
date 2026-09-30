<div class="m-search-field-dropdown dropdown" data-behavior="searchFieldDropdown">
    <h2 class="dropdown__trigger">
        <button class="button f-secondary" aria-expanded="false">{{ $prompt }}<svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></button>
    </h2>
    <ul class="dropdown__list f-secondary" data-dropdown-list>
        @foreach ($options as $option)
            <li class="{{ $option['active'] ? 's-active' : '' }}" data-search-value="{{ $option['value'] }}">
                <a href="#">{{ $option['label'] }}</a>
            </li>
        @endforeach
    </ul>
</div>
