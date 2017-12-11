<header class="g-header">
  @if (isset($filledLogo) and $filledLogo)
  <a class="g-header__logo" href="/">
    <svg aria-title="Art Institute of Chicago">
      <use xlink:href="#icon--logo--80" />
      <use xlink:href="#icon--logo--88" />
      <use xlink:href="#icon--logo--92" />
    </svg>
  </a>
  @else
  <a class="g-header__logo" href="/">
    <svg aria-title="Art Institute of Chicago">
      <use xlink:href="#icon--logo--outline--80" />
      <use xlink:href="#icon--logo--outline--88" />
      <use xlink:href="#icon--logo--outline--92" />
    </svg>
  </a>
  @endif
  <nav class="g-header__nav-primary">
    <ul class="f-secondary">
      <li class='u-hide@small+'><a href="#">Buy Tickets</a></li>
      <li><a href="#">Visit</a></li>
      <li class="u-show@small+"><a href="#">Exhibitions and events</a></li>
      <li class="u-show@small+"><a href="#">Art and ideas</a></li>
      <li class="u-show@small+"><a href="#"><svg class="icon--search--24" aria-label="Search site"><use xlink:href="#icon--search--24" /></svg></a></li>
    </ul>
  </nav>
  <nav class="g-header__nav-secondary">
    <ul class="f-secondary">
      <li><a href="#">Shop</a></li>
      <li><a href="#">Buy Tickets</a></li>
      <li><a href="#">Become a member</a></li>
    </ul>
  </nav>
  <p class="g-header__opening-hours f-secondary"><a href="#">Open daily 10:30&ndash;5:00, Thursdays until 8:00</a></p>
  <button class="g-header__menu-link f-secondary">Menu<svg class="icon--menu--24"><use xlink:href="#icon--menu--24" /></svg></button>
</header>
