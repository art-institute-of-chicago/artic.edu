<div class="g-nav-mobile" data-behavior="navMobile" tabindex="0">
  <div class="g-nav-mobile__inner">
    <div class="g-nav-mobile__container">
      <div class="g-header">
        <div class="g-header__inner">
            <a class="g-header__logo" href="/">
              <svg aria-label="Art Institute of Chicago">
                <use xlink:href="#icon--logo--80" />
                <use xlink:href="#icon--logo--88" />
                <use xlink:href="#icon--logo--92" />
              </svg>
            </a>
            <nav class="g-header__nav-primary">
              <h2 class="sr-only" id="h-nav-secondary">Secondary Navigation</h2>
              <ul class="f-secondary" aria-labelledby="h-nav-secondary">
                <li class='u-hide@small+'><a href="{{ $_pages['buy'] }}">Buy Tickets</a></li>
                <li><a href="{{ $_pages['visit'] }}">Visit</a></li>
              </ul>
            </nav>
          </div>
        </div>

      <div class="g-nav-mobile__search" data-behavior="mobileSearch">
        <form action="/search" role="search">
          <input type="search" id="mobile_search" name="q" placeholder="Search" autocomplete="off" aria-label="Search the site" />
          <button type="submit" aria-label="Search">
            <svg aria-hidden="true" class="icon--search--24"><use xlink:href="#icon--search--24" /></svg>
          </button>
        </form>
      </div>

      <nav class="g-nav-mobile__nav-wrapper">
        <h2 class="sr-only" id="h-nav-mobile">Primary Navigation</h2>
        <ul class="g-nav-mobile__nav" aria-labelledby="h-nav-mobile">
          {{-- Nav Level 0 --}}
          @foreach ($primaryNav as $level_0)
            <li class="{{ $level_0['class'] ?? '' }}">
              <a href="{{ $level_0['url'] ?? '#' }}" {{ array_key_exists('children', $level_0) ? 'data-nav-trigger' : '' }}>
                {!! $level_0['name'] !!}

                @if (array_key_exists('children', $level_0))
                  <svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
                @endif
              </a>

              {{-- Nav Level 1 --}}
              @if (array_key_exists('children', $level_0))
                <div class="g-nav-mobile__subnav">
                  <a href="#" class="g-nav-mobile__back arrow-link arrow-link--back" data-nav-back>
                    <svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>

                    <h3 id="h-nav-mobile-sub-{{ Str::slug($level_0['name']) }}">{!! $level_0['name'] !!}</h3>
                  </a>

                  <ul aria-labelledby="h-nav-mobile-sub-{{ Str::slug($level_0['name']) }}">
                    @foreach ($level_0['children'] as $level_1)
                      <li class="{{ $level_1['class'] ?? '' }}">
                        <a href="{{ $level_1['url'] ?? '#' }}" {{ array_key_exists('children', $level_1) ? 'data-nav-trigger' : '' }}>
                          {!! $level_1['name'] !!}

                          @if (array_key_exists('children', $level_1))
                            <svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
                          @endif
                        </a>

                        {{-- Nav Level 2 --}}
                        @if (array_key_exists('children', $level_1))
                          <div class="g-nav-mobile__subnav">
                            <a href="#" class="g-nav-mobile__back arrow-link arrow-link--back" data-nav-back>
                              <svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>

                              <h4 id="h-nav-mobile-sub-sub-{{ Str::slug($level_1['name']) }}">{!! $level_1['name'] !!}</h4>
                            </a>

                            <ul aria-labelledby="h-nav-mobile-sub-sub-{{ Str::slug($level_1['name']) }}">
                              @foreach ($level_1['children'] as $level_2)
                                <li class="{{ $level_2['class'] ?? '' }}">
                                  <a href="{{ $level_2['url'] ?? '#' }}" {!! array_key_exists('children', $level_2) ? ' class="g-footer-nav__expander-trigger arrow-link arrow-link--down" data-nav-trigger' : '' !!}>
                                    <h5 id="h-nav-mobile-sub-sub-sub-{{ Str::slug($level_2['name']) }}">{!! $level_2['name'] !!}</h5>

                                    @if (array_key_exists('children', $level_2))
                                      <svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
                                    @endif
                                  </a>

                                  {{-- Nav Level 3 --}}
                                  @if (array_key_exists('children', $level_2))
                                    <div class="g-nav-mobile__expander">
                                      <ul aria-labelledby="h-nav-mobile-sub-sub-sub-{{ Str::slug($level_2['name']) }}">
                                        @foreach ($level_2['children'] as $level_3)
                                          <li><a href="{{ $level_3['url'] ?? '#' }}">{!! $level_3['name'] !!}</a></li>
                                        @endforeach
                                      </ul>
                                    </div>
                                  @endif

                                </li>
                              @endforeach
                            </ul>
                          </div>
                        @endif
                      </li>
                    @endforeach
                  </ul>
                </div>
              @endif
            </li>
          @endforeach
        </ul>

        <div class="g-nav-mobile__nav-secondary">
          <h4 class="sr-only" id="h-footer-nav-secondary">Secondary Navigation</h4>
          <ul class="g-nav-mobile__legals" aria-labelledby="h-footer-nav-secondary">
            <li><a href="{{ $_pages['legal-press'] }}">Press</a></li>
            <li><a href="{{ $_pages['legal-employment'] }}">Careers</a></li>
            <li><a href="{{ $_pages['legal-contact'] }}">Contact</a></li>
            <li><a href="{{ $_pages['legal-venue-rental'] }}">Venue Rental</a></li>
            <li><a href="{{ $_pages['legal-image-licensing'] }}">Image Licensing</a></li>
            <li><a href="{{ $_pages['legal-saic'] }}">SAIC</a></li>
            <li><a href="{{ $_pages['legal-terms'] }}">Terms</a></li>
          </ul>

          <h4 class="sr-only" id="h-footer-nav-social">Social links</h4>
          <ul class="g-nav-mobile__social" aria-labelledby="h-footer-nav-social">
            <li><a href="{{ $_pages['follow-facebook'] }}">Facebook</a></li>
            <li><a href="{{ $_pages['follow-twitter'] }}">Twitter</a></li>
            <li><a href="{{ $_pages['follow-instagram'] }}">Instagram</a></li>
            <li><a href="{{ $_pages['follow-youtube'] }}">YouTube</a></li>
          </ul>
        </div>
      </nav>

      <button class="g-nav-mobile__close" data-behavior="closeNavMobile" aria-label="Close menu"><svg aria-hidden="true" class="icon--close--24"><use xlink:href="#icon--close--24" /></svg></button>
    </div>
  </div>
</div>
