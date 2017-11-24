<header class="g-header">
  @if (isset($contrastHeader) and $contrastHeader)
  <a class="g-header__logo" href="/"><svg class="icon--logo--92" aria-label="Art Institute of Chicago"><use xlink:href="#icon--logo--92" /></svg></a>
  @else
  <a class="g-header__logo" href="/"><svg class="icon--logo--outline--92" aria-label="Art Institute of Chicago"><use xlink:href="#icon--logo--outline--92" /></svg></a>
  @endif
  <nav class="g-header__nav-primary">
    <ul class="f-body">
      <li><a href="#">Visit</a></li>
      <li><a href="#">Exhibitions and events</a></li>
      <li><a href="#">Art and ideas</a></li>
      <li><a href="#"><svg class="icon--search--24" aria-label="Search site"><use xlink:href="#icon--search--24" /></svg></a></li>
    </ul>
  </nav>
  <nav class="g-header__nav-secondary">
    <ul class="f-body">
      <li><a href="#">Shop</a></li>
      <li><a href="#">Buy Tickets</a></li>
      <li><a href="#">Become a member</a></li>
    </ul>
  </nav>
  <p class="g-header__opening-hours f-body"><a href="#">Open daily 10:30&ndash;5:00, <br>Thursdays until 8:00</a></p>
  <a href="#menu" class="g-header__menu-link f-body">Menu</a>
</header>
