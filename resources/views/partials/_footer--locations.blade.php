@php
    $showMap = $showMap ?? false;
@endphp

@if ($showMap)
  <a href="https://www.google.com/maps/place/The+Art+Institute+of+Chicago/@41.8795845,-87.625902,17z/data=!3m1!5s0x880e2ca148f260e3:0xd473c3802aaff420!4m5!3m4!1s0x880e2ca3e2d94695:0x4829f3cc9ca2d0de!8m2!3d41.8795847!4d-87.623713" target="_blank" aria-label="Directions to the Art Institute of Chicago">
    <svg aria-hidden="true" class="icon--footer_map_120x92"><use xlink:href="#icon--footer_map_120x92" /></svg>
  </a>
@endif

<h3 class="sr-only" id="h-footer-nav-locations">Locations</h3>
<ul class="g-footer__link-list {{ !$showMap ? 'g-footer__link-list--flush' : '' }} g-footer__link-list--spaced" aria-labelledby="h-footer-nav-locations">
  <li>
    <h4>Michigan Avenue Entrance</h4>
    <a href="https://www.google.com/maps/place/The+Art+Institute+of+Chicago/@41.8795845,-87.625902,17z/data=!3m1!5s0x880e2ca148f260e3:0xd473c3802aaff420!4m5!3m4!1s0x880e2ca3e2d94695:0x4829f3cc9ca2d0de!8m2!3d41.8795847!4d-87.623713" target="_blank">111 South Michigan Avenue <br>Chicago, IL 60603</a>
  </li>

  <li>
    <h4>Modern Wing Entrance</h4>
    <a href="https://www.google.com/maps/place/Modern+Wing+Entrance/@41.8797032,-87.6244036,17z/data=!3m1!5s0x880e2ca148f260e3:0xd473c3802aaff420!4m12!1m6!3m5!1s0x880e2ca3e2d94695:0x4829f3cc9ca2d0de!2sThe+Art+Institute+of+Chicago!8m2!3d41.8795847!4d-87.623713!3m4!1s0x880e2ca6cf1a0e41:0xa97b8d9d0c91fa6e!8m2!3d41.880725!4d-87.621932" target="_blank">159 East Monroe Street <br>Chicago, IL 60603</a>
  </li>
</ul>
