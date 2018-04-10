const mediaQuery = function(mq) {

  // specific breakpoint
  if (mq === A17.currentMediaQuery) {
    return true;
  }

  // breakpoint and up
  if (mq === 'small+' && A17.currentMediaQuery.indexOf('xsmall') < 0) {
    return true;
  }

  if (mq === 'medium+' && A17.currentMediaQuery.indexOf('small') < 0) {
    return true;
  }

  if (mq === 'large+' && A17.currentMediaQuery.indexOf('small') < 0 && A17.currentMediaQuery.indexOf('medium') < 0) {
    return true;
  }

  // breakpoint and down

  if (mq === 'small-' && A17.currentMediaQuery.indexOf('small') >= 0) {
    return true;
  }

  if (mq === 'medium-' && (A17.currentMediaQuery.indexOf('small') >= 0 || A17.currentMediaQuery === 'medium')) {
    return true;
  }

  if (mq === 'large-' && (A17.currentMediaQuery.indexOf('small') >= 0 || A17.currentMediaQuery === 'medium' || A17.currentMediaQuery === 'large')) {
    return true;
  }

  return false;
};

export default mediaQuery;
