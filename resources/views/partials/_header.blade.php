@php
    $_hours = [
        'closure' => app('closureservice')->getClosure(),
    ];
    $hasClosure = isset($_hours['closure']);
    $isPreview = config('aic.is_preview_mode');
    $notification = $isPreview
        ? 'This a preview of unpublished content! Take care when sharing this link.'
        : ($_hours['closure']?->present()->closureCopy ?? '');
@endphp
<header class="g-header">
    <a href="#content" class="skip-nav f-body">Skip to Content</a>
    @if ($hasClosure || $isPreview)
    <div
        class="m-notification m-notification--header"
        data-behavior="notification"{!! $hasClosure ? ' data-notification-hash="' . md5($_hours['closure']) . '"' : '' !!}
    >
        <div class="m-notification--header__inner">
            <p class="m-notification__text f-secondary">
                <svg class="icon--info" aria-hidden="true">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--info"></use>
                </svg>{!! $notification !!}
            </p>
            @if (!$isPreview)
                <button
                    class="m-notification__close"
                    data-notification-closer=""
                    data-expires="1440"
                >
                    <svg class="icon--close" aria-title="Close message">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--close"></use>
                    </svg>
                </button>
            @endif
        </div>
    </div>
    @endif
    <div class="g-header__inner">
        @include('partials._nav-primary')
        @include('partials._nav-secondary')
        <button
            class="g-header__menu-link f-secondary"
            data-behavior="openNavMobile"
            aria-label="Show menu"
        >
            Menu<svg class="icon--menu--24" aria-hidden="true"><use xlink:href="#icon--menu--24" /></svg>
        </button>
    </div>
</header>

<div class="print-header">
    <div class="logo">
        {{-- Rather than using CSS to display SVGs, Prince XML requires the HTML to be inline --}}
        @php
            include base_path('frontend/icons/logo--outline--92.svg')
        @endphp
    </div>
</div>
