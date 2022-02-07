import { cookieHandler, triggerCustomEvent } from '@area17/a17-helpers';
import FontFaceOnload from '../../libs/fontfaceonload';

const fontObservers = function(fonts) {
  if ((typeof fonts).toLowerCase() !== 'object') {
    return false;
  }

  // A counter
  var counter = 0;

  var total = fonts.variants.length;

  // Cookie name
  var cookieName = 'A17_fonts_cookie_'+fonts.name;

  // Check we have cookie of fonts already loaded or not
  var cookie = cookieHandler.read(cookieName) || '';

  // When a fonts is determined to be loaded
  function loaded() {
    // Increment counter
    counter++;

    // If we reached the total
    if (counter >= total) {
      // Write cookie
      cookieHandler.create(cookieName, total, 1);

      var klass = 's-'+fonts.name+'-loaded';
      var dE = document.documentElement;
      if (!dE.classList.contains(klass)) {
        // Add class
        dE.classList.add(klass);
        // Trigger event
        triggerCustomEvent(document, 'content:populated');
      }
    }

  }

  // If cookie, show fonts (not first page load)
  if (cookie && cookie === total.toString()) {
    counter = cookie;
    loaded();
  } else {
    // Go check on those fonts, using fontfaceonload https://github.com/zachleat/fontfaceonload
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
