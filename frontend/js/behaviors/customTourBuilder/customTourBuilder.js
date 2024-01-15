import ReactDOM from 'react-dom';
import React from 'react';
import CustomTourBuilder from 'custom-tour-builder';

export default function customTourBuilder(container) {
  this.init = function () {
    ReactDOM.render(
      <CustomTourBuilder
        heroImageId="3c27b499-af56-f0d5-93b5-a7f2f1ad5813"
      />,
      container,
      () => {
        // This is informed by where I think the header scroll hiding is happening
        // See: frontend/js/functions/core/setScrollDirection.js
        // Catch if the scroll is below the threshold and remove the class
        if (window.scrollY < 100) {
          document.documentElement.classList.remove('s-header-hide');
        }
      }
    );
  }
  this.destroy = function () {
    ReactDOM.unmountComponentAtNode(container);
  }
}
