const toggleFee = function(container) {

    container.addEventListener('click', function() {
        showFee.call(this);
            selectCategory.call(this);
        });
      
        function showFee() {
          const targetAttribute = this.getAttribute('data-target');
        
          // Remove "selected" class from all elements with class "fee-ages"
          const feeAges = document.querySelectorAll('.fee-ages.selected');
          feeAges.forEach(element => {
            element.classList.remove('selected');
          });
        
          // Find the element with the matching ID and add the "selected" class
          const targetElement = document.getElementById(targetAttribute);
          if (targetElement) {
            targetElement.classList.add('selected');
          }
        }
      
        function selectCategory() {
          const categories = document.querySelectorAll('[data-behavior="toggleFee"]');
          
          categories.forEach(element => {
            element.classList.remove('selected');
          });
      
          container.classList.add('selected');
        }
      };      

export default toggleFee;