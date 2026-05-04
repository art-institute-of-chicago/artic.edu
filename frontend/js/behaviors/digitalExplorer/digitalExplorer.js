import React from 'react';
import { createRoot } from 'react-dom/client';
import DigitalExplorer from 'digital-explorer';

export default function digitalExplorer(container) {
  let mounted = false;
  let root = null;

  const preventPinchZoom = (e) => {
    if (e.ctrlKey) {
      e.preventDefault();
    }
  };

  const preventGesture = (e) => {
    e.preventDefault();
  };


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

    document.addEventListener('wheel', preventPinchZoom, { passive: false });
    document.addEventListener('gesturestart', preventGesture);
    document.addEventListener('gesturechange', preventGesture);
    document.addEventListener('gestureend', preventGesture);


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

    document.removeEventListener('wheel', preventPinchZoom);
    document.removeEventListener('gesturestart', preventGesture);
    document.removeEventListener('gesturechange', preventGesture);
    document.removeEventListener('gestureend', preventGesture);


    delete window.digitalExplorer;
  };

  this.init = function() {
    _init();
  };
}
