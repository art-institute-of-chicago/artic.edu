import ReactDOM from 'react-dom/client';
import React, { useEffect } from 'react';
import MyMuseumTourBuilder from 'my-museum-tour';
import * as Sentry from "@sentry/react";

export default function myMuseumTourBuilder(container) {
  let root = null;

  this.init = function () {
    const hideObjectsFromTours = JSON.parse(container.dataset.hideObjectsFromTours);
    const hideGalleriesFromTours = JSON.parse(container.dataset.hideGalleriesFromTours);
    let sentryDsn = container.getAttribute('data-dsn');

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

    const HeaderCleanup = () => {
      useEffect(() => {
        if (window.scrollY < 100) {
          document.documentElement.classList.remove('s-header-hide');
        }
      }, []);
      return null;
    };

    root = ReactDOM.createRoot(container);
    root.render(
      <React.Fragment>
        <MyMuseumTourBuilder
          hideObjectsFromTours={hideObjectsFromTours}
          hideGalleriesFromTours={hideGalleriesFromTours}
        />
        <HeaderCleanup />
      </React.Fragment>
    );
  }

  this.destroy = function () {
    if (root) {
      root.unmount();
      root = null;
    }
  }
}
