import ReactDOM from 'react-dom';
import React from 'react';
import mirador from 'mirador/dist/es/src/index';
import aicZoomButtonsPlugin from '../../libs/mirador/aicZoomButtonsPlugin';
import aicNavigationButtonsPlugin from '../../libs/mirador/aicNavigationButtonsPlugin';
import aicRemoveNavPlugin from '../../libs/mirador/aicRemoveNavPlugin';
import aicThumbnailCustomization from '../../libs/mirador/aicThumbnailCustomizationPlugin';

const viewerMirador = function(container) {
  let viewerId = 'm-viewer-mirador-' + container.dataset.id;
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
      defaultPosition: 'far-bottom', // Which position for the thumbnail navigation to be be displayed. Other possible values are "far-bottom" or "far-right"
      height: 130, // Height of entire ThumbnailNavigation area when position is "far-bottom"
      width: 100, // Width of one canvas (doubled for book view) in ThumbnailNavigation area when position is "far-right"
    },
    createGenerateClassNameOptions: { // Options passed directly to createGenerateClassName in Material-UI https://material-ui.com/styles/api/#creategenerateclassname-options-class-name-generator
      productionPrefix: 'mirador-' + container.dataset.id,
    },
    window: {
      allowClose: false, // Configure if windows can be closed or not
      allowFullscreen: false, // Configure to show a "fullscreen" button in the WindowTopBar
      allowTopMenuButton: false,
      allowWindowSideBar: false,
      allowMaximize: false, // Configure if windows can be maximized or not
      sideBarPanel: 'info', // Configure which sidebar is selected by default. Options: info, attribution, canvas, annotations, search
      defaultView: container.dataset.view,  // Configure which viewing mode (e.g. single, book, gallery) for windows to be opened in
      hideWindowTitle: true, // Configure if the window title is shown in the window title bar or not
      sideBarOpen: false, // Configure if the sidebar (and its content panel) is open by default
      panels: { // Configure which panels are visible in WindowSideBarButtons
        info: false,
        attribution: false,
        canvas: false,
        annotations: false,
        search: false,
        layers: false,
      },
    },
    workspace: {
      showZoomControls: false, // Configure if zoom controls should be displayed by default
      type: 'mosaic',
    },
     workspaceControlPanel: {
      enabled: false,
    },
    osdConfig: { // Openseadragon config
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
  }
  this.init = function() {
    mirador.viewer(config, [
      aicNavigationButtonsPlugin, aicRemoveNavPlugin, aicZoomButtonsPlugin, aicThumbnailCustomization
    ]);

    function removeComponent() {
      // Remove mirador component when modal is closed
      let targetElement = document.querySelector('.g-modal--moduleMirador #'+ viewerId);
      if (targetElement) {
        ReactDOM.unmountComponentAtNode(targetElement);
      }
    }
    document.addEventListener('modal:close', removeComponent);
  };

  this.destroy = function() {
    A17.Helpers.purgeProperties(this);
  };
}

export default viewerMirador;
