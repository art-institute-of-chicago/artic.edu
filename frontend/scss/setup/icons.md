/***

Icons
=====

Icons are combined into one SVG as symbols by the Gulp task. This also generates a SCSS file detailing the dimensions of each icon with a corresponding CSS class name. The compiled symbols SVG is ajax'd into the document in the head.js.

Default icon size is 16 x 16 px. If the icon's width/height is larger than this than specify the box size in the file name. Eg:

* `location.svg` is a 16px square SVG
* `location.svg` is a 24px square SVG

More variants maybe added later, so anything thats not a 16px square SVG needs a dimension modifier.

```
<div class="m-icons-demo">
  <svg class="icon--alert"><use xlink:href="#icon--alert" /></svg>
  <svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
  <svg class="icon--calendar"><use xlink:href="#icon--calendar" /></svg>
  <svg class="icon--check"><use xlink:href="#icon--check" /></svg>
  <svg class="icon--clock"><use xlink:href="#icon--clock" /></svg>
  <svg class="icon--close-circle"><use xlink:href="#icon--close-circle" /></svg>
  <svg class="icon--close"><use xlink:href="#icon--close" /></svg>
  <svg class="icon--info--24"><use xlink:href="#icon--info--24" /></svg>
  <svg class="icon--location--24"><use xlink:href="#icon--location--24" /></svg>
  <svg class="icon--location"><use xlink:href="#icon--location" /></svg>
  <svg class="icon--logo--80"><use xlink:href="#icon--logo--80" /></svg>
  <svg class="icon--logo--88"><use xlink:href="#icon--logo--88" /></svg>
  <svg class="icon--logo--outline--80"><use xlink:href="#icon--logo--outline--80" /></svg>
  <svg class="icon--logo--outline--88"><use xlink:href="#icon--logo--outline--88" /></svg>
  <svg class="icon--minus--24"><use xlink:href="#icon--minus--24" /></svg>
  <svg class="icon--new-window"><use xlink:href="#icon--new-window" /></svg>
  <svg class="icon--play--48"><use xlink:href="#icon--play--48" /></svg>
  <svg class="icon--play--64"><use xlink:href="#icon--play--64" /></svg>
  <svg class="icon--play--96"><use xlink:href="#icon--play--96" /></svg>
  <svg class="icon--plus--24"><use xlink:href="#icon--plus--24" /></svg>
  <svg class="icon--print--24"><use xlink:href="#icon--print--24" /></svg>
  <svg class="icon--quote--76"><use xlink:href="#icon--quote--76" /></svg>
  <svg class="icon--return"><use xlink:href="#icon--return" /></svg>
  <svg class="icon--search--24"><use xlink:href="#icon--search--24" /></svg>
  <svg class="icon--share--24"><use xlink:href="#icon--share--24" /></svg>
  <svg class="icon--user"><use xlink:href="#icon--user" /></svg>
  <svg class="icon--zoom--24"><use xlink:href="#icon--zoom--24" /></svg>
</div>
```

***/
