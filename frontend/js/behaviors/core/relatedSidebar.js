const relatedSidebar = function(container){

  const outerHeight = element => {
    var height = element.offsetHeight;
    var style = getComputedStyle(element);

    height += parseInt(style.marginTop) + parseInt(style.marginBottom);
    return height;
  }

  let article = document.querySelector('.o-article__body');
  let sidebar = document.querySelector('.o-article__secondary-actions');
  let sidebarItems = sidebar.querySelectorAll('.m-listing');

  let articleResetClass = 'o-article--disable-float-clear';
  let sidebarItemVisibleClass = 'm-listing--visible';

  function update() {
    article.classList.add(articleResetClass);

    sidebarItems.forEach(function(sidebarItem) {
      sidebarItem.classList.add(sidebarItemVisibleClass);
    });

    let articleHeight = outerHeight(article);
    let sidebarHeight = outerHeight(sidebar);
    let hiddenSidebarItemCount = 0;

    while (sidebarHeight > articleHeight && hiddenSidebarItemCount < sidebarItems.length) {
      sidebarItems[sidebarItems.length - (hiddenSidebarItemCount + 1)].classList.remove(sidebarItemVisibleClass);
      sidebarHeight = outerHeight(sidebar);
      hiddenSidebarItemCount++;
    }

    article.classList.remove(articleResetClass);
  }

  function _init() {
    window.addEventListener('resized', update);

    update();
  }

  this.destroy = function() {
    window.removeEventListener('resized', update);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default relatedSidebar;
