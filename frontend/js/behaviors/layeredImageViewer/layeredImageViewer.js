import OpenSeadragon from '../../libs/openseadragon4.min';

/**
 * (OpenSeadragon) Layered image viewer
 * @class
 * @param {HTMLElement} viewerEl - The element to initialise the viewer into. Contains HTML used for priming the initial state.
 */
class LayeredImageViewer {
  constructor(viewerEl) {
    // Check for presence of OSD before proceeding
    if (typeof OpenSeadragon !== 'function') {
      return console.error(
        'Error: OpenSeadragon is required to run the layered image viewer'
      );
    }
    this.element = viewerEl;
    this.images = [];
    this.toolbar = {
      buttons: {},
    };
    this.setInitialState();
    this._initViewer();
    this.id = 0;
  }

  /**
   * Skim data from the HTML included in the viewerEl and store it on this instance.
   * @public
   * @method
   */
  setInitialState() {
    const imagesContainerEl = this.element.querySelector(
      '.o-layered-image-viewer__images'
    );
    const imgEls = imagesContainerEl.querySelectorAll('img');

    // Zero indexed ID inferred from other instances in document
    this.id = document.querySelectorAll('.o-layered-image-viewer').length - 1;

    // Process each image
    imgEls.forEach((imgEl, i) => {
      const url = imgEl.src;
      let alt = imgEl.alt;
      let label = 'Unknown';
      const nextSiblingEl = imgEl.nextElementSibling;
      if (imgEl.title) {
        label = imgEl.title;
      } else if (
        nextSiblingEl &&
        nextSiblingEl.tagName.toLowerCase() === 'figcaption'
      ) {
        label = nextSiblingEl.innerText;
      }

      // Add ID for internal reference
      imgEl.id = `layered-image-viewer-${this.id}-${i}`;

      this.images = this.images.concat({
        url,
        alt,
        label,
      });
    });
  }

  /**
   * Initialise OpenSeadragon
   * @private
   * @method
   */
  _initViewer() {
    // OSD expects no siblings, by having a mount element
    // the destroy() method will preserve the initial HTML
    const mountEl = document.createElement('div');
    mountEl.classList.add('osd-mount');
    mountEl.style.width = '100%';
    mountEl.style.height = '100%';
    this.element.insertAdjacentElement('beforeend', mountEl);

    // Initialise with default buttons / controls removed
    // See: http://openseadragon.github.io/docs/OpenSeadragon.html#.Options
    this.viewer = new OpenSeadragon({
      element: mountEl,
      crossOriginPolicy: 'Anonymous',
      showSequenceControl: false,
      showHomeControl: false,
      showZoomControl: false,
      showFullPageControl: false,
      visibilityRatio: 0.3,
      homeFillsViewer: false,
      autoHideControls: false,
      tileSources: {
        type: 'image',
        url: this.images[0].url, // First image from markup by default
      },
    });
    this.viewer.addHandler('open', () => {
      this._addControls();

      // Set the role to application to enable arrows while using screenreader
      this.viewer.canvas.role = 'application';

      // Use label to describe the intent, and the current state. This will be announced first.
      this.viewer.canvas.ariaLabel = `Interacive image viewer. Currently showing ${this.images[0].label}.`;

      // Description populated by the alt text.
      // This is supplemental and read second to the label (skipped in some cicrumstances)
      // ariaDescription due to become standard in ARIA 1.3, for now describedBy has better compatability
      // described-by also allows multiple ID's
      this.viewer.canvas.setAttribute(
        'aria-describedby',
        `layered-image-viewer-${this.id}-0`
      );
    });
  }

  /**
   * Destroy Viewer
   * @public
   * @static
   * @method
   * @param {HTMLElement} viewerEl - Element which was used to initialise the viewer to be destroyed
   */
  static destroy(viewerEl) {
    const mountEl = viewerEl.querySelector('.osd-mount');
    if (mountEl) {
      // Destroy OSD and remove mount element added by init
      OpenSeadragon.getViewer(mountEl).destroy();
      mountEl.remove();
    }
  }

  /**
   * Transform string into kebab-case
   * @param {String} string - String to transform
   * @returns {String} - Kebab-case string
   */
  static toKebabCase(string) {
    return string.toLowerCase().replace(' ', '-');
  }

  /**
   * Transform string into camelCase
   * @param {String} string - String to transform
   * @returns {String} - camelCase string
   */
  static toCamelCase(string) {
    return string
      .toLowerCase()
      .replace(/[^a-zA-Z0-9]+(.)/g, (m, chr) => chr.toUpperCase());
  }

  /**
   * Add custom controls to OpenSeadragon
   * @private
   * @method
   */
  _addControls() {
    // The OSD mechanism for adding controls is a bit clunky
    // The best way is probably to construct accessible markup and insert in one go
    // (without really interacting with the OSD API)
    // N.B. Deliberate decision against role=toolbar for now, there is potentially complex behviour to handle if we apply that role
    // More info: https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/toolbar_role
    const standardControls = ['Zoom in', 'Zoom out', 'Reset'];
    this.toolbar.element = document.createElement('div');

    // Add each standard button and register with instance for easy access
    standardControls.forEach((control) => {
      const buttonEl = document.createElement('button');
      const innerEl = document.createElement('span');
      buttonEl.type = 'button';
      buttonEl.classList.add(
        `o-layered-image-viewer__${LayeredImageViewer.toKebabCase(control)}`
      );
      innerEl.classList.add('wrap');
      innerEl.innerText = control;
      buttonEl.appendChild(innerEl);
      this.toolbar.element.appendChild(buttonEl);
      this.toolbar.buttons[LayeredImageViewer.toCamelCase(control)] = buttonEl;
    });

    // Add the completed toolbar to OSD
    this.viewer.controls.topright.appendChild(this.toolbar.element);

    // Zoom In
    this.toolbar.buttons.zoomIn.addEventListener('click', () => {
      this.viewer.viewport.zoomBy(this.viewer.zoomPerClick / 1.0);
      this.viewer.viewport.applyConstraints();
    });

    // Zoom Out
    this.toolbar.buttons.zoomOut.addEventListener('click', () => {
      this.viewer.viewport.zoomBy(1.0 / this.viewer.zoomPerClick);
      this.viewer.viewport.applyConstraints();
    });

    // Reset
    this.toolbar.buttons.reset.addEventListener('click', () => {
      this.viewer.viewport.goHome();
    });
  }
}


const layeredImageViewer = function(container) {
  this.init = function() {
    new LayeredImageViewer(container);
  };
  this.destroy = function() {
    LayeredImageViewer.destroy(container);
  };
};

export default layeredImageViewer;
