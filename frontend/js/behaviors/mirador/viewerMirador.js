import ReactDOM from 'react-dom/client';
import React from 'react';
import mirador from 'mirador';
import aicZoomButtonsPlugin from '../../libs/mirador/aicZoomButtonsPlugin.jsx';
import aicNavigationButtonsPlugin from '../../libs/mirador/aicNavigationButtonsPlugin.jsx';
import aicRemoveNavPlugin from '../../libs/mirador/aicRemoveNavPlugin.jsx';
import aicThumbnailCustomization from '../../libs/mirador/aicThumbnailCustomizationPlugin.jsx';

const viewerMirador = function(container) {
  let viewerId = 'm-viewer-mirador-' + container.dataset.id;
  let miradorInstance = null;

  const config = {
    id: viewerId,
    selectedTheme: 'aicTheme',
    themes: {
      aicTheme:{
        palette: {
          type: 'dark',
          primary: {
            main: '#fff',
          },
          shades: {
            dark: '#333',
            main: '#333',
            light: '#333',
          },
          background: {
            paper: '#757575',
          },
        },
        typography:{
          fontFamily: 'Ideal Sans A,Ideal Sans B,Helvetica,Arial,sans-serif',
        },
        overrides: {
          MuiToolbar: {
            root: {
              display: 'none',
            },
          },
          MuiTypography: {
            root: {
              display: 'none',
            },
          },
        },
      },
    },
    language: 'en',
    windows: [{
      loadedManifest: container.dataset.manifest,
    }],
    thumbnailNavigation: {
      defaultPosition: 'far-bottom',
      height: 130,
      width: 100,
    },
    createGenerateClassNameOptions: {
      productionPrefix: 'mirador-' + container.dataset.id,
    },
    window: {
      allowClose: false,
      allowFullscreen: false,
      allowTopMenuButton: false,
      allowWindowSideBar: false,
      allowMaximize: false,
      sideBarPanel: 'info',
      defaultView: container.dataset.view,
      hideWindowTitle: true,
      sideBarOpen: false,
      panels: {
        info: false,
        attribution: false,
        canvas: false,
        annotations: false,
        search: false,
        layers: false,
      },
    },
    workspace: {
      showZoomControls: false,
      type: 'mosaic',
    },
    workspaceControlPanel: {
      enabled: false,
    },
    osdConfig: {
      springStiffness: 15,
      visibilityRatio: 1,
      zoomPerScroll: 1.3,
      zoomPerClick: 1.3,
      animationTime: 1,
      maxZoomPixelRatio: 1,
      minZoomImageRatio: 1,
      minZoomLevel: 0,
      gestureSettingsMouse: {
        scrollToZoom: true,
        clickToZoom: true,
        dblClickToZoom: false,
      },
    },
  };

  // Define the cleanup function in the behavior scope
  const removeComponent = () => {
    if (miradorInstance) {
      miradorInstance = null;
    }
    const targetElement = document.querySelector('.g-modal--moduleMirador #' + viewerId);
    if (targetElement) {
      targetElement.innerHTML = ''; // This manually clears the Mirador instance from the DOM
    }
  };

  this.init = function() {
    miradorInstance = mirador.viewer(config, [
      aicNavigationButtonsPlugin,
      aicRemoveNavPlugin,
      aicZoomButtonsPlugin,
      aicThumbnailCustomization
    ]);

    document.addEventListener('modal:close', removeComponent);
  };

  this.destroy = function() {
    document.removeEventListener('modal:close', removeComponent);
    if (window.A17 && A17.Helpers) {
      A17.Helpers.purgeProperties(this);
    }
  };
};

export default viewerMirador;
