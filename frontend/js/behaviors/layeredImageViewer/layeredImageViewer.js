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
    this.mountEl = null;
    this.browerSupportsFullscreen =
      typeof document.fullscreenElement !== 'undefined';

    this.id = 0;
    this.images = {
      items: [],
    };
    this.annotations = {
      items: [],
    };
    this.toolbar = {
      buttons: {},
    };
    this.isFullScreen = false;

    // Bind to store referenceable event handler with correct context set explictly
    // Could use arrow functions, but transpiler might interfere
    this.boundExitFullscreenHandler = this._exitFullscreenHandler.bind(this);

    this.setInitialState();
    this._insertPlaceholder();
    this._initViewer();
  }

  /**
   * Process and store all types of image data in the same way
   * @private
   * @method
   * @param {String} type - The label to identify and store data
   * @param {NodeList} imgEls - The list of items (imgs) to process
   */
  _processImages(type, imgEls) {
    if (!imgEls.length) return;

    // Store url, alt and title
    imgEls.forEach((imgEl, i) => {
      const url = imgEl.src;
      let alt = imgEl.alt;
      let label = 'Unknown';
      const figureEl = imgEl.closest('figure');

      // Handle either figcaption or title
      if (imgEl.title) {
        label = imgEl.title;
      } else if (figureEl && figureEl.querySelector('figcaption')) {
        label = figureEl.querySelector('figcaption').innerText;
      }

      // Add ID for internal reference
      imgEl.id = `layered-image-viewer-${this.id}-${type}-${i}`;

      this[type].items = this[type].items.concat({
        url,
        alt,
        label,
      });
    });
  }

  /**
   * Skim data from the HTML included in the viewerEl and store it on this instance.
   * @public
   * @method
   */
  setInitialState() {
    // Zero indexed ID of the viewer inferred from other instances in document
    this.id = document.querySelectorAll('.o-layered-image-viewer').length - 1;

    // Store ref to containers container
    this.images.element = this.element.querySelector(
      '.o-layered-image-viewer__images'
    );
    this.annotations.element = this.element.querySelector(
      '.o-layered-image-viewer__annotations'
    );

    // Process each image
    this._processImages('images', this.images.element.querySelectorAll('img'));

    // Process each annotation
    this._processImages(
      'annotations',
      this.annotations.element.querySelectorAll('img')
    );
  }

  /**
   * Enter or exit fullscreen mode using the fullscreen API if available
   * Falls back to CSS if not
   * @private
   * @method
   * @param {Boolean} enter - What the target state should be
   */
  _setFullscreen(enter) {
    if (enter) {
      // Enter fullscreen
      // CSS applied when class is added to html element
      document.documentElement.classList.add(
        's-layered-image-viewer-active',
        's-body-locked'
      );

      // Perform API request if necessary and bind event listeners
      if (this.browerSupportsFullscreen) {
        this.mountEl.requestFullscreen();

        document.addEventListener(
          'fullscreenchange',
          this.boundExitFullscreenHandler
        );
      } else {
        document.addEventListener('keydown', this.boundExitFullscreenHandler);
      }
    } else {
      // Exit fullscreen
      // Hide viewer by removing class
      document.documentElement.classList.remove(
        's-layered-image-viewer-active',
        's-body-locked'
      );

      // Remove event listeners
      if (this.browerSupportsFullscreen) {
        if (document.fullscreenElement) {
          document.exitFullscreen();
        }
        document.removeEventListener(
          'fullscreenchange',
          this.boundExitFullscreenHandler
        );
      } else {
        document.removeEventListener(
          'keydown',
          this.boundExitFullscreenHandler
        );
      }
    }
  }

  /**
   * Handle exiting fullscreen
   * Will fire (without effect) when fullscreenchange enters fullscreen
   * @private
   * @method
   * @param {Event} e The event object form the fullscreenchange or keydown handler
   */
  _exitFullscreenHandler(e) {
    // For non-supporting browsers fullscreenElement is undefined
    // The escape key needs to be handled
    if (
      !this.browerSupportsFullscreen &&
      e.type === 'keydown' &&
      e.key === 'Escape'
    ) {
      this._setFullscreen(false);
    }
    // Escape or the browser inserted close button both trigger the fullscreenchange event
    // Only handle this when exiting
    if (e.type === 'fullscreenchange' && !document.fullscreenElement) {
      this._setFullscreen(false);
    }
  }

  /**
   * Insert a thumbnail of the first image to launch the viewer
   * @private
   * @method
   */
  _insertPlaceholder() {
    const placeholderEl = document.createElement('div');
    const buttonEl = document.createElement('button');
    const imgEl = document.createElement('img');
    placeholderEl.classList.add('o-layered-image-viewer__placeholder');
    buttonEl.classList.add('o-layered-image-viewer__launch');
    buttonEl.type = 'button';
    buttonEl.ariaLabel = 'Launch the layered image viewer';
    buttonEl.id = `layered-image-viewer-${this.id}-launch`;
    imgEl.src = this.images.items[0].url;
    imgEl.alt = this.images.items[0].alt;
    buttonEl.appendChild(imgEl);
    placeholderEl.appendChild(buttonEl);

    // Clicking placeholder to trigger fullscreen
    buttonEl.addEventListener('click', () => {
      this._setFullscreen(true);
    });

    // If it was more complex than this I'd probably use inserAdjacentHTML
    this.element.insertAdjacentElement('afterbegin', placeholderEl);
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
    this.mountEl = mountEl;
    this.mountEl.classList.add('o-layered-image-viewer__osd-mount');
    this.element.insertAdjacentElement('beforeend', mountEl);

    this.mountEl.style.display = 'block';

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
        url: this.images.items[0].url, // First image from markup by default
      },
    });
    this.mountEl.style.display = '';
    mountEl.style.position = 'fixed';

    // TODO: Remove for production. Useful for debugging
    window.osd = OpenSeadragon;
    window.liv = this;
    window.viewer = this.viewer;

    this.viewer.addHandler('open', () => {
      this._addControls();

      // Set the role to application to enable arrows while using screenreader
      this.viewer.canvas.role = 'application';

      // Use label to describe the intent, and the current state. This will be announced first.
      this.viewer.canvas.ariaLabel = `Interacive image viewer. Currently showing '${this.images.items[0].label}' image.`;

      // Description populated by the alt text.
      // This is supplemental and read second to the label (skipped in some cicrumstances)
      // ariaDescription due to become standard in ARIA 1.3, for now describedBy has better compatability
      // described-by also allows multiple ID's
      this.viewer.canvas.setAttribute(
        'aria-describedby',
        `layered-image-viewer-${this.id}-images-0`
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
    const mountEl = viewerEl.querySelector(
      '.o-layered-image-viewer__osd-mount'
    );
    // Add elements we create here to be cleaned up
    const fabricatedElements = viewerEl.querySelectorAll(
      '.o-layered-image-viewer__placeholder'
    );

    if (mountEl) {
      // Destroy OSD and remove elements added by this class
      OpenSeadragon.getViewer(mountEl).destroy();
      mountEl.remove();
      fabricatedElements.forEach((fabricatedElement) => {
        fabricatedElement.remove();
      });
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
    const standardControls = ['Exit', 'Zoom in', 'Zoom out', 'Reset'];
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

    // Exit
    this.toolbar.buttons.exit.addEventListener('click', () => {
      this._setFullscreen(false);
    });

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

    // Control panel for annotations if present
    this._addAnnotationMenu();
  }

  /**
   * Add a menu for toggling annotations
   * @private
   * @method
   */
  _addAnnotationMenu() {
    if (!this.annotations.items.length) return;

    // Create template markup
    const detailsTemplate = document.createElement('template');
    detailsTemplate.innerHTML = `
      <details class="layered-image-viewer-details">
        <summary>Annotations</summary>
        <div class="layered-image-viewer-details__menu"></div>
      </details>`;
    const detailsEl = detailsTemplate.content.firstElementChild;
    const panelEl = detailsEl.lastElementChild;

    // Build up markup for the annotations panel
    // Each item becoming a checkbox / label combo
    const fieldTemplate = document.createElement('template');
    this.annotations.items.forEach((item, i) => {
      fieldTemplate.innerHTML = `
        <div class="layered-image-viewer-details__option">
          <input id="layered-image-viewer-${this.id}-annotation-cb-${i}" type="checkbox" data-index="${i}" />
          <label for="layered-image-viewer-${this.id}-annotation-cb-${i}">${item.label}</label>
        </div>
        `;

      const rowEl = fieldTemplate.content.firstElementChild;

      // Attach toggle handling
      rowEl.firstElementChild.addEventListener('change', (e) => {
        if (e.target.checked) {
          // Turn overlay on
          this.activateAnnotation(e.target.dataset.index);
        } else {
          this.deactivateAnnotation(e.target.dataset.index);
        }
      });
      // Add completed row to panel
      panelEl.appendChild(rowEl);
    });

    // Add menu to toolbar
    this.toolbar.element.appendChild(detailsEl);
  }

  /**
   * Activate an annotation by the internally tracked index
   * @public
   * @method
   * @param {Number} index - Index of annotation to activate. Mirrors the order of the initial HTML
   */
  activateAnnotation(index) {
    if (!this.annotations.items[index]) return;

    // There's two potential ways of doing this AFAIK
    // 1. Add an image. This doesn't work well with SVG
    // 2. Add an overlay. This works with imgs/svgs/html
    // There's also OpenSeadragon svgOverlay plugin, which from what I can tell
    // seems to be if you're working with arbitrary SVG code and not really suited to our files.
    this.viewer.addOverlay({
      id: `layered-image-viewer-${this.id}-annotations-${index}`,
      location: new OpenSeadragon.Point(0, 0),
      width: 1, // (viewport unit)
      index: index,
    });
  }

  /**
   * Deactivate an annotation by the internally tracked index
   * @public
   * @method
   * @param {Number} index - Index of annotation to activate. Mirrors the order of the initial HTML
   */
  deactivateAnnotation(index) {
    if (!this.annotations.items[index]) return;

    this.viewer.removeOverlay(
      `layered-image-viewer-${this.id}-annotations-${index}`
    );
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
