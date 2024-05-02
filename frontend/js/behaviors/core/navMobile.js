import { setFocusOnTarget, forEach, triggerCustomEvent } from '@area17/a17-helpers';

const navMobile = function(container) {
  const openTriggers = container.querySelectorAll('[data-nav-trigger]');
  const backTriggers = container.querySelectorAll('[data-nav-back]');
  const isActiveClass = 's-nav-mobile-active';
  const isExpandedClass = 'js-subnav-open';
  const currentMenuItemClass = 'nav-is-open';
  const menuItemDetailsQuery = '.details';

  let navLevel = 0;
  let active = false;

  function _openNav(e){
    triggerCustomEvent(document, 'body:lock', {
      breakpoints: 'all'
    });
    window.requestAnimationFrame(function(){
      document.documentElement.classList.add(isActiveClass);
      setTimeout(function(){ setFocusOnTarget(container); }, 0)
      triggerCustomEvent(document, 'focus:trap', {
        element: container
      });
    });
    active = true;
  }

  function _closeNav(e){
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    document.documentElement.classList.remove(isActiveClass);
    setTimeout(function(){ setFocusOnTarget(document.getElementById('a17')); }, 0)
    active = false;
  }

  function _openSubNav(e){
    this.parentElement.classList.toggle(currentMenuItemClass);
    navLevel++;
    checkLevel();
    e.preventDefault();
    e.stopPropagation();
  };

  function _goBack(e){
    this.closest(menuItemDetailsQuery).previousElementSibling.classList.remove(currentMenuItemClass);
    navLevel--;
    checkLevel();
    e.preventDefault();
    e.stopPropagation();
  }

  function checkLevel(){
    if (navLevel > 0){
      container.classList.add(isExpandedClass);
    } else {
      container.classList.remove(isExpandedClass);
    }
  }

  function _mediaQueryUpdated() {
    if (active && mediaQuery('small+')) {
      triggerCustomEvent(document, 'navMobile:close');
      setTimeout(function(){
        window.scrollTo(0, 0);
      }, 5);
    }
  }

  function _init() {
    document.addEventListener('navMobile:open', _openNav, false);
    document.addEventListener('navMobile:close', _closeNav, false);
    document.addEventListener('mediaQueryUpdated',_mediaQueryUpdated, false);

    forEach(openTriggers, function(index, openTrigger) {
      openTrigger.addEventListener('click', _openSubNav, false);
    });

    forEach(backTriggers, function(index, backTrigger) {
      backTrigger.addEventListener('click', _goBack, false);
    });
  }

  this.destroy = function() {
    // Remove specific event handlers
    document.removeEventListener('navMobile:open', _openNav);
    document.removeEventListener('navMobile:close', _closeNav);
    document.removeEventListener('mediaQueryUpdated',_mediaQueryUpdated);

    forEach(openTriggers, function(index, openTrigger) {
      openTrigger.removeEventListener('click', _openSubNav);
    });

    forEach(backTriggers, function(index, backTrigger) {
      backTrigger.removeEventListener('click', _goBack);
    });

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default navMobile;
