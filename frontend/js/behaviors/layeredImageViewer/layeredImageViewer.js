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
    this.osdMountEl = null;
    this.browerSupportsFullscreen =
      typeof document.fullscreenElement !== 'undefined';
    this.size = 'm';
    this.id = 0;

    this.captionTitleEl = null;
    this.captionEl = null;
    this.images = {
      items: [],
      active: [], // Set() would've been useful here, but is not compatible with transpiler
    };
    this.annotations = {
      items: [],
      active: [],
    };
    this.toolbar = {
      buttons: {},
    };
    this.isFullscreen = false;

    // Bind to store referenceable event handler with correct context set explictly
    // Could use arrow functions, but transpiler might interfere
    this.boundExitFullscreenHandler = this._exitFullscreenHandler.bind(this);

    this.setInitialState();
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

    // Store state required for each type
    imgEls.forEach((imgEl, i) => {
      const figureEl = imgEl.closest('figure');
      const itemState = {};
      itemState.url = imgEl.dataset.viewerSrc;
      itemState.alt = imgEl.alt;
      itemState.label = 'Unknown';

      // Handle either figcaption or title
      if (imgEl.title) {
        itemState.label = imgEl.title;
      } else if (figureEl && figureEl.querySelector('figcaption')) {
        itemState.label = figureEl.querySelector('figcaption').innerText.trim();
      }

      // Add ID for internal reference
      imgEl.id = `layered-image-viewer-${this.id}-${type}-${i}`;

      this[type].items = this[type].items.concat(itemState);
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

    // Set the size
    this.size = this.element.dataset.size || 'm';

    // Store ref to containers container
    this.images.element = this.element.querySelector(
      '.o-layered-image-viewer__images'
    );
    this.annotations.element = this.element.querySelector(
      '.o-layered-image-viewer__annotations'
    );

    // Get caption and caption title nodes
    this.captionTitleEl = this.element.querySelector(
      '.o-layered-image-viewer__caption-title'
    );
    this.captionEl = this.element.querySelector(
      '.o-layered-image-viewer__caption-text'
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
    this.isFullscreen = true;
    if (enter) {
      // Enter fullscreen
      // CSS applied when class is added to html element
      document.documentElement.classList.add(
        's-layered-image-viewer-modal-active'
      );

      // Perform API request if necessary and bind event listeners
      if (this.browerSupportsFullscreen) {
        this.osdMountEl.requestFullscreen();

        document.addEventListener(
          'fullscreenchange',
          this.boundExitFullscreenHandler
        );
      } else {
        // Move into dialog el if non-fullscreen
        this.modalEl.appendChild(this.osdMountEl);
        this.modalEl.showModal();
        // refocus after move
        this.toolbar.buttons.fullscreen.focus();
        document.addEventListener('keydown', this.boundExitFullscreenHandler);
      }
      this.toolbar.buttons.fullscreen.innerText = 'Exit';
    } else {
      // Exit fullscreen
      // Hide viewer by removing class
      document.documentElement.classList.remove(
        's-layered-image-viewer-modal-active'
      );
      this.isFullscreen = false;

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
        // For non-fullscreen
        this.modalEl.close();
        this.element
          .querySelector('.m-media--layered-image-viewer-embed')
          .appendChild(this.osdMountEl);
        // refocus after move
        this.toolbar.buttons.fullscreen.focus();
        document.removeEventListener(
          'keydown',
          this.boundExitFullscreenHandler
        );
      }
      this.toolbar.buttons.fullscreen.innerText = 'Fullscreen';
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
   * Reach into the current state and set the aria-label for the viewer
   * @private
   * @method
   */
  _setMainAriaLabel() {
    // Get label for each active annotation
    const annotationLabels = this.annotations.active.map((activeIndex) => {
      return `'${this.annotations.items[activeIndex].label}'`;
    });

    // Convert labels array into string
    const annotationsString =
      LayeredImageViewer.stringifyList(annotationLabels);
    const wordAnnotation =
      annotationLabels.length > 1 ? 'annotations' : 'annotation';

    // Use label to describe the intent, and the current state. This will be announced before description.
    this.viewer.canvas.ariaLabel = `Interacive image viewer. Currently showing '${
      this.images.items[0].label
    }' image${
      annotationLabels.length
        ? `, overlayed with ${annotationsString} ${wordAnnotation}`
        : '.'
    }`;
  }

  /**
   * Initialise OpenSeadragon
   * @private
   * @method
   */
  _initViewer() {
    // OSD expects no siblings, keep it an orphan
    // the destroy() method will preserve the initial HTML

    const mediaTemplate = document.createElement('template');
    let captionMarkup = '';

    // Markup to be inserted if captionTitle / caption exist
    if (this.captionEl || this.captionTitleEl) {
      captionMarkup = `<figcaption>`;
      if (this.captionTitleEl) {
        captionMarkup += `
          <div class="f-caption-title">
            ${this.captionTitleEl.innerHTML}
          </div>`;
      }
      if (this.captionEl) {
        captionMarkup += `
          <div class="f-caption">
            ${this.captionEl.innerHTML}
          </div>`;
      }
      captionMarkup += `</figcaption>`;
    }

    // Markup to surround viewer with
    // Modelled around the media molecule
    mediaTemplate.innerHTML = `
      <figure class="m-media m-media--${this.size} m-media--contain o-blocks__block">
        <div class="m-media__img m-media--layered-image-viewer-embed">
          <div class="o-layered-image-viewer__osd-mount"></div>
        </div>
        ${captionMarkup}
      </figure>
    `;

    // Insert into class element
    this.element.insertAdjacentElement(
      'beforeend',
      mediaTemplate.content.firstElementChild
    );

    // Store reference of OSD element
    this.osdMountEl = this.element.querySelector(
      '.o-layered-image-viewer__osd-mount'
    );

    this.osdMountEl.style.display = 'block';

    // Add modal container if necessary (no fullscreen support)
    this.modalEl = document.querySelector('#layered-image-viewer-modal');
    if (!this.modalEl && !this.browerSupportsFullscreen) {
      // Dialog element has the advantage of handling semantics and focus trap
      this.modalEl = document.createElement('dialog');
      this.modalEl.id = 'layered-image-viewer-modal';
      this.modalEl.classList.add('layered-image-viewer-modal');
      document.body.appendChild(this.modalEl);
    }

    // Initialise with default buttons / controls removed
    // See: http://openseadragon.github.io/docs/OpenSeadragon.html#.Options
    this.viewer = new OpenSeadragon({
      element: this.osdMountEl,
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
    this.osdMountEl.style.display = '';

    this.viewer.addHandler('open', () => {
      this._addControls();

      // Set the role to application to enable arrows while using screenreader
      this.viewer.canvas.role = 'application';

      // Set the descriptive text for the viewer
      this._setMainAriaLabel();

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
    const osdMountEl = viewerEl.querySelector(
      '.o-layered-image-viewer__osd-mount'
    );
    // Add elements we create here to be cleaned up
    const fabricatedElements = [];

    if (osdMountEl) {
      // Destroy OSD and remove elements added by this class
      OpenSeadragon.getViewer(osdMountEl).destroy();
      osdMountEl.closest('figure').remove();
      fabricatedElements.forEach((fabricatedElement) => {
        fabricatedElement.remove();
      });
    }
  }

  /**
   * Transform string into kebab-case
   * @public
   * @static
   * @method
   * @param {String} string - String to transform
   * @returns {String} - Kebab-case string
   */
  static toKebabCase(string) {
    return string.toLowerCase().replace(' ', '-');
  }

  /**
   * Transform string into camelCase
   * @public
   * @static
   * @method
   * @param {String} string - String to transform
   * @returns {String} - camelCase string
   */
  static toCamelCase(string) {
    return string
      .toLowerCase()
      .replace(/[^a-zA-Z0-9]+(.)/g, (m, chr) => chr.toUpperCase());
  }

  /**
   * Transform an array of strings into a sentenace-like string
   * @public
   * @static
   * @method
   * @param {Array} list - List of strings to serialize
   * @returns {String} - String of joined array items
   */
  static stringifyList(list) {
    let string = '';
    if (list.length > 1) {
      if (list.length === 2) {
        string = list.join(' and ');
      } else {
        // With an Oxford comma
        string = `${list.slice(0, -1).join(', ')}, and ${list.slice(-1)}`;
      }
    } else {
      string = list.toString();
    }
    return string;
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
    const standardControls = ['Fullscreen', 'Zoom in', 'Zoom out', 'Reset'];
    this.toolbar.element = document.createElement('div');

    // Add each standard button and register with instance for easy access
    standardControls.forEach((control) => {
      const buttonEl = document.createElement('button');
      buttonEl.type = 'button';
      buttonEl.classList.add(
        `o-layered-image-viewer__${LayeredImageViewer.toKebabCase(control)}`
      );
      buttonEl.innerHTML = `<span class="wrap">${control}</span>`;

      // This seems to be announced anyway, but should probably be live
      if (control === 'Fullscreen') {
        buttonEl.ariaLive = 'polite';
      }

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

      // Deactivate annotations
      // (Requires events to be dispatched manually to trigger)
      const changeEvent = new Event('change');
      this.annotations.items.forEach((annotation) => {
        annotation.checkboxEl.checked = false;
        annotation.checkboxEl.dispatchEvent(changeEvent);
      });
    });

    // Fullscreen
    this.toolbar.buttons.fullscreen.addEventListener('click', () => {
      if (!this.isFullscreen) {
        this._setFullscreen(true);
      } else {
        this._setFullscreen(false);
      }
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
        <summary>Show annotations</summary>
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
      this.annotations.items[i].checkboxEl = rowEl.firstElementChild;

      // Attach toggle handling
      this.annotations.items[i].checkboxEl.addEventListener('change', (e) => {
        if (e.target.checked) {
          // Turn overlay on
          this.activateAnnotation(parseInt(e.target.dataset.index, 10));
        } else {
          // Turn overlay off
          this.deactivateAnnotation(parseInt(e.target.dataset.index, 10));
        }
        // Update aria label
        this._setMainAriaLabel();
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

    // Clone our annotation, otherwise OSD seems to want to move it
    // (which makes destruction cleanup hard)
    const cloneEl = this.annotations.element
      .querySelector(`#layered-image-viewer-${this.id}-annotations-${index}`)
      .cloneNode();
    cloneEl.id = `layered-image-viewer-${this.id}-annotations-${index}-clone`;

    // Add to active list
    this.annotations.active.push(index);

    this.viewer.addOverlay({
      element: cloneEl,
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

    // Remove from active list
    this.annotations.active = this.annotations.active.filter(
      (item) => item !== index
    );

    this.viewer.removeOverlay(
      `layered-image-viewer-${this.id}-annotations-${index}-clone`
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
