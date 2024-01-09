import { triggerCustomEvent, ajaxRequest } from '@area17/a17-helpers';

const exploreFurther = function(container) {
    let injectContainer = document.getElementsByClassName('explore-further-injected')[0];

    function _inject(content) {
        injectContainer.innerHTML = content;
        triggerCustomEvent(document, 'page:updated');
        if (window.picturefill) {
            window.picturefill();
        }
    }

    function loadExploreFurther(url) {
        injectContainer.classList.add('s-loading');
        removeActiveClasses();
        container.parentElement.classList.add('s-active');

        ajaxRequest({
            url: url,
            type: 'GET',
            onSuccess: function(data) {
                try {
                    var parsed = JSON.parse(data);
                    _inject(parsed.html);
                    injectContainer.classList.remove('s-loading');
                } catch (err) {
                    console.log(err);
                    injectContainer.classList.remove('s-loading');
                }
            },
            onError: function(data) {
                console.log(data);
                injectContainer.classList.remove('s-loading');
            }
        });
    }

    function removeActiveClasses() {
        let activeContainers = document.querySelectorAll('.s-active');
        activeContainers.forEach(element => {
            element.classList.remove('s-active');
        });
    }

    function _init() {
        let firstCategory = document.querySelectorAll('[data-ajax-url-target]')[0];

        if (!firstCategory.parentElement.classList.contains('s-active')) {
            firstCategory.parentElement.classList.add('s-active');
            loadExploreFurther(firstCategory.getAttribute('data-ajax-url-target'));
        }

        container.addEventListener('click', function() {
            let url = container.getAttribute('data-ajax-url-target');
            loadExploreFurther(url);
        }, false);
    }

    this.destroy = function() {
        A17.Helpers.purgeProperties(this);
    };

    this.init = function() {
        _init();
    };
};

export default exploreFurther;
