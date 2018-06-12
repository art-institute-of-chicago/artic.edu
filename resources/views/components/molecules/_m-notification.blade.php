<div class="m-notification{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="notification">
    @if (isset($title))
    <p class="m-notification__title f-module-title-1">
        {{ $title }}
    </p>
    @endif
    <p class="m-notification__text f-secondary">
        {{ $slot }}
    </p>
    <button class="m-notification__close" data-notification-closer><svg class="icon--close" aria-label="Close message"><use xlink:href="#icon--close" /></svg></button>
</div>
