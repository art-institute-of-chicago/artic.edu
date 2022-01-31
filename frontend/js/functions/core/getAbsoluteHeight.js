export default function getAbsoluteHeight(el) {
  el = (typeof el === 'string') ? document.querySelector(el) : el;

  var styles = window.getComputedStyle(el);
  var margin = parseFloat(styles['marginTop']) +
  parseFloat(styles['marginBottom']);

  return Math.ceil(el.offsetHeight + margin);
};
