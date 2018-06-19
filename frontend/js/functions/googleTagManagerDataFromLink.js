const googleTagManagerDataFromLink = function(link) {
  if (!link || !link.dataset) {
    return false;
  }

  let gtmKeyFound = false;
  let gtmObj = {};

  for (let key in link.dataset){
    if (link.dataset.hasOwnProperty(key) && key.indexOf('gtm') > -1) {
      let gtmKey = key.replace(/^gtm/,'');
      gtmKey = gtmKey.charAt(0).toLowerCase() + gtmKey.slice(1);
      gtmObj[gtmKey] = link.dataset[key];
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
