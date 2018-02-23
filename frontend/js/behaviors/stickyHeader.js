import { purgeProperties, triggerCustomEvent } from '@area17/a17-helpers';

const stickyHeader = function(container) {
  var dE = document.documentElement;
  var featureHeader = document.querySelector('.m-article-header--feature');
  var heroHeader = document.querySelector('.m-article-header--hero');
  var superHeroHeader = document.querySelector('.m-article-header--super-hero');
  var gHeaderH = container.clientHeight;
  var headerH = 0;

  function _scrolling(e){
    var st = e.data.y;

    if( st > 100 ){
      dE.classList.add('s-header-hide');
    }else{
      dE.classList.remove('s-header-hide');
    }

    if( headerH > 0 && st < headerH - gHeaderH ){
      dE.classList.add('s-header-on-hero');
    }else{
      dE.classList.remove('s-header-on-hero');
    }
  }

  function _setVars(){
    var gHeaderH = container.clientHeight;

    if( featureHeader ){
      var textH = document.querySelector('.m-article-header__text').clientHeight || 0;
      headerH = featureHeader.clientHeight - textH;

    }else if( heroHeader ){
      headerH = heroHeader.clientHeight;
    }else if( superHeroHeader ){
      headerH = superHeroHeader.clientHeight;
    }
  }

  function _init() {
    _setVars();

    window.addEventListener('resized', _setVars, false);
    document.addEventListener('scroll:active', _scrolling, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    window.removeEventListener('resized', _setVars);
    document.removeEventListener('scroll:active', _scrolling);

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default stickyHeader;
