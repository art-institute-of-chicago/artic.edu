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


  function _onExplorerClick() {
    document.documentElement.classList.add('s-hide-header');
  }

  function _init() {
    const contentBundleScript = document.querySelector('[data-digitalExplorer-contentBundle]');

    if (!contentBundleScript) {
      return;
    }

    const explorerData = JSON.parse(contentBundleScript.innerHTML);

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

    container.addEventListener('click', _onExplorerClick);
    container.addEventListener('pointerdown', _onExplorerClick);

    // Scrollable exit region so users can scroll past the viewer
    if (!container.classList.contains('kioskMode')) {
      const exitFooter = document.createElement('div');
      exitFooter.className = 'o-digital-explorer__exit';
      exitFooter.setAttribute('aria-label', 'Hover to exit');
      exitFooter.setAttribute('tabindex', '0');
      exitFooter.innerHTML = `
        <div class="o-digital-explorer__exit-handle">Hover to exit</div>
        <div class="o-digital-explorer__exit-inner">
          <p>Scroll down to continue</p>
        </div>
      `;
      container.parentNode.insertBefore(exitFooter, container.nextSibling);

      const exitObserver = new IntersectionObserver(([entry]) => {
        const hidden = !entry.isIntersecting;
        exitFooter.classList.toggle('s-hidden', hidden);
        if (hidden) {
          document.documentElement.classList.remove('s-hide-header');
        }
      }, { threshold: 0.5 });
      exitObserver.observe(container);
    }

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

    container.removeEventListener('click', _onExplorerClick);
    container.removeEventListener('pointerdown', _onExplorerClick);

    document.documentElement.classList.remove('s-hide-header');

    const exitFooter = document.querySelector('.o-digital-explorer__exit');
    if (exitFooter) {
      exitFooter.remove();
    }

    delete window.digitalExplorer;
  };

  this.init = function() {
    _init();
  };
}
