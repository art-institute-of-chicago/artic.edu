import { triggerCustomEvent, queryStringHandler } from '@area17/a17-helpers';
import 'conic-gradient';

const colorPickerFilter = function(container) {

  let currentDragFunction = null;

  let hueWheelElement,
      shadeWheelElement,
      hueHandleElement,
      shadeHandleElement,
      centerHandleElement,
      currentColorElement,
      submitForm,
      submitButton;

  const colors = [
    0xff3e3e,
    0xf9992a,
    0xfbec4e,
    0xeef2aa,
    0x92ed30,
    0x46c8e5,
    0x4648ea,
    0xb05fe4,
    0xff3e3e,
  ];

  const anglePerColor = 360 / (colors.length - 1);
  const maxShadeFactor = 0.65;
  const displayShadeFactor = 0.95;

  const maxDarkShade = lerpColor(0x777777, 0x000000, maxShadeFactor);
  const maxLightShade = lerpColor(0x777777, 0xffffff, maxShadeFactor);

  const displayDarkShade = lerpColor(0x777777, 0x000000, displayShadeFactor);
  const displayLightShade = lerpColor(0x777777, 0xffffff, displayShadeFactor);

  const shades = [
    hexToCss(displayDarkShade),
    hexToCss(0x777777),
    hexToCss(displayLightShade),
    hexToCss(0x777777),
    hexToCss(displayDarkShade),
  ];

  const handleOffset = 5;

  let hasInitialized = false;

  let hueWheelAngle = 0;
  let shadeWheelAngle = 270;

  let currentHue = colors[0];
  let currentShade = 0.5;
  let currentColor = colors[0];
  let currentShadedColor = currentColor;
  let currentColorString = hexToCss(currentShadedColor);

  function initShowElements() {
    submitForm.setAttribute('style', 'height: 48px');
    [shadeHandleElement, hueHandleElement, centerHandleElement].forEach(function(handleElement, i) {
      handleElement.classList.add('o-color-picker__handle--initialized');
    });
    hasInitialized = true;
  }

  function _handleSubmit(event) {
    event.preventDefault();
    event.stopPropagation();

    let currentColorQuery = hexToHSL(currentColorString);

    currentColorQuery = [
      Math.floor(currentColorQuery.h * 360),
      Math.floor(currentColorQuery.s * 100),
      Math.floor(currentColorQuery.l * 100),
    ];

    let href = window.location.href;

    href = queryStringHandler.updateParameter(href, 'color', currentColorQuery.join('-'))
    href = queryStringHandler.updateParameter(href, 'angle', [hueWheelAngle, shadeWheelAngle].join('-'))

    triggerCustomEvent(document, 'ajax:getPage', {
      url: href,
      ajaxScrollTarget: 'collection'
    });
  }

  const that = this;

  function _init() {

    if (document.querySelector('.o-color-picker') === null) {
      that.destroy();
    }

    hueWheelElement = document.querySelector('.o-color-picker__wheel--hue');
    shadeWheelElement = document.querySelector('.o-color-picker__wheel--shade');

    hueHandleElement = document.querySelector('.o-color-picker__handle--hue');
    shadeHandleElement = document.querySelector('.o-color-picker__handle--shade');
    centerHandleElement = document.querySelector('.o-color-picker__handle--center');

    currentColorElement = document.querySelector('.o-color-picker__center__swatch');

    submitForm = document.querySelector('.o-color-picker__form');
    submitButton = document.querySelector('.o-color-picker__submit');

    [shadeHandleElement, hueHandleElement, centerHandleElement].forEach(function(handleElement, i) {
      let percentInterval = (
        12.5 // handleElement === shadeHandleElement ? 30 : 12.5
      );

      handleElement.querySelectorAll('circle').forEach(function(circleElement) {
        // @see https://developer.mozilla.org/en-US/docs/Web/SVG/Attribute/stroke-dashoffset#Usage_notes
        // @see https://developer.mozilla.org/en-US/docs/Web/SVG/Attribute/stroke-width#Usage_notes
        circleElement.setAttribute('stroke-dasharray', `${percentInterval} ${100 - percentInterval}`);
        circleElement.setAttribute('stroke-dashoffset', 25 + percentInterval/2);
        circleElement.setAttribute('stroke-width', 31.91);
      });
    });

    let hueGradient = new ConicGradient({
      stops: colors.map(x => hexToCss(x)).join(', '),
      size: hueWheelElement.getBoundingClientRect().offsetWidth,
    });

    hueWheelElement.setAttribute('style', 'background:' + hueGradient.toString());

    let shadeGradient = new ConicGradient({
      stops: shades.join(', '),
      size: shadeWheelElement.getBoundingClientRect().offsetWidth,
    });

    shadeWheelElement.setAttribute('style', 'background:' + shadeGradient.toString());

    hueWheelElement.addEventListener('mousedown', enableHueDragFunction, false);
    hueWheelElement.addEventListener('touchstart', enableHueDragFunction, false);

    shadeWheelElement.addEventListener('mousedown', enableShadeDragFunction, false);
    shadeWheelElement.addEventListener('touchstart', enableShadeDragFunction, false);

    let queryStringObject = queryStringHandler.toObject(window.location.href);

    if (queryStringObject.hasOwnProperty('angle')) {
      let angles = queryStringObject.angle.split('-');
      hueWheelAngle = angles[0];
      shadeWheelAngle = angles[1];
      initShowElements();
    }

    updateHueWheel();
    updateShadeWheel();
    updateCurrentColorElement();

    document.querySelectorAll('.m-active-filters__item a').forEach( function(a) {
      if (a.textContent.trim().startsWith('Color')) {
        a.innerHTML = 'Color:'
          + '<span class="tag__color-swatch" style="background-color:' + currentColorString + '">'
          + '</span>'
          + '<svg class="icon--close"><use xlink:href="#icon--close" /></svg>';
      }
    });

    // Toggle `display` for performance as sidebar resizes
    document.addEventListener('collectionFilters:open', _showFilters, false);
    document.addEventListener('collectionFilters:close', _hideFilters, false);

    document.addEventListener('ajaxPageLoad:complete', _init, false);

    submitButton.addEventListener('click', _handleSubmit, false);

    if ((document.querySelector('html').className + " ").replace(/[\n\t]/g, " ").indexOf(" s-collection-filters-active ") > -1) {
      _showFilters();
    }
  }

  this.destroy = function() {
    // Remove specific event handlers
    submitButton.removeEventListener('click', _handleSubmit);

    hueWheelElement.removeEventListener('mousedown', enableHueDragFunction);
    hueWheelElement.removeEventListener('touchstart', enableHueDragFunction);

    shadeWheelElement.removeEventListener('mousedown', enableShadeDragFunction);
    shadeWheelElement.removeEventListener('touchstart', enableShadeDragFunction);

    document.removeEventListener('collectionFilters:open', _showFilters);
    document.removeEventListener('collectionFilters:close', _hideFilters);

    document.removeEventListener('ajaxPageLoad:complete', _init);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };

  function _showFilters() {
    setTimeout(function(){
      container.setAttribute('style', 'display: block');
    }, 432);
  }

  function _hideFilters() {
    setTimeout(function(){
      container.setAttribute('style', 'display: none');
    }, 432);
  }

  function enableDragFunction(event) {
    document.addEventListener('mouseup', currentDragFunction, false);
    document.addEventListener('touchend', currentDragFunction, false);

    document.addEventListener('mouseup', disableDragFunction, false);
    document.addEventListener('touchend', disableDragFunction, false);

    window.addEventListener('mousemove', currentDragFunction, {passive: false});
    window.addEventListener('touchmove', currentDragFunction, {passive: false});

    initShowElements();

    currentDragFunction(event);
  };

  function disableDragFunction() {
    document.removeEventListener('mouseup', currentDragFunction);
    document.removeEventListener('touchend', currentDragFunction);

    document.removeEventListener('mouseup', disableDragFunction);
    document.removeEventListener('touchend', disableDragFunction);

    window.removeEventListener('mousemove', currentDragFunction);
    window.removeEventListener('touchmove', currentDragFunction);
  };

  function getAngleFunction(event, wheelElement) {
    let touch = undefined;
    if (event.touches) {
      touch = event.touches[0];
    }

    const rect = wheelElement.getBoundingClientRect();
    const center_x = (wheelElement.offsetWidth / 2) + rect.left + window.scrollX;
    const center_y = (wheelElement.offsetHeight / 2) + rect.top + window.scrollY;

    const pos_x = event.pageX || touch.pageX;
    const pos_y = event.pageY || touch.pageY;
    const delta_y =  center_y - pos_y;
    const delta_x = center_x - pos_x;

    // Calculate Angle between circle center and mouse pos
    let angle = Math.atan2(delta_y, delta_x) * (180 / Math.PI);
    angle -= 90;
    if (angle < 0) {
      angle = 360 + angle; // Always show angle positive
    }
    angle = Math.floor(angle);
    return angle;
  };

  function updateHueWheel() {
    let p = hueWheelAngle/360;
    let i = Math.floor(p * (colors.length - 1));
    let j = i + 1 > colors.length - 1 ? 0 : i + 1;

    currentColor = lerpColor(
      colors[i],
      colors[j],
      (hueWheelAngle % anglePerColor) / anglePerColor
    );

    hueHandleElement.setAttribute(
      'style',
      'transform:translate(-50%, -50%) rotate(' + hueWheelAngle + 'deg);' +
      'color:' + hexToCss(currentColor) + ';'
    );

    centerHandleElement.setAttribute(
      'style',
      'transform:translate(-50%, -50%) rotate(' + hueWheelAngle + 'deg);'
    );
  }

  function updateShadeWheel() {

    let admixedShade = shadeWheelAngle > 270 || shadeWheelAngle < 90 ? 0x000000 : 0xffffff;
    let angleToShade = Math.abs(admixedShade === 0x000000 ? (
      shadeWheelAngle > 270 ? shadeWheelAngle - 360 : shadeWheelAngle
    ) : (
      shadeWheelAngle - 180
    ));

    currentShadedColor = lerpColor(
      currentColor,
      admixedShade,
      (1 - angleToShade/90) * maxShadeFactor
    );

    currentColorString = hexToCss(currentShadedColor);

    let currentDisplayShade = lerpColor(displayDarkShade, displayLightShade, 1 - Math.abs(shadeWheelAngle - 180)/180);

    shadeHandleElement.setAttribute(
      'style',
      'transform:translate(-50%, -50%) rotate(' + shadeWheelAngle + 'deg);' +
      'color:' + hexToCss(currentDisplayShade) + ';'
    );

  }

  function updateCurrentColorElement() {
    currentColorElement.setAttribute(
      'style',
      'background-color:' + (hasInitialized ? hexToCss(currentShadedColor) : 'transparent') + ';'
    );

    submitButton.innerHTML = ''
      + '<span style="background-color:' + currentColorString + '">'
      + '</span>'
      + 'OK';
  }

  function enableHueDragFunction(event) {
    currentDragFunction = hueDragFunction;
    enableDragFunction(event);
  };

  function enableShadeDragFunction(event) {
    currentDragFunction = shadeDragFunction;
    enableDragFunction(event);
  };

  function hueDragFunction(event) {
    event.preventDefault();
    event.stopPropagation();

    hueWheelAngle = getAngleFunction(event, hueWheelElement);
    updateHueWheel();
    updateShadeWheel();
    updateCurrentColorElement();
  };

  function shadeDragFunction(event) {
    event.preventDefault();
    event.stopPropagation();

    shadeWheelAngle = getAngleFunction(event, shadeWheelElement);
    updateShadeWheel();
    updateCurrentColorElement();
  };

  /**
   * @link https://gist.github.com/nikolas/b0cce2261f1382159b507dd492e1ceef
   * @link https://gist.github.com/rosszurowski/67f04465c424a9bc0dae
   */
  function lerpColor(a, b, amount) {
    const ar = a >> 16,
          ag = a >> 8 & 0xff,
          ab = a & 0xff,

          br = b >> 16,
          bg = b >> 8 & 0xff,
          bb = b & 0xff,

          rr = ar + amount * (br - ar),
          rg = ag + amount * (bg - ag),
          rb = ab + amount * (bb - ab);

    return (rr << 16) + (rg << 8) + (rb | 0);
  }

  /**
   * @link https://gist.github.com/xenozauros/f6e185c8de2a04cdfecf
   */
  function hexToHSL(hex) {
    let result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    let r, g, b;
    r = parseInt(result[1], 16);
    g = parseInt(result[2], 16);
    b = parseInt(result[3], 16);
    r /= 255, g /= 255, b /= 255;
    var max = Math.max(r, g, b), min = Math.min(r, g, b);
    var h, s, l = (max + min) / 2;
    if(max == min){
      h = s = 0; // Achromatic
    }else{
      var d = max - min;
      s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
      switch(max){
        case r: h = (g - b) / d + (g < b ? 6 : 0); break;
        case g: h = (b - r) / d + 2; break;
        case b: h = (r - g) / d + 4; break;
      }
      h /= 6;
    }
    var HSL = new Object();
    HSL['h']=h;
    HSL['s']=s;
    HSL['l']=l;
    return HSL;
  }

  function hexToCss(hex) {
    return '#' + hex.toString(16).padStart(6, '0');
  }
};

export default colorPickerFilter;
