<form class="m-search-bar{{ (isset($variation)) ? ' '.$variation : '' }}" action="{{ $action ?? '' }}" data-behavior="autocomplete">
    <div class="m-search-bar__inner">
        <label for="{{ $name ?? '' }}">Search</label>
        <input class="f-secondary{{ (isset($value) and $value and isset($clearLink) and $clearLink) ? ' s-populated' : '' }}" id="{{ $name ?? '' }}" name="{{ $name ?? '' }}" placeholder="{{ $placeholder ?? '' }}" type="text" value="{{ $value ?? '' }}">
        <button class="m-search-bar__submit" type="submit"><svg aria-label="Search" class="icon--search--24"><use xlink:href="#icon--search--24" /></svg></button>
        @if (isset($clearLink))
        <a class="m-search-bar__clear" href="{{ $clearLink }}"><svg aria-label="Clear search" class="icon--close"><use xlink:href="#icon--close" /></svg></a>
        @endif

        <span class="m-search-bar__loader"></span>
    </div>

    <div data-autocomplete>
    </div>
</form>
