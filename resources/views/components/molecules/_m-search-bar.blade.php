<form class="m-search-bar{{ (isset($variation)) ? ' '.$variation : '' }}" action="{{ $action ?? '' }}">
    <label for="{{ $name ?? '' }}">Search</label>
    <input class="f-secondary{{ (isset($value) and $value and isset($clearLink) and $clearLink) ? ' s-populated' : '' }}" id="{{ $name ?? '' }}" name="{{ $name ?? '' }}" placeholder="{{ $placeholder ?? '' }}" type="text" value="{{ $value ?? '' }}">
    <button class="m-search-bar__submit" type="submit"><svg aria-label="Search" class="icon--search--24"><use xlink:href="#icon--search--24" /></svg></button>
    @if (isset($clearLink))
    <a class="m-search-bar__clear" href="{{ $clearLink }}"><svg aria-label="Clear search" class="icon--close"><use xlink:href="#icon--close" /></svg></a>
    @endif
</form>
