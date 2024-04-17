import { setFocusOnTarget, forEach, triggerCustomEvent } from '@area17/a17-helpers';

const navMobile = function(container) {

  var openTriggers = container.querySelectorAll('[data-nav-trigger]');
  var backTriggers = container.querySelectorAll('[data-nav-back]');
  var klass = 's-nav-mobile-active';
  var subnavKlass = 'js-subnav-open';
  var navLevel = 0;

  let active = false;

  function _openNav(e){
    triggerCustomEvent(document, 'body:lock', {
      breakpoints: 'all'
    });
    window.requestAnimationFrame(function(){
      document.documentElement.classList.add(klass);
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
    document.documentElement.classList.remove(klass);
    setTimeout(function(){ setFocusOnTarget(document.getElementById('a17')); }, 0)
    active = false;
  }

  function _openSubNav(e){
    this.parentElement.classList.toggle('nav-is-open');

    if(!this.parentElement.classList.contains('g-footer-nav__expander-trigger')){
      navLevel++;

      checkLevel();
    }

    e.preventDefault();
    e.stopPropagation();
  };

  function _goBack(e){
    this.closest('.g-nav-mobile__subnav').previousElementSibling.classList.remove('nav-is-open');

    navLevel--;

    checkLevel();

    e.preventDefault();
    e.stopPropagation();
  }

  function checkLevel(){
    if(navLevel > 0){
      container.classList.add(subnavKlass);
    }else{
      container.classList.remove(subnavKlass);
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
