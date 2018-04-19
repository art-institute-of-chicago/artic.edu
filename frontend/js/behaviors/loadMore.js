import { purgeProperties, forEach, ajaxRequest, triggerCustomEvent } from '@area17/a17-helpers';

const loadMore = function(container) {
  var ajaxUrl = container.getAttribute('data-load-more-url');
  var target = container.getAttribute('data-load-more-target');
  var $target = document.querySelector(target);
  var page = 1;
  var ajaxTimer;
  var loaderKlass = 's-loading';
  var hideKlass = 's-hidden';

  function _showLoader() {
    container.classList.add(loaderKlass);
  }

  function _hideLoader() {
    container.classList.remove(loaderKlass);
  }

  function _doAjax() {
    clearTimeout(ajaxTimer);

    _showLoader();

    ajaxTimer = setTimeout(function(){
      ajaxRequest({
        url: ajaxUrl,
        data: { page: page },
        type: 'GET',
        requestHeaders: [
          {
            header: 'Content-Type',
            value: 'application/x-www-form-urlencoded; charset=UTF-8'
          }
        ],
        onSuccess: function(data){
          try {
            var parsed = JSON.parse(data);

            $target.innerHTML += parsed.html;

            if( !parsed.page ){
              container.classList.add(hideKlass);
            }

            if ($target.classList.contains('o-pinboard')) {
              triggerCustomEvent($target, 'pinboard:contentAdded');
            }
          } catch (err) {
            console.error('Error updating autocomplete: '+ err);
          }
          _hideLoader();
        },
        onError: function(data){
          console.error('Error: '+ data);
          _hideLoader();
        }
      });
    }, 250);
  }

  function _handleClicks(event){
    event.preventDefault();
    event.stopPropagation();
    page++;
    _doAjax();
  }

  function _init() {
    container.addEventListener('click', _handleClicks, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('click', _handleClicks);

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
}
export default loadMore;
