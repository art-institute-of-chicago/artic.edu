import React from 'react';
import ReactDOM from 'react-dom';
import DigitalExplorer from 'digital-explorer';

export default function digitalExplorer(container) {
  let mounted = false;

  function _init() {
    let explorerData;

    try {
      // Extract JSON from script tag, following closer-look pattern
      const contentBundleScript = document.querySelector('[data-digitalExplorer-contentBundle]');
      explorerData = contentBundleScript ? JSON.parse(contentBundleScript.innerHTML) : {};

    } catch (e) {
      explorerData = {};
    }

    // Store in window for debugging (optional, like closer-look does)
    window.digitalExplorer = explorerData;

    // Prepare props for the component
    const props = {
      models: explorerData.models || [],
      lights: explorerData.lights || [],
      annotations: explorerData.annotations || [],
      settings: explorerData.settings || {},
      type: explorerData.type || '3d',
      title: explorerData.title,
      slug: explorerData.slug
    };

    // Use React 16's render method
    ReactDOM.render(
      <DigitalExplorer {...props} />,
      container
    );

    mounted = true;

    // Handle header behavior
    if (window.scrollY < 100) {
      document.documentElement.classList.remove('s-header-hide');
    }
  }

  this.destroy = function() {
    if (mounted) {
      ReactDOM.unmountComponentAtNode(container);
      mounted = false;
    }

    delete window.digitalExplorer;

  };

  this.init = function() {
    _init();
  };
}