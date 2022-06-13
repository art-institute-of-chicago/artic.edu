@php
  $showHourSummary = !empty($hour) && trim(strip_tags($hour->summary));
@endphp

<footer id="footer" class="g-footer">
  <a href="#a17" class="g-footer__top-link arrow-link arrow-link--up f-small-caps">
    Back to top
    <span>
      <svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
    </span>
  </a>

  <div class="g-footer__inner">
    <h2 class="sr-only" id="h-footer-grid">Footer content</h2>
    <ul class="g-footer__grid {!! $showHourSummary ? 'g-footer__grid--hours' : '' !!}" aria-labelledby="h-footer-grid">
      <li>
        @include('partials._footer--primary')
      </li>

      @if (!$showHourSummary)
        <li class="u-hide@small-">
          @include('partials._footer--locations')
        </li>
      @else
        <li>
          <div class="g-footer__grid__group">
            <h3 class="g-footer__hours-heading" id="h-footer-nav-hours"><svg aria-hidden="true" class="icon--clock"><use xlink:href="#icon--clock" /></svg>Hours</h3>
            <div class="g-footer__link-list g-footer__link-list--hours">
            {!! $hour->summary !!}
            </div>
          </div>

          <div class="g-footer__grid__group u-hide@small-">
            @include('partials._footer--locations')
          </div>
        </li>
      @endif

      <li class="u-hide@small-">
        <div class="g-footer__grid__group">
          <h3 class="f-list-6" id="h-footer-about-us"><a href="{{ $_pages['about-us'] }}">About us<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></a></h3>

          <ul class="g-footer__link-list" aria-labelledby="h-footer-about-us">
            <li><a href="{{ $_pages['about-us-identity-and-history'] }}">Identity and History</a></li>
            <li><a href="{{ $_pages['about-us-leadership'] }}">Leadership</a></li>
            <li><a href="{{ $_pages['about-us-departments'] }}">Departments</a></li>
            <li><a href="{{ $_pages['about-us-financial-reporting'] }}">Financial Reporting</a></li>
          </ul>
        </div>

        <div class="g-footer__grid__group">
          <h3 class="f-list-6" id="h-footer-support-us"><a href="{{ $_pages['support-us'] }}">Support us</a></h3>

          <ul class="g-footer__link-list" aria-labelledby="h-footer-support-us">
            <li><a href="{{ $_pages['support-us-membership'] }}">Membership</a></li>
            <li><a href="{{ $_pages['support-us-luminary'] }}">Luminary</a></li>
            <li><a href="{{ $_pages['support-us-planned-giving'] }}">Planned Giving</a></li>
            <li><a href="{{ $_pages['support-us-corporate-sponsorship'] }}">Corporate Sponsorship</a></li>
          </ul>
        </div>
      </li>

      <li>
        <div class="g-footer__grid__group u-hide@small-">
          <h3 class="f-list-6" id="h-footer-learn-with-us"><a href="{{ $_pages['learn'] }}">Learn with us<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></a></h3>

          <ul class="g-footer__link-list" aria-labelledby="h-footer-learn-with-us">
            <li><a href="{{ $_pages['learn-families'] }}">Families</a></li>
            <li><a href="{{ $_pages['learn-teens'] }}">Teens</a></li>
            <li><a href="{{ $_pages['learn-educators'] }}">Educators</a></li>
            <li><a href="{{ $_pages['learn-adults'] }}">Adults</a></li>
          </ul>
        </div>

        <div class="g-footer__grid__group">
          <h3 class="f-list-6" id="h-footer-follow-us">Follow us</h3>

          <ul class="g-footer__link-list" aria-labelledby="h-footer-follow-us">
            <li><a href="{{ $_pages['follow-facebook'] }}" data-gtm-event="facebook" data-gtm-event-category="follow" target="_blank">Facebook</a></li>
            <li><a href="{{ $_pages['follow-twitter'] }}" data-gtm-event="twitter" data-gtm-event-category="follow" target="_blank">Twitter</a></li>
            <li><a href="{{ $_pages['follow-instagram'] }}" data-gtm-event="instagram" data-gtm-event-category="follow" target="_blank">Instagram</a></li>
            <li><a href="{{ $_pages['follow-youtube'] }}" data-gtm-event="youtube" data-gtm-event-category="follow" target="_blank">YouTube</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>

  <h2 class="sr-only" id="h-mobile-footer-links">Footer Links</h2>
  <ul class="g-footer__legals f-secondary" aria-labelledby="h-mobile-footer-links">
    <li><a href="{{ $_pages['legal-press'] }}">Press</a></li>
    <li><a href="{{ $_pages['legal-employment'] }}">Careers</a></li>
    <li><a href="{{ $_pages['legal-contact'] }}">Contact</a></li>
    <li><a href="{{ $_pages['legal-venue-rental'] }}">Venue Rental</a></li>
    <li><a href="{{ $_pages['legal-image-licensing'] }}">Image Licensing</a></li>
    <li><a href="{{ $_pages['legal-saic'] }}">SAIC</a></li>
    <li><a href="{{ $_pages['legal-terms'] }}">Terms</a></li>
  </ul>
</footer>
<a class="top-link" href="#a17" aria-label="top of page">
  <svg class="icon--arrow" aria-hidden="true">
    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow" />
  </svg>
</a>
