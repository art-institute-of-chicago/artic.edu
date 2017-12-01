<div class="m-notification{{ (isset($variation)) ? ' '.$variation : '' }}">
    @if (isset($title))
    <p class="m-notification__title f-module-title-1">
        {{ $title }}
    </p>
    @endif
    <p class="m-notification__text f-secondary">
        {{ $slot }}
    </p>
    <button class="m-notification__close"><svg class="icon--close" aria-title="Close message"><use xlink:href="#icon--close" /></svg></button>
</div>
