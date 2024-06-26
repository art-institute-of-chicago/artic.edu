import ReactDOM from 'react-dom';
import React from 'react';
import MyMuseumTourBuilder from 'my-museum-tour-builder';
import * as Sentry from "@sentry/react";

export default function myMuseumTourBuilder(container) {
  this.init = function () {
    let dataString = container.getAttribute('data-hide-from-tours');
    let sentryDsn = container.getAttribute('data-dsn');
    const hideFromTours = dataString.length > 0 ? dataString.split(",") : [];

    Sentry.init({
      dsn: sentryDsn,
      integrations: [
        Sentry.browserTracingIntegration(),
        Sentry.replayIntegration({
          maskAllText: false,
          blockAllMedia: false,
        }),
      ],
      tracesSampleRate: 1.0,
      replaysSessionSampleRate: 0.1,
      replaysOnErrorSampleRate: 1.0,
    });

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
