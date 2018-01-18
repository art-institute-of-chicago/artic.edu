const findAncestorByTagName = function(el, tagname) {
  while (el && el.tagName !== tagname) {
    el = el.parentElement;
  }
  return el;
};

export default findAncestorByTagName;
