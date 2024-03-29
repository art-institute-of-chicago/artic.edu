const toggleFee = function(container) {

  function showFee() {

    let targetAttribute;

    if (this.value) {
      targetAttribute = this.value;
    } else {
      targetAttribute = this.getAttribute('data-target');
    }

    // Remove "selected" class from all elements with class "fee-ages"
    const feeAges = document.querySelectorAll('.selected');
    feeAges.forEach(element => {
      element.classList.remove('selected');
    });

    // Find the element with the matching ID and add the "selected" class
    const targetElements = document.querySelectorAll('[id="'+targetAttribute+'"]');
    if (targetElements) {
      targetElements.forEach(element => {
        element.classList.add('selected');
      })
    }
  }

  function selectCategoryButton() {
    const categories = document.querySelectorAll('[data-behavior="toggleFee"]');

    categories.forEach(element => {
      element.classList.remove('selected');
    });

    container.classList.add('selected');
  }

  function _init() {
    if (container.tagName === 'SELECT') {
      container.addEventListener('change', showFee, false);
    } else {
      container.addEventListener('click', showFee, false);
      container.addEventListener('click', selectCategoryButton, false);
    }
  }

  this.init = function() {
      _init();
  };
}

export default toggleFee;
