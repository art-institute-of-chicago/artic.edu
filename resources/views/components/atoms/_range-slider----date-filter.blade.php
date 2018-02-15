<script>
var dateRangeValues = [
    '8000BC','7000BC','6000BC','5000BC','4000BC','3000BC','2000BC','1000BC','1AD','500AD','1000AD','1200AD','1400AD','1600AD','1700AD','1800AD','1900AD','1910AD','1920AD','1930AD','1940AD','1950AD','1960AD','1970AD','1980AD','1990AD','2000AD','2010AD','Present'];
</script>
<div class="range-slider s-capped" data-behavior="rangeSlider" data-param="date" data-range-values="dateRangeValues">
  <em class="range-slider__display f-secondary">
    <span data-range-min-display></span> - <span data-range-max-display></span>
  </em>

  <div class="range-slider__slider" data-range-slider></div>

  <div class="range-slider__custom">
      <div class="range-slider__custom-row">
          <div class="range-slider__custom-input">
              <input type="num" id="rangeFrom" name="rangeFrom" data-range-custom-from />
          </div>

          <div class="range-slider__custom-input">
              <input type="num" id="rangeTo" name="rangeTo" data-range-custom-to />
          </div>
      </div>

      <button class="range-slider__custom-btn" data-range-custom-btn>OK</button>
  </div>
</div>

<button class="m-filters__show-more-toggle f-secondary" data-behavior="filterToggleShowMore">
    <svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg>
    <span>Custom range</span>
</button>
