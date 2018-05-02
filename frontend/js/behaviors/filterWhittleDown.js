import { purgeProperties, ajaxRequest} from '@area17/a17-helpers';

const filterWhittleDown = function(container) {

  const $input = container.querySelector('input');
  const ajaxUrl = container.getAttribute('data-filter-whittle-down-url');
  const $target = container.nextElementSibling;
  let ajaxTimer;

  function _showLoader() {
    container.classList.add('s-loading');
  }

  function _hideLoader() {
    container.classList.remove('s-loading');
  }

  function _whittleDown() {
    clearTimeout(ajaxTimer);

    _showLoader();

    ajaxTimer = setTimeout(function(){
      if ($input.value === '') {
        container.classList.remove('s-whittling');
      } else {
        container.classList.add('s-whittling');
      }
      ajaxRequest({
        url: ajaxUrl,
        data: { categoryQuery: $input.value },
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
            $target.innerHTML = parsed.html;
          } catch (err) {
            console.error('Error updating filters: '+ err);
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

  function _init() {
    $input.addEventListener('input', _whittleDown, false);
    container.addEventListener('submit', _whittleDown, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    $input.removeEventListener('input', _whittleDown);
    container.removeEventListener('submit', _whittleDown);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default filterWhittleDown;
