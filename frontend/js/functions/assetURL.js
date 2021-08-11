
const queryParams = params => Object.keys(params).map(function(key) {
    if (key === 'width') key = 'w';
    if (key === 'height') key = 'h';

    return key + '=' + params[key];
  }).join('&');

  const getParams = src => {
    if( !src ) return false;
    if( src.indexOf('?') < 0 ) return false;

    let hashes = src.slice(src.indexOf('?') + 1).split('&');

    if( !hashes ) return false;

    let params = {}
    hashes.map(hash => {
      let [key, val] = hash.split('=')
      params[key] = decodeURIComponent(val)
    })

    return params;
  }

  function removeQueryString(src) {
    if( !src ) return false;

    return src.split(/[?#]/)[0];
  }

  export default (src, params = {}, keepParams = true) => {
    const currentParams = getParams(src);

    if( currentParams && keepParams ){
      params = Object.assign(currentParams, params);
    }

    return `${removeQueryString(src)}?${queryParams(params)}`;
  }
