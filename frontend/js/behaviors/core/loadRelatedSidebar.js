import { triggerCustomEvent, ajaxRequest } from '@area17/a17-helpers';

const loadRelatedSidebar = function(container) {
  let model = container.getAttribute('data-target-model');
  let id = container.getAttribute('data-target-id');
  let sidebar = document.querySelector('#related-sidebar-items');
  
  function requestSidebarData() {
    ajaxRequest({
      url: `/ajaxData?q=relatedSidebarItems&model=${model}&id=${id}`,
      type: 'GET',
      onSuccess: function(data) {
        try {
          _inject(data);
        } catch (err) {
          console.log(err);
        }
      },
      onError: function(data) {
        console.log(data);
      }
    });
  }
  
  function heightAwareSidebar() {
    const sidebar = document.querySelector('#related-sidebar-items');
    const gallery = document.querySelectorAll('.o-gallery--mosaic')[0];
    
    if (sidebar && gallery) {
      const distance = getDistanceBetweenElements(sidebar, gallery);
      const listings = sidebar.querySelectorAll('.m-listing');
      
      if (distance < 0) {
        listings.forEach((listing, index) => {
          if (index !== 0) {
            listing.classList.add('hidden');
          }
        });
      }
    }
  }
  
  function getDistanceBetweenElements(element1, element2) {
    const rect1 = element1.getBoundingClientRect();
    const rect2 = element2.getBoundingClientRect();
    const rect1bottom = rect1.bottom + window.scrollY;
    const rect2top = rect2.top + window.scrollY;
    const distance = rect2top - rect1bottom;
    return distance;
  }
  
  function moveRelatedContainer() {
    const relatedContainer = document.querySelector('.o-article__secondary-actions');
    const articleBody = document.querySelector('.o-article__body');
    
    relatedContainer.parentNode.removeChild(relatedContainer);
    
    if (window.innerWidth < 900) {
      if (articleBody.nextSibling) {
        articleBody.parentNode.insertBefore(relatedContainer, articleBody.nextSibling);
      } else {
        articleBody.parentNode.appendChild(relatedContainer);
      }
    } else {
      articleBody.parentNode.insertBefore(relatedContainer, articleBody);
    }
  }
  
  function _inject(data) {
    if (sidebar) {
      let parsed = JSON.parse(data);
      sidebar.innerHTML = parsed.html;
      heightAwareSidebar();
    }
    
    setTimeout(moveRelatedContainer, 50);
    triggerCustomEvent(document, 'page:updated');
    if (window.picturefill) {
      window.picturefill();
    }
  }
  
  function _init() {
    requestSidebarData();
    
    let resizeTimer;
    window.addEventListener('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(moveRelatedContainer, 100);
    });
    
    setTimeout(moveRelatedContainer, 100);
  }
  
  this.init = function() {
    _init();
  };
};

export default loadRelatedSidebar;