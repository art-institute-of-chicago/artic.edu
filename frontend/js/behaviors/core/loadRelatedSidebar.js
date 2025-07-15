import { triggerCustomEvent, ajaxRequest } from '@area17/a17-helpers';

const loadRelatedSidebar = function(container) {
    let model = container.getAttribute('data-target-model');
    let id = container.getAttribute('data-target-id');

    function requestSidebarData()
    {
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
        const gallery = document.querySelectorAll('.o-gallery--mosaic')[0];
        const distance = getDistanceBetweenElements(container, gallery);
        const listings = container.querySelectorAll('.m-listing');

        if (distance < 0) {
            listings.forEach((listing, index) => {
                if (index !== 0) {
                    listing.classList.add('hidden');
                }
            });
        }
    }
    function getDistanceBetweenElements(element1, element2) {
      if (element1 && element2) {
        const rect1 = element1.getBoundingClientRect();
        const rect2 = element2.getBoundingClientRect();

        const rect1bottom = rect1.bottom + window.scrollY;
        const rect2top = rect2.top + window.scrollY;

        const distance = rect2top - rect1bottom;

        return distance;
      }

      return null;
    }

    function _inject(data)
    {
        if (container) {
            let parsed = JSON.parse(data);
            container.innerHTML = parsed.html;
            heightAwareSidebar();
        }

        triggerCustomEvent(document, 'page:updated');
        if (window.picturefill) {
            window.picturefill();
        }
    }

    function _init() {
        requestSidebarData();
    }

    this.init = function() {
        _init();
    };
}

export default loadRelatedSidebar;