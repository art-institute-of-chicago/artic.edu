<form class="m-search-bar{{ (isset($variation)) ? ' '.$variation : '' }}" action="{{ $action ?? '' }}">
    <label for="{{ $name ?? '' }}">Search</label>
    <input class="f-secondary" id="{{ $name ?? '' }}" name="{{ $name ?? '' }}" placeholder="{{ $placeholder ?? '' }}" type="text">
    <button><svg class="icon--search--24"><use xlink:href="#icon--search--24" /></svg></button>
</form>
