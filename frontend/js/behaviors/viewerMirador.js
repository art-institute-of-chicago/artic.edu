import ReactDOM from 'react-dom';
import React from 'react';
import mirador from 'mirador/dist/es/src/index';
import aicZoomButtonsPlugin from '../libs/mirador/aicZoomButtonsPlugin';
import aicNavigationButtonsPlugin from '../libs/mirador/aicNavigationButtonsPlugin';
import aicRemoveNavPlugin from '../libs/mirador/aicRemoveNavPlugin';
import aicThumbnailCustomization from '../libs/mirador/aicThumbnailCustomizationPlugin';


const viewerMirador = function(container) {
  const config = {
    id: 'm-viewer-mirador',
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
          MuiPaper: {
            root: {
              insideLabel: {
                background: '#cc0000',
              },
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
      height: 130, // height of entire ThumbnailNavigation area when position is "far-bottom"
      width: 100, // width of one canvas (doubled for book view) in ThumbnailNavigation area when position is "far-right"
    },
    window: {
      allowClose: false, // Configure if windows can be closed or not
      allowFullscreen: false, // Configure to show a "fullscreen" button in the WindowTopBar
      allowTopMenuButton: false,
      allowWindowSideBar: false,
      allowMaximize: false, // Configure if windows can be maximized or not
      sideBarPanel: 'info', // Configure which sidebar is selected by default. Options: info, attribution, canvas, annotations, search
      defaultView: 'single',  // Configure which viewing mode (e.g. single, book, gallery) for windows to be opened in
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
      constrainDuringPan: true,
      animationTime: 1.5,
      maxZoomPixelRatio: 1,
      minZoomImageRatio: 1,
      minZoomLevel: 0,
      gestureSettingsMouse: {
        scrollToZoom: true,
        clickToZoom: false,
        dblClickToZoom: false,
      },
    },
  }
  this.init = function() {
    mirador.viewer(config, [
      aicZoomButtonsPlugin, aicNavigationButtonsPlugin, aicRemoveNavPlugin, aicThumbnailCustomization
    ]);
  };  
}

export default viewerMirador;
