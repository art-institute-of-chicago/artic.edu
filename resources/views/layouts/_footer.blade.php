@component('components.molecules._m-aside-newsletter')
    @slot('variation', 'm-aside-newsletter--wide')
@endcomponent
<footer id="footer" class="g-footer">
  <a href="#a17" class="g-footer__top-link arrow-link arrow-link--up f-small-caps">
    Back to top
    <span>
      <svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
    </span>
  </a>

  <div class="g-footer__inner">
    <ul class="g-footer__grid">
      <li>
        <a class="g-footer__logo" href="/">
          <svg aria-title="Art Institute of Chicago">
            <use xlink:href="#icon--logo--outline--92" />
          </svg>
        </a>

        <ul class="g-footer__link-list">
          <li>{{ $_hours['opening_today'] }}</li>
          <li><a href="{{ $_pages['visit'] }}">Visit</a></li>
          <li><a href="{{ $_pages['exhibitions'] }}">Exhibitions and events</a></li>
          <li><a href="{{ $_pages['collection'] }}">The collection</a></li>
        </ul>
      </li>

      <li class="u-hide@small-">
        <a href="https://www.google.co.uk/maps/place/The+Art+Institute+of+Chicago/@41.8795845,-87.625902,17z/data=!3m1!5s0x880e2ca148f260e3:0xd473c3802aaff420!4m5!3m4!1s0x880e2ca3e2d94695:0x4829f3cc9ca2d0de!8m2!3d41.8795847!4d-87.623713" target="_blank">
          <svg aria-hidden="true" class="icon--footer_map_120x92"><use xlink:href="#icon--footer_map_120x92" /></svg>
        </a>

        <ul class="g-footer__link-list g-footer__link-list--spaced">
          <li>
            Historic Building <br>
            <a href="https://www.google.co.uk/maps/place/The+Art+Institute+of+Chicago/@41.8795845,-87.625902,17z/data=!3m1!5s0x880e2ca148f260e3:0xd473c3802aaff420!4m5!3m4!1s0x880e2ca3e2d94695:0x4829f3cc9ca2d0de!8m2!3d41.8795847!4d-87.623713" target="_blank">111 South Michigan Avenue, <br>Chicago, IL 60603</a>
          </li>

          <li>
            Modern Wing <br>
            <a href="https://www.google.co.uk/maps/place/The+Art+Institute+of+Chicago/@41.8795845,-87.625902,17z/data=!3m1!5s0x880e2ca148f260e3:0xd473c3802aaff420!4m5!3m4!1s0x880e2ca3e2d94695:0x4829f3cc9ca2d0de!8m2!3d41.8795847!4d-87.623713" target="_blank">159 East Monroe Street, <br>Chicago, IL 60603</a>
          </li>
        </ul>
      </li>

      <li class="u-hide@small-">
        <div class="g-footer__grid__group">
          <h3 class="f-list-6"><a href="{{ $_pages['about-us'] }}">About us<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></a></h3>

          <ul class="g-footer__link-list">
            <li><a href="{{ $_pages['about-us-inside-the-museum'] }}">Inside the museum</a></li>
            <li><a href="{{ $_pages['about-us-inside-the-museum'] }}">Mission and history</a></li>
            <li><a href="{{ $_pages['about-us-leadership'] }}">Leadership</a></li>
            <li><a href="{{ $_pages['about-us-financials'] }}">Financial records</a></li>
          </ul>
        </div>

        <div class="g-footer__grid__group">
          <h3 class="f-list-6">Support us</h3>

          <ul class="g-footer__link-list">
            <li><a href="{{ $_pages['support-us-membership'] }}">Membership</a></li>
            <li><a href="{{ $_pages['support-us-ways-to-give'] }}">Ways to give</a></li>
            <li><a href="{{ $_pages['support-us-affiliate-groups'] }}">Affiliate groups</a></li>
            <li><a href="{{ $_pages['support-us-corporate-sponsorship'] }}">Corporate sponsorship</a></li>
          </ul>
        </div>
      </li>

      <li>
        <div class="g-footer__grid__group u-hide@small-">
          <h3 class="f-list-6"><a href="{{ $_pages['learn'] }}">Learn with us<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></a></h3>

          <ul class="g-footer__link-list">
            <li><a href="{{ $_pages['learn-families'] }}">Families</a></li>
            <li><a href="{{ $_pages['learn-teens'] }}">Teens</a></li>
            <li><a href="{{ $_pages['learn-adults'] }}">Adults</a></li>
            <li><a href="{{ $_pages['learn-educators'] }}">Educators</a></li>
          </ul>
        </div>

        <div class="g-footer__grid__group">
          <h3 class="f-list-6">Follow us</h3>

          <ul class="g-footer__link-list">
            <li><a href="{{ $_pages['follow-facebook'] }}">Facebook</a></li>
            <li><a href="{{ $_pages['follow-twitter'] }}">Twitter</a></li>
            <li><a href="{{ $_pages['follow-instagram'] }}">Instagram</a></li>
            <li><a href="{{ $_pages['follow-pinterest'] }}">Pinterest</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>

  <ul class="g-footer__legals f-secondary">
    <li><a href="{{ $_pages['legal-articles'] }}">Articles</a></li>
    <li><a href="{{ $_pages['legal-employment'] }}">Employment</a></li>
    <li><a href="{{ $_pages['legal-venue-rental'] }}">Venue rental</a></li>
    <li><a href="{{ $_pages['legal-contact'] }}">Contact</a></li>
    <li><a href="{{ $_pages['legal-saic'] }}">SAIC</a></li>
    <li><a href="{{ $_pages['legal-terms'] }}">Terms</a></li>
    <li><a href="{{ $_pages['legal-image-licensing'] }}">Image licensing</a></li>
  </ul>
</footer>
<a class="top-link" href="#a17">
  <svg class="icon--arrow" aria-label="top of page">
    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon--arrow">
  </svg>
</a>
