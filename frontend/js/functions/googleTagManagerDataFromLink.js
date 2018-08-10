const googleTagManagerDataFromLink = function(link) {
  if (!link || !link.dataset) {
    return false;
  }

  let gtmKeyFound = false;
  let gtmObj = {};

  for (let key in link.dataset){
    if (link.dataset.hasOwnProperty(key) && key.indexOf('gtm') > -1) {
      let gtmKey = key.replace(/^gtm/,'');
      let gtmValue = link.dataset[key];
      // sort the casing out
      gtmKey = gtmKey.charAt(0).toLowerCase() + gtmKey.slice(1);
      // check if its a special value that requires JS assistance
      if (gtmValue === '::document.title::') {
        gtmValue = document.title.replace(/ \| The Art Institute of Chicago/ig, '');
      }
      //
      gtmObj[gtmKey] = gtmValue;
      gtmKeyFound = true;
    }
  }

  if (gtmKeyFound) {
    return gtmObj;
  } else {
    return false;
  }
};

export default googleTagManagerDataFromLink;
