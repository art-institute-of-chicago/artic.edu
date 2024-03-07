<nav tabindex="0" aria-label="primary">
  <a class="g-header__logo" aria-label="Art Institute of Chicago" href="/">
    <svg aria-hidden="true">
      <use xlink:href="#icon--logo--outline--80" />
      <use xlink:href="#icon--logo--outline--88" />
      <use xlink:href="#icon--logo--outline--92" />
    </svg>
  </a>
  <div class="g-header__nav-primary">
    <h2 class="sr-only" id="h-nav-primary-header">Primary Navigation</h2>
    <ul class="f-main-nav" aria-labelledby="h-nav-primary-header">
      @foreach ($primaryNav as $level_0)
        <li @if(isset($level_0['class'])) class="{{ $level_0['class'] }}"@endif>
          <a
            id="h-nav-primary-level-0-{{ Str::slug($level_0['name']) }}"
            href="{{ $level_0['url'] ?? '#' }}"
            data-gtm-event-category="top-nav"
            data-gtm-event="{{ Str::slug($level_0['name']) }}"
            @if(isset($level_0['children'])) data-nav-trigger @endif
            @if(isset($level_0['url']) && Request::url() == str(url($level_0['url']))->before('#'))
              aria-current="page"
            @endif
          >
            {!! $level_0['name'] !!}
            @if (array_key_exists('children', $level_0))
              <svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
            @endif
          </a>
          @if(isset($level_0['image']))
            <img src="{{ $level_0['image'] }}">
          @endif
          @if(isset($level_0['description']))
            <div class="description">
              {!! $level_0['description'] !!}
            </div>
          @endif
          @if (array_key_exists('children', $level_0))
            <div class="sub">
              <ul aria-labelledby="h-nav-primary-level-0-{{ Str::slug($level_0['name']) }}">
                @foreach ($level_0['children'] as $level_1)
                  <li @if(isset($level_1['class']))class="{{ $level_1['class'] }}"@endif>
                    <a
                      id="h-nav-primary-level-1-{{ Str::slug($level_1['name']) }}"
                      href="{{ $level_1['url'] ?? '#' }}"
                      data-gtm-event-category="top-nav"
                      data-gtm-event="{{ Str::slug($level_1['name']) }}"
                      @if(isset($level_1['children'])) data-nav-trigger @endif
                      @if(isset($level_1['url']) && Request::url() == str(url($level_1['url']))->before('#'))
                        aria-current="page"
                      @endif
                    >
                      {!! $level_1['name'] !!}
                      @if (array_key_exists('children', $level_1))
                        <svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
                      @endif
                    </a>
                    {{-- @if (array_key_exists('children', $level_1))
                        <ul aria-labelledby="h-nav-primary-level-1-{{ Str::slug($level_1['name']) }}">
                          @foreach ($level_1['children'] as $level_2)
                            <li @if(isset($level_2['class']))class="{{ $level_2['class'] }}"@endif>
                              <a
                                id="h-nav-primary-level-2-{{ Str::slug($level_2['name']) }}"
                                href="{{ $level_2['url'] ?? '#' }}"
                                data-gtm-event-category="top-nav"
                                data-gtm-event="{{ Str::slug($level_2['name']) }}"
                                @if(isset($level_2['children'])) data-nav-trigger @endif
                                @if(isset($level_2['url']) && Request::url() == str(url($level_2['url']))->before('#'))
                                  aria-current="page"
                                @endif
                              >
                                {!! $level_2['name'] !!}
                              </a>
                            </li>
                          @endforeach
                        </ul>
                    @endif --}}
                  </li>
                @endforeach
              </ul>
            </div>
          @endif
        </li>
      @endforeach
      <li class="u-show@small+">
        <button id="global-search-icon" data-behavior="globalSearchOpen" aria-label="Search site">
          <svg class="icon--search--24" aria-hidden="true">
            <use xlink:href="#icon--search--24" />
          </svg>
        </button>
      </li>
    </ul>
  </div>
</nav>
