import { triggerCustomEvent, ajaxRequest } from '@area17/a17-helpers';

const loadRelatedSidebar = function(container) {
    let model = container.getAttribute('data-target-model');
    let id = container.getAttribute('data-target-id');
    let sidebar = document.querySelector('#related-sidebar-items');

    function requestSidebarData()
    {
        ajaxRequest({
            url: '/ajaxData?q=relatedSidebarItems&model=' + model + '&id=' + id,
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
        const distance = getDistanceBetweenElements(sidebar, gallery);
        const listings = sidebar.querySelectorAll('.m-listing');

        console.log('Listings:', listings);

        if (distance < 0) {
            listings.forEach((listing, index) => {
                if (index !== 0) {
                    listing.classList.add('hidden');
                }
            });
        }
    }
    function getDistanceBetweenElements(element1, element2) {
        const rect1 = element1.getBoundingClientRect();
        const rect2 = element2.getBoundingClientRect();
    
        const rect1bottom = rect1.bottom + window.scrollY;
        const rect2top = rect2.top + window.scrollY;
    
        const distance = rect2top - rect1bottom;

        console.log('Distance between elements:', distance);
    
        return distance;
    }

    function _inject(data)
    {
        if (sidebar) {
            sidebar.innerHTML = data;
            heightAwareSidebar();
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