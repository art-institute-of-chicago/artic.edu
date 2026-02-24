import React from 'react';
import { createRoot } from 'react-dom/client';
import DigitalExplorer from 'digital-explorer';

export default function digitalExplorer(container) {
  let mounted = false;
  let root = null;

  function _init() {
    const contentBundleScript = document.querySelector('[data-digitalExplorer-contentBundle]');
    const explorerData = contentBundleScript ? JSON.parse(contentBundleScript.innerHTML) : {};

    window.digitalExplorer = explorerData;

    const props = {
      models: explorerData.models || [],
      lights: explorerData.lights || [],
      annotations: explorerData.annotations || [],
      settings: explorerData.settings || {},
      type: explorerData.type || '3d',
      title: explorerData.title,
      slug: explorerData.slug
    };

    root = createRoot(container);
    root.render(<DigitalExplorer {...props} />);

    mounted = true;

    if (window.scrollY < 100) {
      document.documentElement.classList.remove('s-header-hide');
    }
  }

  this.destroy = function() {
    if (mounted && root) {
      root.unmount();
      root = null;
      mounted = false;
    }

    delete window.digitalExplorer;
  };

  this.init = function() {
    _init();
  };
}
