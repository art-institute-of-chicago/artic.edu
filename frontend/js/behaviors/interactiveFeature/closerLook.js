import ReactDOM from 'react-dom/client';
import React from 'react';
import * as CloserLookModule from 'closer-look';
import getAbsoluteHeight from '../../functions/core/getAbsoluteHeight';

if (typeof ReactDOM.findDOMNode !== 'function') {
  ReactDOM.findDOMNode = (instance) => {
    if (!instance) return null;
    if (instance instanceof HTMLElement) return instance;
    try {
      return instance.updater?.getPublicInstance() || null;
    } catch (e) {
      return null;
    }
  };
}

const CloserLook = CloserLookModule.default;
const Modal = CloserLookModule.Modal;

const closerLook = function(container) {
  const elements = [];
  const $a17 = document.getElementById('a17');
  const nextSibling = container.nextElementSibling;
  let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
  let ticking = false;
  let root = null; // Track the React 19 root instance

  function update() {
    ticking = false;

    const diff = Math.abs(Math.min(0, container.offsetHeight - window.innerHeight - scrollTop));
    const fromBottom = window.innerHeight * -1 + diff;
    const isStuck = fromBottom <= 0;

    document.documentElement.classList.toggle('s-closer-look-footer-stuck', isStuck);

    let elementsOffsetHeight = 0;

    if (elements.length > 0) {
      elements.forEach(function(element) {
        if (element) {
          element.style.position = isStuck ? 'fixed' : null;
          element.style.top = isStuck ? `${elementsOffsetHeight}px` : null;
          elementsOffsetHeight += getAbsoluteHeight(element);
        }
      });
    }

    if ($a17) {
      $a17.style.minHeight = `${container.offsetHeight + elementsOffsetHeight}px`;
    }
  }

  function requestTick() {
    if (!ticking) {
      requestAnimationFrame(update);
    }
    ticking = true;
  }

  function handleScroll() {
    scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    requestTick();
  }

  function handleFocus() {
    if (nextSibling && nextSibling.contains(document.activeElement) && scrollTop < container.offsetHeight) {
      window.scrollTo(0, container.offsetHeight);
    }
  }

  function _init() {
    window.scrollTo(0, 0);
    window.addEventListener('scroll', handleScroll);
    handleScroll();

    document.addEventListener('focusin', handleFocus);
    handleFocus();

    let target = container;
    while ((target = target.nextElementSibling)) {
      elements.push(target);
    }

    const footer = document.getElementById('footer');
    if (footer) {
      elements.push(footer);
    }

    const contentBundleData = document.querySelector('[data-closerLook-contentBundle]');
    const assetLibraryData = document.querySelector('[data-closerLook-assetLibrary]');

    const props = {
      contentBundle: contentBundleData ? JSON.parse(contentBundleData.innerHTML) : {},
      assetLibrary: assetLibraryData ? JSON.parse(assetLibraryData.innerHTML) : {}
    };

    window.closerLook = props;

    // React 19 Root Initialization
    // Check both the named export and a potential property on the default export
    const ActiveModal = Modal || CloserLook.Modal;

    if (ActiveModal && typeof ActiveModal.setAppElement === 'function') {
      ActiveModal.setAppElement(container);
    } else {
      console.warn('Modal.setAppElement not found. Modal transitions may be misaligned.');
    }

    root = ReactDOM.createRoot(container);
    root.render(<CloserLook {...props} />);
  }

  this.destroy = function() {
    // Standard cleanup
    window.removeEventListener('scroll', handleScroll);
    document.removeEventListener('focusin', handleFocus);

    // React 19 Unmount
    if (root) {
      root.unmount();
      root = null;
    }

    // Clean up stuck classes
    document.documentElement.classList.remove('s-closer-look-footer-stuck');

    // Remove properties of this behavior
    if (window.A17 && A17.Helpers && A17.Helpers.purgeProperties) {
      A17.Helpers.purgeProperties(this);
    }
  };

  this.init = function() {
    _init();
  };
};

export default closerLook;
