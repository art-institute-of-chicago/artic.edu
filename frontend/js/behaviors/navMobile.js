import { purgeProperties, setFocusOnTarget, forEach, triggerCustomEvent, ajaxRequest } from '@area17/a17-helpers';
import { focusTrap } from '../functions';

const navMobile = function(container) {

  var navOpen = document.querySelector('[data-nav-mobile-open]');
  var navClose = document.querySelector('[data-nav-mobile-close]');
  var openTriggers = container.querySelectorAll('[data-nav-trigger]');
  var backTriggers = container.querySelectorAll('[data-nav-back]');
  var klass = 's-nav-mobile-active';
  var subnavKlass = 'js-subnav-open';
  var navLevel = 0;

  function _openNav(e){
    document.documentElement.classList.add(klass);

    _lockBody();

    e.preventDefault();
  }

  function _closeNav(e){
    document.documentElement.classList.remove(klass);

    _unlockBody();

    e.preventDefault();
  }

  function _openSubNav(e){
    this.classList.toggle('nav-is-open');

    if(!this.classList.contains('g-footer-nav__expander-trigger')){
      navLevel++;

      checkLevel();
    }

    e.preventDefault();
  };

  function _goBack(e){
    this.closest('.g-nav-mobile__subnav').previousElementSibling.classList.remove('nav-is-open');

    navLevel--;

    checkLevel();

    e.preventDefault();
  }

  function checkLevel(){
    if(navLevel > 0){
      container.classList.add(subnavKlass);
    }else{
      container.classList.remove(subnavKlass);
    }
  }

  function _lockBody(){
    triggerCustomEvent(document, 'body:lock', {
      breakpoints: 'all'
    });
    setFocusOnTarget(container);
    triggerCustomEvent(document, 'focus:trap', {
      element: container
    });
  }

  function _unlockBody(){
    triggerCustomEvent(document, 'body:unlock');
    triggerCustomEvent(document, 'focus:untrap');
    setFocusOnTarget(document.getElementById('a17'));
  }

  function _init() {
    navOpen.addEventListener('click', _openNav, false);
    navClose.addEventListener('click', _closeNav, false);

    forEach(openTriggers, function(index, openTrigger) {
      openTrigger.addEventListener('click', _openSubNav, false);
    });

    forEach(backTriggers, function(index, backTrigger) {
      backTrigger.addEventListener('click', _goBack, false);
    });
  }

  this.destroy = function() {
    // remove specific event handlers
    navOpen.removeEventListener('click', _openNav);
    navClose.removeEventListener('click', _closeNav);

    forEach(openTriggers, function(index, openTrigger) {
      openTrigger.removeEventListener('click', _openSubNav);
    });

    forEach(backTriggers, function(index, backTrigger) {
      backTrigger.removeEventListener('click', _goBack);
    });

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default navMobile;
