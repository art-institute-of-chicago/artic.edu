import { triggerCustomEvent, queryStringHandler } from '@area17/a17-helpers';
import '../../libs/conic-gradient';

const colorPickerFilter = function(container) {

  let currentDragFunction = null;

  let hueWheelElement,
      shadeWheelElement,
      hueHandleElement,
      shadeHandleElement,
      centerHandleElement,
      colorSwatchElement,
      monochromeSwatchElement,
      submitForm,
      submitButton,
      monochromeButton;

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

  let hueWheelAngle = 0;
  let shadeWheelAngle = 270;

  let currentHue = colors[0];
  let currentShade = 0.5;
  let currentColor = colors[0];
  let currentShadedColor = currentColor;
  let currentColorString = hexToCss(currentShadedColor);

  let isMonochromeSelected = false;

  function showSharedElements() {
    submitForm.setAttribute('style', 'height: 48px');
  }

  function toggleColorElements(shouldHide) {
    shouldHide = (typeof shouldHide !== 'undefined' ? shouldHide : false)
    let method = shouldHide ? 'remove' : 'add';
    [shadeHandleElement, hueHandleElement, centerHandleElement].forEach(function(handleElement, i) {
      handleElement.classList[method]('o-color-picker__handle--initialized');
    });
    colorSwatchElement.classList[method]('o-color-picker__center__swatch--initialized');
    showSharedElements();
  }

  function toggleMonochromeElements(shouldHide) {
    shouldHide = (typeof shouldHide !== 'undefined' ? shouldHide : false)
    let method = shouldHide ? 'remove' : 'add';
    monochromeSwatchElement.classList[method]('o-color-picker__center__swatch--initialized');
    showSharedElements();
    if (!shouldHide) {
      submitButton.innerHTML = ''
        + '<span class="o-color-picker__button--submit--monochrome">'
        + '</span>'
        + 'OK';
    }
  }

  function selectMonochrome() {
    isMonochromeSelected = true;

    toggleMonochromeElements();
    toggleColorElements(true);
  }

  function _handleSubmit(event) {
    event.preventDefault();
    event.stopPropagation();

    let href = isMonochromeSelected ? getMonochromeHref() : getColorHref();

    triggerCustomEvent(document, 'ajax:getPage', {
      url: href,
      ajaxScrollTarget: 'collection'
    });
  }

  function getMonochromeHref() {
    let href = window.location.href;

    href = queryStringHandler.updateParameter(href, 'monochrome', '1');
    href = removeURLParameter(href, 'color');
    href = removeURLParameter(href, 'angle');

    return href;
  }

  function getColorHref() {
    let currentColorQuery = hexToHSL(currentColorString);

    currentColorQuery = [
      Math.floor(currentColorQuery.h * 360),
      Math.floor(currentColorQuery.s * 100),
      Math.floor(currentColorQuery.l * 100),
    ];

    let href = window.location.href;

    href = queryStringHandler.updateParameter(href, 'color', currentColorQuery.join('-'))
    href = queryStringHandler.updateParameter(href, 'angle', [hueWheelAngle, shadeWheelAngle].join('-'))
    href = removeURLParameter(href, 'monochrome');

    return href;
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

    colorSwatchElement = document.querySelector('.o-color-picker__center__swatch--color');
    monochromeSwatchElement = document.querySelector('.o-color-picker__center__swatch--monochrome');

    submitForm = document.querySelector('.o-color-picker__form');
    submitButton = document.querySelector('.o-color-picker__button--submit');

    monochromeButton = document.querySelector('.o-color-picker__button--monochrome');

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

    if (queryStringObject.hasOwnProperty('color')) {
      convertColorParam(queryStringObject.color);
      toggleColorElements();
      toggleMonochromeElements(true);
    } else if (queryStringObject.hasOwnProperty('monochrome')) {
      isMonochromeSelected = true;
      toggleMonochromeElements();
      toggleColorElements(true);
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
      if (a.textContent.trim().startsWith('Monochrome')) {
        a.innerHTML = 'Monochrome'
          + '<span class="tag__color-swatch tag__color-swatch--monochrome">'
          + '</span>'
          + '<svg class="icon--close"><use xlink:href="#icon--close" /></svg>';
      }
    });

    // Toggle `display` for performance as sidebar resizes
    document.addEventListener('collectionFilters:open', _showFilters, false);
    document.addEventListener('collectionFilters:close', _hideFilters, false);

    document.addEventListener('ajaxPageLoad:complete', _init, false);

    submitButton.addEventListener('click', _handleSubmit, false);
    monochromeButton.addEventListener('click', selectMonochrome, false);

    if ((document.querySelector('html').className + " ").replace(/[\n\t]/g, " ").indexOf(" s-collection-filters-active ") > -1) {
      _showFilters();
    }
  }

  this.destroy = function() {
    // Remove specific event handlers
    submitButton.removeEventListener('click', _handleSubmit);
    monochromeButton.removeEventListener('click', selectMonochrome);

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

  // Figure out how to transform a color into angles
  function convertColorParam(rawColorParam) {
    rawColorParam = rawColorParam.split('-');

    let colorParam = {
      'h': rawColorParam[0],
      's': rawColorParam[1],
      'l': rawColorParam[2],
    };

    let colorParamHex = hslToHex(colorParam.h, colorParam.s, colorParam.l);

    let hslColors = colors.map(x => hexToHslInt(hexToCss(x)));
    hslColors[hslColors.length - 1].h += 360; // duplicate color

    let floorColorIndex = null;

    // Assuming that the hues in `colors` increment, find the "floor" color
    hslColors.forEach(function(hslColor, i) {
      if (i === 0) {
        return;
      }

      if (hslColors[i-1].h < colorParam.h && colorParam.h < hslColor.h) {
        floorColorIndex = i-1;
      }
    });

    if (floorColorIndex === null) {
      return;
    }

    // Determine the hue angle
    let floorColorHue = hslColors[floorColorIndex].h;
    let ceilColorHue = hslColors[floorColorIndex+1].h;

    hueWheelAngle = anglePerColor * floorColorIndex;
    hueWheelAngle += anglePerColor * (colorParam.h - floorColorHue) / (ceilColorHue - floorColorHue);

    // Figure out the max and min shades possible at this hue
    let minShadedColor = hexToHslInt(hexToCss(lerpColor(colorParamHex, 0x000000, maxShadeFactor)));
    let maxShadedColor = hexToHslInt(hexToCss(lerpColor(colorParamHex, 0xffffff, maxShadeFactor)));

    // TODO: This percentage is not linear
    let luminocityPercent = (colorParam.l - minShadedColor.l) / (maxShadedColor.l - minShadedColor.l);
    let saturationPercent = (colorParam.s - minShadedColor.s) / (maxShadedColor.s - minShadedColor.s);
    let shadePercent = (luminocityPercent + saturationPercent) / 2;

    shadeWheelAngle = Math.floor(180 * shadePercent);
  }

  function enableDragFunction(event) {
    document.addEventListener('mouseup', currentDragFunction, false);
    document.addEventListener('touchend', currentDragFunction, false);

    document.addEventListener('mouseup', disableDragFunction, false);
    document.addEventListener('touchend', disableDragFunction, false);

    window.addEventListener('mousemove', currentDragFunction, {passive: false});
    window.addEventListener('touchmove', currentDragFunction, {passive: false});

    isMonochromeSelected = false;

    toggleColorElements();
    toggleMonochromeElements(true);

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
    colorSwatchElement.setAttribute(
      'style',
      'background-color:' + hexToCss(currentShadedColor) + ';'
    );

    if (!isMonochromeSelected) {
      submitButton.innerHTML = ''
        + '<span style="background-color:' + currentColorString + '">'
        + '</span>'
        + 'OK';
    }
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

  function hexToHslInt(hex) {
    let hsl = hexToHSL(hex);
    hsl.h = Math.floor(hsl.h * 360);
    hsl.s = Math.floor(hsl.s * 100);
    hsl.l = Math.floor(hsl.l * 100);
    return hsl;
  }

  function hexToCss(hex) {
    return '#' + hex.toString(16).padStart(6, '0');
  }

  /**
   * @link https://stackoverflow.com/questions/36721830/convert-hsl-to-rgb-and-hex
   */
  function hslToHex(h, s, l) {
    h /= 360;
    s /= 100;
    l /= 100;
    let r, g, b;
    if (s === 0) {
      r = g = b = l; // achromatic
    } else {
      const hue2rgb = (p, q, t) => {
        if (t < 0) t += 1;
        if (t > 1) t -= 1;
        if (t < 1 / 6) return p + (q - p) * 6 * t;
        if (t < 1 / 2) return q;
        if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6;
        return p;
      };
      const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
      const p = 2 * l - q;
      r = hue2rgb(p, q, h + 1 / 3);
      g = hue2rgb(p, q, h);
      b = hue2rgb(p, q, h - 1 / 3);
    }
    const toHex = x => {
      const hex = Math.round(x * 255).toString(16);
      return hex.length === 1 ? '0' + hex : hex;
    };
    return parseInt(`0x${toHex(r)}${toHex(g)}${toHex(b)}`, 16);
  }

  function removeURLParameter(url, parameter) {
    //prefer to use l.search if you have a location/link object
    var urlparts = url.split('?');
    if (urlparts.length >= 2) {

        var prefix = encodeURIComponent(parameter) + '=';
        var pars = urlparts[1].split(/[&;]/g);

        //reverse iteration as may be destructive
        for (var i = pars.length; i-- > 0;) {
            //idiom for string.startsWith
            if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                pars.splice(i, 1);
            }
        }

        return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
    }
    return url;
  }
};

export default colorPickerFilter;
