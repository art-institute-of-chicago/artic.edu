import { ajaxRequest } from '@area17/a17-helpers';

const exploreFurther = function (container) {

    let injectContainer = document.getElementsByClassName('explore-further-injected')[0];

    function loadExploreFurther() {
        console.log('loadExploreFurther');
        removeActiveClasses();
        container.parentElement.classList.add('s-active');
    
        let url = container.getAttribute('data-ajax-url-target');
    
        ajaxRequest({
            url: url,
            type: 'GET',
            onSuccess: function (responseText) {
                try {
                    const injectData = JSON.parse(responseText);
                    console.log(injectData);
    
                    if (injectData && injectData.html) {
                        injectContainer.innerHTML = injectData.html;
                    } else {
                        console.error("Invalid response format or empty data:", injectData);
                    }
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                }
            },
            onError: function (error) {
                console.error("Error during ajax request:", error);
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
        container.addEventListener('click', loadExploreFurther, false);
    }

    this.init = function () {
        _init();
    };
}

export default exploreFurther;
