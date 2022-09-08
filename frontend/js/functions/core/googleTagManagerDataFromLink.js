const googleTagManagerDataFromLink = function(link) {
  if (!link || !link.dataset) {
    return false;
  }

  let gtmKeyFound = false;
  let gtmObjs = {};

  for (let key in link.dataset) {
    if (link.dataset.hasOwnProperty(key) && key.indexOf('gtm') > -1) {
      // It kept the `-` before the number?
      let gtmKey = key.replace(/^gtm/,'').replace(/^-/,'');
      let gtmValue = link.dataset[key];

      // WEB-2436: Group by leading number, if any
      let gtmIndex = gtmKey.replace(/[^\d+]/g, '') || 0;
      gtmKey = gtmKey.replace(/^\d+/, '');

      // Sort the casing out (camelCase)
      gtmKey = gtmKey.charAt(0).toLowerCase() + gtmKey.slice(1);

      // Check if its a special value that requires JS assistance
      if (gtmValue === '::document.title::') {
        gtmValue = document.title.replace(/ \| The Art Institute of Chicago/ig, '');
      }

      if (!gtmObjs.hasOwnProperty(gtmIndex)) {
        gtmObjs[gtmIndex] = {};
      }

      gtmObjs[gtmIndex][gtmKey] = gtmValue;
      gtmKeyFound = true;
    }
  }

  // Turn object with numeric keys into array
  gtmObjs = Object.values(gtmObjs);

  if (gtmKeyFound) {
    return gtmObjs;
  } else {
    return false;
  }
};

export default googleTagManagerDataFromLink;
