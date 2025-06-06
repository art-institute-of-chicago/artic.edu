import { triggerCustomEvent } from '@area17/a17-helpers';

const setScrollDirection = function() {
  const dE = document.documentElement;
  const header = document.getElementsByClassName('g-header')[0];
  const topLink = document.getElementsByClassName('m-sidebar-toggle')[0];
  const articleBody = document.getElementsByClassName('o-article__body')[0];

  let lastScrollTop = 0;
  let scrollDirection = false;
  let hideHeader = false;
  let allowTopLink = false;
  let machineScroll = false;
  let maxScroll = 0;
  let lastMaxScroll = -1;
  let scrollChecks = {
    25: {
      pos: 0,
      hit: false
    },
    50: {
      pos: 0,
      hit: false
    },
    75: {
      pos: 0,
      hit: false
    },
    100: {
      pos: 0,
      hit: false
    }
  };

  function _scrollPercentVars() {
    for (let scrollCheck in scrollChecks) {
      let percent = (scrollCheck === 100) ? (scrollCheck - 5)/100 : scrollCheck/100;
      scrollChecks[scrollCheck].pos = parseInt(maxScroll * percent, 10);
      scrollChecks[scrollCheck].hit = false;
    }
  }

  function _calcMaxScroll() {
    return Math.max(document.body.scrollHeight, document.body.offsetHeight, document.documentElement.clientHeight, document.documentElement.scrollHeight, document.documentElement.offsetHeight) - window.innerHeight;
  }

  function _init() {
    let sT = document.documentElement.scrollTop || document.body.scrollTop;
    maxScroll = _calcMaxScroll();

    if (lastMaxScroll != maxScroll) {
      lastMaxScroll = maxScroll;
      _scrollPercentVars();
    }

    if (sT !== lastScrollTop && !machineScroll) {

      if (maxScroll > 150) {
        for (let scrollCheck in scrollChecks) {
          if (sT >= scrollChecks[scrollCheck].pos && !scrollChecks[scrollCheck].hit) {
            scrollChecks[scrollCheck].hit = true;

            // Don't trigger this event on the interactive features
            if( window.location.href.indexOf('/interactive-features') === -1 ){
              triggerCustomEvent(document, 'gtm:push', {
                'event': (dE.classList.contains('p-artworks-show') ? 'artwork-' : '' ) + scrollCheck + '%',
                'eventCategory': 'scroll-tracking',
              });
            }
          }
        }
      }

      //triggerCustomEvent(document, 'scroll:active', { 'y': sT });
      if (sT > 100 && !hideHeader){
        if (!dE.classList.contains('s-unsticky-header')) {
          dE.classList.add('s-header-hide');
          hideHeader = true;
        }
      } else if (sT <= 100 && hideHeader) {
        dE.classList.remove('s-header-hide');
        hideHeader = false;
      }

      if (topLink.getBoundingClientRect().y <= 0 && !allowTopLink){
        if (articleBody) {
          let marginTop = parseInt(window.getComputedStyle(articleBody).getPropertyValue('margin-top'), 10);
          let styling = `margin-top: ${marginTop + topLink.offsetHeight}px !important;`
          articleBody.style.cssText += styling;
        }
        dE.classList.add('s-allow-top-link');
        allowTopLink = true;
      } else if (sT <= header.offsetHeight && allowTopLink) {
        if (articleBody) {
          articleBody.style.marginTop = 'unset';
        }
        dE.classList.remove('s-allow-top-link');
        allowTopLink = false;
      }

      if (sT > lastScrollTop + 10 && scrollDirection !== 'down') {
        scrollDirection = 'down';
        dE.classList.remove('s-scroll-direction-up');
        dE.classList.add('s-scroll-direction-down');
        //triggerCustomEvent(document, 'scroll:down', { 'y': sT });
      } else if (sT < lastScrollTop - 10 && scrollDirection !== 'up') {
        scrollDirection = 'up';
        dE.classList.remove('s-scroll-direction-down');
        dE.classList.add('s-scroll-direction-up');
        //triggerCustomEvent(document, 'scroll:up', { 'y': sT });
      } else {
        lastScrollTop = sT;
      }
    } else {
      lastScrollTop = sT;
    }

    window.requestAnimationFrame(_init);
  }

  document.addEventListener('setScrollDirection:machineScroll', function(event){
    window.requestAnimationFrame(function(){
      lastScrollTop = -1;
      machineScroll = event.data.machineScroll;
    });
  }, false);

  document.addEventListener('page:updated', function(event){
    lastMaxScroll = -1;
  }, false);

  _init();
};

export default setScrollDirection;
