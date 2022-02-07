import { forEach } from '@area17/a17-helpers';

const linksBar = function(container) {

  function _measureAndHideShow() {
    let isTabs = (container.className.indexOf('tabs') > 0);
    let primaryLinks = container.querySelector('[data-links-bar-primary]');
    let primaryLinksOverflow = container.querySelector('[data-links-bar-primary-overflow]');
    let primaryLinksOverflowDropdownList = primaryLinksOverflow.querySelector('[data-dropdown-list]');
    //
    if (!primaryLinks || !primaryLinksOverflow) {
      return;
    }
    //
    let maxWidth = 0;
    let childWidths = [];
    let childWidthsTotal = 0;
    let tooWide = false;
    let marginLeft = 20;
    // Reset the lists
    container.classList.remove('s-overflowing');
    primaryLinksOverflow.classList.add('s-hidden');
    primaryLinks.classList.add('s-measuring');
    forEach(primaryLinks.children, function(index, li) {
      if (li !== primaryLinksOverflow) {
        li.classList.remove('s-hidden');
      }
    });
    forEach(primaryLinksOverflowDropdownList.children, function(index, li) {
      li.classList.add('s-hidden');
    });
    // Now find out the widths of the children and if we push too wide
    // This happens while the overflow list is hidden
    maxWidth = primaryLinks.offsetWidth - marginLeft;
    forEach(primaryLinks.children, function(index, li) {
      if (li === primaryLinksOverflow) {
        return;
      }
      let thisWidth = li.offsetWidth + marginLeft;
      childWidthsTotal += thisWidth;
      childWidths.push(thisWidth);
      if (childWidthsTotal > maxWidth) {
        tooWide = true;
      }
    });
    // If we're pushing too wide, we need to show the overflow list and populate it
    // Now we adjust to account for the width of the overflow list
    if (tooWide) {
      primaryLinksOverflow.classList.remove('s-hidden');
      if (isTabs) {
        forEach(primaryLinks.children, function(index, li) {
          if (li !== primaryLinksOverflow) {
            li.classList.add('s-hidden');
          }
        });
        forEach(primaryLinksOverflowDropdownList.children, function(index, li) {
          li.classList.remove('s-hidden');
        });
      } else {
        maxWidth -= primaryLinksOverflow.offsetWidth;
        childWidthsTotal = 0;
        forEach(childWidths, function(index, value) {
          childWidthsTotal += value;
          if (childWidthsTotal > maxWidth) {
            primaryLinks.children[index].classList.add('s-hidden');
            primaryLinksOverflowDropdownList.children[index].classList.remove('s-hidden');
          }
        });
      }
      container.classList.add('s-overflowing');
    }
    primaryLinks.classList.remove('s-measuring');
  }

  function _init() {
    document.addEventListener('resized', _measureAndHideShow, false);
    _measureAndHideShow();
  }

  this.destroy = function() {
    // Remove specific event handlers
    document.removeEventListener('touchend', _measureAndHideShow);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default linksBar;
