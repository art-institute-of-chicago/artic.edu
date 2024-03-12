<nav class="g-header__nav-secondary" aria-label="secondary">
    <h2 class="sr-only" id="h-nav-secondary-header">Secondary Navigation</h2>
    <ul class="f-secondary" aria-labelledby="h-nav-secondary-header" role="menubar">
        @include('partials._navigation-list', [
            'role' => 'secondary',
            'list' => $secondaryNav,
            'eventCategory' => 'top-nav',
        ])
    </ul>
</nav>
