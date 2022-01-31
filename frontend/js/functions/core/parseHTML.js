const parseHTML = function(data,type) {
  if (type === 'native') {
    var parser = new DOMParser();
    return parser.parseFromString(data, 'text/html');
  } else {
    var doc = document.implementation.createHTMLDocument('');
    if (data.toLowerCase().indexOf('<!doctype') > -1) {
      doc.documentElement.innerHTML = data;
    }
    else {
      doc.body.innerHTML = data;
    }
    return doc;
  }
}

export default parseHTML;
