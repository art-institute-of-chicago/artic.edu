// frontend/js/behaviors/digitalExplorer/digitalExplorer.js
import React from 'react';
import ReactDOM from 'react-dom';
import DigitalExplorer from 'digital-explorer';

export default function digitalExplorer(container) {
  console.log('🎯 digitalExplorer behavior instantiated', container);

  let mounted = false;

  function _init() {
    console.log('🚀 digitalExplorer._init() called');

    let explorerData;

    try {
      // Extract JSON from script tag, following closer-look pattern
      const contentBundleScript = document.querySelector('[data-digitalExplorer-contentBundle]');

      if (!contentBundleScript) {
        console.error('❌ No content bundle script found');
        explorerData = {};
      } else {
        explorerData = JSON.parse(contentBundleScript.innerHTML);
        console.log('✅ Parsed explorerData:', explorerData);
      }
    } catch (e) {
      console.error('❌ Failed to parse explorerData:', e);
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
    console.log('✅ Digital Explorer mounted successfully');

    // Handle header behavior
    if (window.scrollY < 100) {
      document.documentElement.classList.remove('s-header-hide');
    }
  }

  this.destroy = function() {
    console.log('🔥 Destroying Digital Explorer');

    if (mounted) {
      ReactDOM.unmountComponentAtNode(container);
      mounted = false;
    }

    // Clean up global reference
    delete window.digitalExplorer;

    // Remove properties of this behavior (if you have A17.Helpers available)
    // A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
}