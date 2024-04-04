import { triggerCustomEvent, ajaxRequest } from '@area17/a17-helpers';

const editorialHeader = function(container) {
    let headerDate = document.getElementById('stories-header__date');
    let headerHours = document.getElementById('stories-header__hours');

    function _inject(data) {
        headerDate.innerHTML = data['date'];
        headerHours.innerHTML = data['hours'];
        triggerCustomEvent(document, 'page:updated');
        if (window.picturefill) {
            window.picturefill();
        }
    }

    function loadEditorialHeader() {
        ajaxRequest({
            url: '/landingPages/data/getEditorialHeader',
            type: 'GET',
            onSuccess: function(data) {
                try {
                    let parsedData = JSON.parse(data);
                    _inject(parsedData);
                } catch (err) {
                    console.log(err);
                }
            },
            onError: function(data) {
                console.log(data);
            }
        });
    }

    function _init() {
        loadEditorialHeader();
    }

    this.destroy = function() {
        A17.Helpers.purgeProperties(this);
    };

    this.init = function() {
        _init();
    };
};

export default editorialHeader;