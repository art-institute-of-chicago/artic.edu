import { cookieHandler, triggerCustomEvent } from '@area17/a17-helpers';
import FontFaceOnload from '../libs/fontfaceonload';

const fontObservers = function(fonts) {
  // Doc: https://code.area17.com/mike/a17-js-helpers/wikis/A17-Helpers-fontObservers

  if ((typeof fonts).toLowerCase() !== 'object') {
    return false;
  }

  // a counter
  var counter = 0;

  var total = fonts.variants.length;

  // cookie name
  var cookieName = 'A17_fonts_cookie_'+fonts.name;

  // check we have cookie of fonts already loaded or not
  var cookie = cookieHandler.read(cookieName) || '';

  // when a fonts is determined to be loaded
  function loaded() {
    // increment counter
    counter++;

    // if we reached the total
    if (counter >= total) {
      // add class
      document.documentElement.className += ' s-'+fonts.name+'-loaded';

      // write cookie
      cookieHandler.create(cookieName, total, 1);

      // trigger event
      triggerCustomEvent(document, 'content:populated');
    }

  }

  // if cookie, show fonts (not first page load)
  if (cookie && cookie === total.toString()) {
    counter = cookie;
    loaded();
  } else {
    // go check on those fonts, using fontfaceonload https://github.com/zachleat/fontfaceonload
    for (var i = 0; i < total; i++) {
      FontFaceOnload(fonts.variants[i].name, {
        success: loaded,
        error: loaded,
        weight: fonts.variants[i].weight || '',
        timeout: 3000
      });
    }
  }
};

export default fontObservers;
