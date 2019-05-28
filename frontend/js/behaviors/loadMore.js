import { purgeProperties, forEach, ajaxRequest, triggerCustomEvent } from '@area17/a17-helpers';

const loadMore = function(container) {
  var ajaxUrl = container.getAttribute('data-load-more-url');
  var target = container.getAttribute('data-load-more-target');
  var limitText = container.getAttribute('data-load-more-limit-text');
  var $target = document.querySelector(target);
  var page = 1;
  var ajaxTimer;
  var loaderKlass = 's-loading';
  var hideKlass = 's-hidden';
  var maxPage = 20;

  function _showLoader() {
    container.classList.add(loaderKlass);
  }

  function _hideLoader() {
    container.classList.remove(loaderKlass);
  }

  function _hideLoadMore() {
    // Hide link
    container.classList.add(hideKlass);

    // Add message
    let h2 = document.createElement('h2');
    h2.setAttribute('class','title f-list-3');
    h2.textContent = 'Sorry, we limit the results for any query after 20 pages.';
    container.parentNode.appendChild(h2);

    let p = document.createElement('p');
    p.setAttribute('class','f-caption');
    p.textContent = 'Try using our filters to refine your search.' + (limitText ? ' ' + limitText : '');
    container.parentNode.appendChild(p);
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
            } else {
              triggerCustomEvent(document, 'page:updated');
            }
          } catch (err) {
            console.error('Error updating autocomplete: '+ err);
          }

          _hideLoader();

          if (page >= maxPage) {
            _hideLoadMore();
          }
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
