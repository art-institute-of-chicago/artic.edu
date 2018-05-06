<div class="range-slider s-capped" data-behavior="rangeSlider" data-param="date" data-range-values="dateRangeValues">
  <em class="range-slider__display f-secondary">
    <span data-range-min-display></span> - <span data-range-max-display></span>
  </em>

  <div class="range-slider__slider" data-range-slider></div>

  <div class="range-slider__custom">m
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
