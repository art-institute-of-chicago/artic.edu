import ReactDOM from 'react-dom';
import React from 'react';
import MyMuseumTourBuilder from 'my-museum-tour-builder';

export default function myMuseumTourBuilder(container) {
  this.init = function () {
    let dataString = container.getAttribute('data-hide-from-tours');
    const hideFromTours = dataString.length > 0 ? dataString.split(",") : [];
    console.log(hideFromTours);

    ReactDOM.render(
      <MyMuseumTourBuilder
        hideFromTours={hideFromTours}
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
