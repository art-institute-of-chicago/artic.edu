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

    // Prevent possibility of double init
    if (viewerEl.layeredImageViewer) return;

    this.element = viewerEl;
    this.element.layeredImageViewer = this;
    this.osdMountEl = null;
    this.browerSupportsFullscreen =
      typeof document.fullscreenElement !== 'undefined';
    this.size = this.element.dataset.size || 'm';
    this.aspect = 1;
    this.id = 0;

    // Store how viewer should behave on first load
    // (Needs to include all keys)
    // Added to viewer instance when interactoin setter first runs
    this.baseGestureSettings = {
      mouse: {
        dragToPan: true,
        scrollToZoom: false,
        clickToZoom: true,
        dblClickToZoom: false,
        dblClickDragToZoom: false,
        pinchToZoom: false,
        zoomToRefPoint: true,
        flickEnabled: false,
        flickMinSpeed: 120,
        flickMomentum: 0.25,
        pinchRotate: false,
      },
      touch: {
        dragToPan: true,
        scrollToZoom: false,
        clickToZoom: false,
        dblClickToZoom: true,
        dblClickDragToZoom: true,
        pinchToZoom: true,
        zoomToRefPoint: true,
        flickEnabled: true,
        flickMinSpeed: 120,
        flickMomentum: 0.25,
        pinchRotate: false,
      },
    }

    this.captionTitleEl = null;
    this.captionEl = null;
    this.images = {
      items: [],
      active: {
        a: null,
        b: null,
      },
    };
    this.overlays = {
      items: [],
      active: [],
      default: [],
    };
    this.toolbar = {
      viewer: {
        buttons: {},
      },
      layers: {},
    };
    this.isFullscreen = false;

    // Bind to store referenceable event handler with correct context set explictly
    // Could use arrow functions, but transpiler might interfere
    this.boundExitFullscreenHandler = this._exitFullscreenHandler.bind(this);
    this.boundOsdEnableDefault = this._osdEnableDefault.bind(this);
    this.boundHandleExternalClick = this._handleExternalClick.bind(this);
    this.boundHandleClickInteraction = this._handleClickInteraction.bind(this);
    this.boundHandlePointerEnterInteraction = this._handlePointerEnterInteraction.bind(this);

    this.setInitialState();
    this._initViewer();
  }

  /**
   * Handler to use for OSD inner events when browser scrolling
   * At time of writing this is required
   * See: https://github.com/openseadragon/openseadragon/issues/2151
   * @private
   * @method
   * @param {Event} e The event object
   */
  _osdEnableDefault(e) {
    e.preventDefault = false;
    e.preventDefaultAction = false;
  }

  /**
   * Handle click / tap events that fire when interaction is enabled
   * @private
   * @method
   * @param {Event} e The event object
   */
  _handleExternalClick(e) {
    if (!this.viewer.element.contains(e.target)) {
      this.interaction = false;
      // Turn off tracking when scrolling is released to the browser
      // Deciding for better or for worse that a stylus is more like a mouse than a finger
      // Tracker should be halted only for touch, enabling drag by mouse
      if (e.pointerType === 'touch') {
        this.viewer.innerTracker.setTracking(false);
      } else {
        this.viewer.innerTracker.setTracking(true);
      }
    }
  }

  /**
   * Handle click / tap interaction within the viewer area
   * @private
   * @method
   */
  _handleClickInteraction() {
    this.interaction = true;
    this.viewer.innerTracker.setTracking(true);
  }

  /**
   * Handle any kind of pointer entering the viewer
   * @private
   * @method
   * @param {Event} e The event object
   */
  _handlePointerEnterInteraction(e) {
    // N.B. if we wanted to do more advanced handling that needed e.touches this would
    // have to be called on a touch event
    if (!this.interaction && e.pointerType === 'touch') {
      // Stop tracking for touch to prevent warnings
      this.viewer.innerTracker.setTracking(false);
    }
  }

  /**
   * Getter for _interaction
   * @public
   */
  get interaction() {
    return this._interaction;
  }

  /**
   * Setter for _interaction
   * @param {Boolean} value - New value for interaction
   * @public
   */
  set interaction(value) {
    // Either indicate touch-scroll will be captured or be released
    this.viewer.container.style.touchAction = value
      ? 'none'
      : 'manipulation';
    this.viewer.canvas.style.touchAction = value ? 'none' : 'manipulation';

    // Release internal event tracking in OSD
    this.viewer[this.interaction ? 'removeHandler' : 'addHandler'](
      'canvas-scroll',
      this.boundOsdEnableDefault
    );

    // Set gestureSettings
    // Spread operator not allowed, workaround:
    Object.assign(this.viewer.gestureSettingsMouse, this.baseGestureSettings.mouse);
    this.viewer.gestureSettingsMouse.scrollToZoom = this.isFullscreen && true;

    Object.assign(this.viewer.gestureSettingsTouch, this.baseGestureSettings.touch);
    if (value) {
      this.viewer.gestureSettingsTouch.dragToPan = true;
      this.viewer.gestureSettingsTouch.flickEnabled = true;
    }

    // Add or remove event listeners
    // It's probably best to not remove these contingent on interaction,
    // in case we need more logic inside the handler
    this.viewer.element.addEventListener(
      'click',
      this.boundHandleClickInteraction,
      true
    );
    this.viewer.element.
      addEventListener('pointerenter', this.boundHandlePointerEnterInteraction, true);

    // This can be removed contingent on interaction
    ['click', 'touchend'].forEach((event) => {
      document.body[value ? 'addEventListener' : 'removeEventListener'](
        event,
        this.boundHandleExternalClick,
        true
      );
    })

    // Complete property assignment
    this._interaction = value;
  }

  /**
   * Attach resize observer to viewer element
   * @private
   * @method
   */
  _setViewerResizeObserver() {
    // Watch for resize on main element
    this.viewerResizeObserver = new ResizeObserver((entries) => {
      this.viewer.element.style.setProperty(
        '--viewer-height',
        `${entries[0].contentRect.height}px`
      );

      this.viewer.element.style.setProperty(
        '--viewer-width',
        `${entries[0].contentRect.width}px`
      );
    });

    this.viewerResizeObserver.observe(this.viewer.element);
  }

  /**
   * Take the view back to its (editor defined) starting position
   * @private
   * @method
   */
  _setCropRegion() {
    if (!this.cropRegion) return;

    const cropRegion = this.viewer.world
      .getItemAt(0)
      .imageToViewportRectangle(
        this.cropRegion.x,
        this.cropRegion.y,
        this.cropRegion.width,
        this.cropRegion.height
      );

    // For now this has to be set with the immediately flag, see:
    // https://github.com/openseadragon/openseadragon/issues/2292
    this.viewer.viewport.fitBoundsWithConstraints(cropRegion, true);
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

      // Set default active overlays
      if (type === 'overlays') {
        const overlayEl = imgEl.closest('.o-layered-image-viewer__overlay');

        if (typeof overlayEl.dataset.activeOverlay !== 'undefined') {
          this.overlays.default.push(i);
        }
      }

      // Use the first image to skim the aspect ratio
      if (type === 'images' && i === 0) {
        this.aspect = imgEl.height / imgEl.width;
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
    // Zero indexed ID of the viewer inferred from other initialised viewers document
    this.id = document.querySelectorAll('.o-layered-image-viewer__osd').length - 1;

    // Set the size
    this.size = this.element.dataset.size;

    // Store ref to containers container
    this.images.element = this.element.querySelector(
      '.o-layered-image-viewer__images'
    );
    this.overlays.element = this.element.querySelector(
      '.o-layered-image-viewer__overlays'
    );

    // Get caption and caption title nodes
    this.captionTitleEl = this.element.querySelector(
      '.o-layered-image-viewer__caption-title'
    );
    this.captionEl = this.element.querySelector(
      '.o-layered-image-viewer__caption-text'
    );

    // Extract initial crop / zoom if set
    if (this.element.dataset.cropRegion) {
      this.cropRegion = JSON.parse(
        this.element.dataset.cropRegion.replace(/&quot;/g, '"')
      );
    }

    // Process each image
    if (this.images.element) {
      this._processImages('images', this.images.element.querySelectorAll('img'));
    }

    // Process each overlay
    if (this.overlays.element) {
      this._processImages(
        'overlays',
        this.overlays.element.querySelectorAll('img')
      );
    }
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
        this.toolbar.viewer.buttons.fullscreen.focus();
        document.addEventListener('keydown', this.boundExitFullscreenHandler);
      }
      // This should be true already, but ensure full screen viewer
      // has gestures matching post-interaction state
      this.interaction = true;
      this.toolbar.viewer.buttons.fullscreen.ariaLabel = 'Exit';
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
          .querySelector('.o-layered-image-viewer__osd')
          .appendChild(this.osdMountEl);
        // refocus after move
        this.toolbar.viewer.buttons.fullscreen.focus();
        document.removeEventListener(
          'keydown',
          this.boundExitFullscreenHandler
        );
      }
      // Revert gestures to pre-interaction state
      this.interaction = false;
      this.toolbar.viewer.buttons.fullscreen.ariaLabel = 'Fullscreen';
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
    // Get label for each active overlay
    const overlayLabels = this.overlays.active.map((activeIndex) => {
      return `'${this.overlays.items[activeIndex].label}'`;
    });

    // 'b' label will only exist if initialised with multple images
    const imageLabels = [`'${this.images.items[this.images.active.a].label}'`];
    this.images.active.b !== null &&
      imageLabels.push(`'${this.images.items[this.images.active.b].label}'`);

    // Convert labels array into string
    const overlaysString = LayeredImageViewer.stringifyList(overlayLabels);

    const imagesString = LayeredImageViewer.stringifyList(imageLabels);

    const overlayNoun = overlayLabels.length > 1 ? 'overlays' : 'overlay';
    const imageNoun = imageLabels.length > 1 ? 'images' : 'image';

    // Use label to describe the intent, and the current state. This will be announced before description.
    this.viewer.canvas.ariaLabel = `Interactive image viewer. Currently showing ${imagesString} ${imageNoun}${
      overlayLabels.length
        ? `, overlayed with ${overlaysString} ${overlayNoun}`
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
      <figure class="o-layered-image-viewer__osd m-media m-media--${this.size} m-media--layered-image-viewer-embed m-media--contain o-blocks__block">
        <div class="m-media__img">
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

    // Apect ratio for styling
    this.osdMountEl.style.setProperty('--viewer-aspect', this.aspect);

    this.osdMountEl.style.display = 'block';

    // Add modal container if necessary (no fullscreen support)
    this.modalEl = document.querySelector('#layered-image-viewer-modal');
    if (!this.modalEl && !this.browerSupportsFullscreen) {
      // Dialog element has the advantage of handling semantics and focus trap
      this.modalEl = document.createElement('dialog');
      this.modalEl.id = 'layered-image-viewer-modal';
      this.modalEl.classList.add('o-layered-image-viewer__modal');
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
      autoHideControls: true,
      showNavigator: true,
      navigatorPosition: 'TOP_LEFT',
      navigatorAutoFade: true,
      tileSources: {
        type: 'image',
        url: this.images.items[0].url, // First image from markup by default
      },
    });

    this.osdMountEl.style.display = '';

    this.viewer.addHandler('open', () => {
      this._addControls();

      // Assign initial active image layers
      this.assignImageToLayer(0, 'a');
      this.assignImageToLayer(1, 'b');

      // Set the start position if predefined
      this._setCropRegion();

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

      // Activate default overlays
      const changeEvent = new Event('change');

      this.overlays.default.forEach((index)=> {
        this.overlays.items[index].checkboxEl.checked = true;
        this.overlays.items[index].checkboxEl.dispatchEvent(changeEvent);
      });

      // Add resizeObserver
      this._setViewerResizeObserver();

      // Force interaction setter function to fire
      this.interaction = false;
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
    // Qualifying elements should have a layeredImageViewer stored inside
    const instance = viewerEl.layeredImageViewer

    if (!instance) return;

    // Stop observers
    instance.viewerResizeObserver.disconnect();

    // Destroy OSD and remove elements added by this class
    instance.viewer.destroy();
    viewerEl.querySelector('.o-layered-image-viewer__osd').remove();

    // Cull events added outside the scope of the viewer
    ['click', 'touchend'].forEach((event) => {
      document.body.removeEventListener(
        event,
        instance.boundHandleExternalClick,
        true
      );
    });

    delete viewerEl.layeredImageViewer;
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
   * Create a button element for the viewer
   *
   * @private
   * @method
   * @param {Object} options - Label and icon to use
   * @param {Array} classes - Classes to use on the button element
   * @returns {HTMLButtonElement} - The complete button element
   */
  _createIconButton(options, classes) {
    const {label, icon, interaction } = options;

    this.buttonTemplate =
      this.buttonTemplate || document.createElement('template');

    this.buttonTemplate.innerHTML = `
      <button class="${classes.join(' ')}" type="button" aria-label="${
      label
    }" data-layered-viewer-interaction="${interaction}">
        <svg class="${icon}" aria-hidden="true">
          <use xlink:href="#${icon}" />
        </svg>
    </button>
    `;
    return this.buttonTemplate.content.firstElementChild;
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
    const viewerControls = [
      {
        label: 'Fullscreen',
        icon: 'icon--zoom--24',
        interaction: 'modal',
      },
      {
        label: 'Zoom in',
        icon: 'icon--zoom-in--24',
        interaction: 'zoom',
      },
      {
        label: 'Zoom out',
        icon: 'icon--zoom-out--24',
        interaction: 'zoom'
      },
    ];
    this.toolbar.viewer.element = document.createElement('div');
    this.toolbar.viewer.element.classList.add(
      'o-layered-image-viewer__viewer-toolbar'
    );

    // Add each standard button and register with instance for easy access
    const standardButtonClasses = ['btn', 'btn--septenary', 'btn--icon-sq'];
    viewerControls.forEach((control) => {
      const buttonClasses = standardButtonClasses.concat(
        `o-layered-image-viewer__${LayeredImageViewer.toKebabCase(
          control.label
        )}`
      );
      const buttonEl = this._createIconButton(control, buttonClasses);

      // This seems to be announced anyway, but should probably be live
      if (control.label === 'Fullscreen') {
        buttonEl.ariaLive = 'polite';
      }

      this.toolbar.viewer.element.appendChild(buttonEl);
      this.toolbar.viewer.buttons[
        LayeredImageViewer.toCamelCase(control.label)
      ] = buttonEl;
    });

    // Add the completed toolbar to OSD
    this.viewer.controls.topright.appendChild(this.toolbar.viewer.element);

    // Zoom In
    this.toolbar.viewer.buttons.zoomIn.addEventListener('click', () => {
      this.viewer.viewport.zoomBy(this.viewer.zoomPerClick / 1.0);
      this.viewer.viewport.applyConstraints();
    });

    // Zoom Out
    this.toolbar.viewer.buttons.zoomOut.addEventListener('click', () => {
      this.viewer.viewport.zoomBy(1.0 / this.viewer.zoomPerClick);
      this.viewer.viewport.applyConstraints();
    });

    // Fullscreen
    this.toolbar.viewer.buttons.fullscreen.addEventListener('click', () => {
      if (!this.isFullscreen) {
        this._setFullscreen(true);
      } else {
        this._setFullscreen(false);
      }
    });

    this.toolbar.layers.element = document.createElement('div');
    this.toolbar.layers.element.classList.add(
      'o-layered-image-viewer__layers-toolbar'
    );

    this.viewer.controls.bottomright.appendChild(this.toolbar.layers.element);

    // Control for opacity (if more than one image)
    this._addOpacityControl();

    // Control menu for image layer controls if neccessary
    // (overlays present/more than one image)
    this._addImageLayerControlMenu();

    // Reset
    // Add button to layers controls
    this.toolbar.layers.reset = this._createIconButton(
      {
        label: 'Reset to initial state',
        icon: 'icon--reset--24',
      },
      standardButtonClasses.concat('o-layered-image-viewer__reset')
    );

    // Add to toolbar element
    this.toolbar.layers.element.appendChild(this.toolbar.layers.reset);

    // Bind event handling
    this.toolbar.layers.reset.addEventListener('click', () => {
      // Set the viewer position to its initial state
      if (this.cropRegion) {
        this._setCropRegion();
      } else {
        this.viewer.viewport.goHome();
      }

      // Set overlays to initial state
      // (Requires events to be dispatched manually to trigger)
      const changeEvent = new Event('change');
      this.overlays.items.forEach((overlay, i) => {
        overlay.checkboxEl.checked = this.overlays.default.includes(i);
        overlay.checkboxEl.dispatchEvent(changeEvent);
      });

      // Reset layers
      this.assignImageToLayer(0, 'a');
      this.assignImageToLayer(1, 'b');

      // Reset opacity
      this.setOpacity(0);
    });
  }

  /**
   *
   * @private
   * @method
   */
  _addOpacityControl() {
    if (this.images.items.length < 2) return;

    const opacityTemplate = document.createElement('template');
    opacityTemplate.innerHTML = `
      <div class="o-layered-image-viewer__opacity">
        <label class="f-body" for="o-layered-image-viewer-${this.id}-opacity-slider">Slide between views:</label>
        <div class="o-layered-image-viewer__opacity-field">
          <span class="f-body o-layered-image-viewer__opacity-marker">A</span>
          <input id="o-layered-image-viewer-${this.id}-opacity-slider" name="opacity" type="range" min="0" max="100" step="1" value="0" data-layered-viewer-interaction="slider" />
          <span class="f-body o-layered-image-viewer__opacity-marker">B</span>
        </div>
      </div>
    `;

    const opacityWrapperEl = opacityTemplate.content.firstElementChild;
    this.opacitySliderEl = opacityWrapperEl.querySelector('input');

    // Insert control
    this.toolbar.layers.element.append(opacityWrapperEl);

    // Add event listener for slider
    this.opacitySliderEl.addEventListener('input', (e) => {
      // Invert value from slider
      this.setOpacity(e.target.value);
    });
  }

  /**
   * Set opacity
   * The closer to 1 this is the more of image A is shown
   *
   * @method
   * @param {Number} opacity - Opacity to set. Should be integer between 0 and 100
   * @public
   */
  setOpacity(opacity) {
    // Invert value, set slider and update world item
    this.opacitySliderEl.value = opacity;
    this.viewer.world.getItemAt(1).setOpacity((100 - opacity) / 100);

    // Set custom prop for styling
    this.opacitySliderEl.style.setProperty('--percent', opacity);
  }

  /**
   * Add a menu switching layers and toggling overlays
   * @private
   * @method
   */
  _addImageLayerControlMenu() {
    // Only show if overlays or multiple images exist
    if (!this.overlays.items.length && this.images.items.length < 2) return;

    // Create template markup
    const detailsTemplate = document.createElement('template');
    detailsTemplate.innerHTML = `
      <details id="o-layered-image-viewer-${this.id}-details" class="o-layered-image-viewer-details">
        <summary class="btn btn--icon-sq btn--septenary" data-layered-viewer-interaction="layers">
          <span class="sr-only">Image layer options</span>
          <svg class="icon--layers--24" aria-hidden="true">
            <use xlink:href="#icon--layers--24" />
          </svg>
        </summary>
        <div class="o-layered-image-viewer-details__menu">
          <button id="o-layered-image-viewer-${this.id}-details__close" class="btn btn--icon btn--quinary o-layered-image-viewer-details__close" aria-label="Close menu" aria-controls="o-layered-image-viewer-${this.id}-details">
            <svg class="icon--close--24" aria-hidden="true">
              <use xlink:href="#icon--close--24" />
            </svg>
          </button>
        </div>
      </details>`;
    const detailsEl = detailsTemplate.content.firstElementChild;

    // Handle actions that should close menu
    const closeHandler = (e) => {
      if (
        (e.type === 'click' && !detailsEl.contains(e.target)) ||
        (e.type === 'keydown' && e.key === 'Escape')
      ) {
        detailsEl.open = false;
      }
    };
    detailsEl
      .querySelector(`#o-layered-image-viewer-${this.id}-details__close`)
      .addEventListener('click', (e) => {
        e.target.closest('details').querySelector('summary').click()
      });
    const menuEl = detailsEl.lastElementChild;

    // Attach / remove listeners to close as menu toggles
    detailsEl.addEventListener('toggle', () => {
      if (detailsEl.open) {
        // Set scroll to top when opening
        menuEl.scrollTop = 0;

        // Disable click to zoom
        this.viewer.gestureSettingsMouse.clickToZoom = false;

        this.viewer.element.addEventListener('click', closeHandler, true);
        this.viewer.element.addEventListener('keydown', closeHandler, true);
      } else {
        // Re-enable click to zoom
        this.viewer.gestureSettingsMouse.clickToZoom = true;

        this.viewer.element.removeEventListener('click', closeHandler);
        this.viewer.element.removeEventListener('keydown', closeHandler);
      }
    });

    // Output images
    if (this.images.items.length > 1) {
      const imagesTemplate = document.createElement('template');
      imagesTemplate.innerHTML = `
        <div class="o-layered-image-viewer-details__section layered-image-viewer-details__section--images">
          <h2 class="o-layered-image-viewer-details__heading f-tag-2">Image layers</h2>
          <div class="o-layered-image-viewer__details-row o-layered-image-viewer__details-row--radio o-layered-image-viewer__details-row--title">
            <p class="f-caption">Select two views to compare on screen.</p>
            <p class="f-tag-2"><span class="sr-only">Layer </span>A</p>
            <p class="f-tag-2"><span class="sr-only">Layer </span>B</p>
          </div>
          <div class="o-layered-image-viewer__details-rows o-layered-image-viewer__details-rows--radio">
          </div>
        </div>`;
      const imagesWrapperEl = imagesTemplate.content.firstElementChild;

      // Build up markup for the images
      // Each item becoming a radio button / label combo
      const imagesFieldTemplate = document.createElement('template');
      this.images.items.forEach((item, i) => {
        imagesFieldTemplate.innerHTML = `
            <div class="o-layered-image-viewer__details-row o-layered-image-viewer__details-row--radio">
              <fieldset class="o-layered-image-viewer-details__radio-group">
                <legend class="f-body">${item.label}</legend>
                <span class="radio">
                  <input id="layered-image-viewer-${this.id}-image-rb-${i}-a" name="layered-image-viewer-${this.id}-image-rb-${i}" type="radio" data-index="${i}" aria-live="polite" />
                  <span>
                    <label for="layered-image-viewer-${this.id}-image-rb-${i}-a"><span class="sr-only">Layer A</span></label>
                  </span>
                </span>
                <span class="radio">
                  <input id="layered-image-viewer-${this.id}-image-rb-${i}-b" name="layered-image-viewer-${this.id}-image-rb-${i}" type="radio" data-index="${i}" aria-live="polite" />
                  <span>
                  <label for="layered-image-viewer-${this.id}-image-rb-${i}-b"><span class="sr-only">Layer B</span></label>
                  </span>
                </span>
              </fieldset>
            </div>
            `;

        const rowEl = imagesFieldTemplate.content.firstElementChild;
        const rowOptEls = rowEl.querySelectorAll('input');
        item.controlEls = {
          a: rowOptEls[0],
          b: rowOptEls[1],
        };

        imagesWrapperEl.lastElementChild.appendChild(rowEl);
        menuEl.appendChild(imagesWrapperEl);

        // Add event listener to radio buttons
        // When any button changes:
        rowOptEls.forEach((optEl) => {
          optEl.addEventListener('change', (e) => {
            this._handleControlImageChange(
              parseInt(e.target.dataset.index, 10),
              e.target.id.slice(-1)
            );
          });
        });
      });
    }

    // Output overlays
    if (this.overlays.items.length) {
      const overlaysTemplate = document.createElement('template');
      overlaysTemplate.innerHTML = `
      <div class="o-layered-image-viewer-details__section layered-image-viewer-details__section--overlays">
        <h2 class="o-layered-image-viewer-details__heading f-tag-2">Overlays</h2>
        <div class="o-layered-image-viewer__details-rows o-layered-image-viewer__details-rows--checkbox">
        </div>
      </div>`;
      const overlaysWrapperEl = overlaysTemplate.content.firstElementChild;

      // Build up markup for the overlays
      // Each item becoming a checkbox / label combo
      const overlayFieldTemplate = document.createElement('template');
      this.overlays.items.forEach((item, i) => {
        overlayFieldTemplate.innerHTML = `
          <div class="o-layered-image-viewer__details-row o-layered-image-viewer__details-row--checkbox">
            <span class="checkbox">
              <input id="layered-image-viewer-${this.id}-overlay-cb-${i}" type="checkbox" data-index="${i}" />
              <span class="f-secondary">
                <label for="layered-image-viewer-${this.id}-overlay-cb-${i}">${item.label}</label>
              </span>
            </span>
          </div>
          `;

        const rowEl = overlayFieldTemplate.content.firstElementChild;
        this.overlays.items[i].checkboxEl =
          rowEl.firstElementChild.firstElementChild;

        // Attach toggle handling
        this.overlays.items[i].checkboxEl.addEventListener('change', (e) => {
          if (e.target.checked) {
            // Turn overlay on
            this.activateOverlay(parseInt(e.target.dataset.index, 10));
          } else {
            // Turn overlay off
            this.deactivateOverlay(parseInt(e.target.dataset.index, 10));
          }
          // Update aria label
          this._setMainAriaLabel();
        });

        // Add completed row to wrapper
        overlaysWrapperEl.lastElementChild.appendChild(rowEl);
      });

      // Add wrapper to menu
      menuEl.appendChild(overlaysWrapperEl);
    }

    // Add menu to toolbar
    this.toolbar.layers.element.appendChild(detailsEl);
  }

  /**
   * Use the URL's for the active images to set appropriate images in OSD
   * @private
   * @method
   */
  _setWorldItems() {
    const worldItemCount = this.viewer.world.getItemCount();
    const worldItems = {
      a: this.viewer.world.getItemAt(worldItemCount === 1 ? 0 : 1),
    };
    const activeItems = {
      a: this.images.items[this.images.active.a],
      b: this.images.items[this.images.active.b],
    };

    // Require 'a' and 'b' to be set
    if (!activeItems.a || !activeItems.b) return;

    // Set worldItem.b if it exists (after initialisation)
    if (worldItemCount > 1) {
      worldItems.b = this.viewer.world.getItemAt(0);
    }

    if (worldItems['a'].source.url === activeItems['b'].url) {
      // Detect flip and swap world items
      // Reset / reapply UI opacity to world items
      this.viewer.world.getItemAt(1).setOpacity(0.999);
      this.viewer.world.setItemIndex(this.viewer.world.getItemAt(0), 1);
      this.viewer.world.getItemAt(1).setOpacity(1 - this.opacitySliderEl.value / 100);
    } else {
      // Loop active items and set images
      ['a', 'b'].forEach((key) => {
        // If a / b exists
        if (worldItems[key]) {
          if (worldItems[key].source.url !== activeItems[key].url) {
            // Add new image on top ([2, 1, 0])
            this.viewer.addSimpleImage({
              url: activeItems[key].url,
              index: 2,
              opacity: 0.999,
              preload: true,
              success: () => {
                // From this point query world directly to get fresh references
                // Remove the image this replaces
                this.viewer.world.removeItem(
                  this.viewer.world.getItemAt(key === 'a' ? 1 : 0)
                );
                // Set the new image to 'a' top, or 'b' bottom
                this.viewer.world.setItemIndex(
                  this.viewer.world.getItemAt(1),
                  key === 'a' ? 1 : 0
                );

                // If layer 'a' changes, reapply to  world item only
                this.setOpacity(this.opacitySliderEl.value / 100);
              },
            });
          }
        } else {
          // Create if necessary (initialisation)
          this.viewer.addSimpleImage({
            url: activeItems[key].url,
            index: key === 'b' ? 0 : 1,
            opacity: 0.999,
            success: () => {
              // Set initial opacity
              // The class method updates the UI + world item
              this.setOpacity(0);
            },
          });
        }
      });
    }
  }

  /**
   * Handle change events on image controls
   * @private
   * @method
   * @param {Number} index - Integer for target image control
   * @param {'a'|'b'} layer - Layer to handle change on
   */
  _handleControlImageChange(index, layer) {
    const targetEl = this.images.items[index].controlEls[layer];

    // Move to parent and checked items
    const allCheckedOptEls = targetEl
      .closest('.layered-image-viewer-details__section--images')
      .querySelectorAll('input:checked');

    // 2 = perform flip on the non-target adjacent
    // not null checks because initalise/assign may enter here and cause unintended flip
    if (
      allCheckedOptEls.length === 2 &&
      this.images.active.a !== null &&
      this.images.active.b !== null
    ) {
      Array.prototype.filter
        .call(allCheckedOptEls, (item) => {
          return item !== targetEl;
        })
        .forEach((item) => {
          // flipEl is somehow adjacent, layer === a is next and vice-versa
          const flipEl =
            layer !== 'a'
              ? item.closest('.radio').previousElementSibling.firstElementChild
              : item.closest('.radio').nextElementSibling.firstElementChild;

          // Update DOM
          item.checked = false;
          flipEl.checked = true;

          // Update state
          this.images.active[layer === 'a' ? 'a' : 'b'] = index;
          this.images.active[layer === 'a' ? 'b' : 'a'] = parseInt(
            flipEl.dataset.index
          );
        });
    }

    // More than 2 (only 3 should be possible) = unset any in column matching target
    // Excluding target
    else if (allCheckedOptEls.length > 2) {
      Array.prototype.filter
        .call(allCheckedOptEls, (item) => {
          return item.id.slice(-1) === layer && item !== targetEl;
        })
        .forEach((item) => {
          // Update DOM
          item.checked = false;

          // Update state
          this.images.active[layer] = index;
        });
    } else {
      // Should only trigger when initialising
      this.images.items[index].controlEls[layer].checked = true;
      this.images.active[layer] = index;
    }

    // Update images in viewer
    this._setWorldItems();

    // Update aria label
    this._setMainAriaLabel();
  }

  /**
   * Set a given image index to a named layer
   * @public
   * @method
   * @param {Number} index - Integer for target image element
   * @param {'a'|'b'} layer - Layer to assign image to
   */
  assignImageToLayer(index, layer) {
    if (!this.images.items[index]) return;

    // Control elements only present for multiple images
    if (this.images.items.length > 1) {
      // Set active to null to prevent flip operations
      this.images.active[layer] = null;

      const changeEvent = new Event('change');
      this.images.items[index].controlEls[layer].checked = true;
      this.images.items[index].controlEls[layer].dispatchEvent(changeEvent);
    } else {
      // Manually set layer for single image
      this.images.active[layer] = index;
    }

  }

  /**
   * Activate an overlay by the internally tracked index
   * @public
   * @method
   * @param {Number} index - Index of overlay to activate. Mirrors the order of the initial HTML
   */
  activateOverlay(index) {
    if (!this.overlays.items[index]) return;

    // There's two potential ways of doing this AFAIK
    // 1. Add an image. This doesn't work well with SVG
    // 2. Add an overlay. This works with imgs/svgs/html
    // There's also OpenSeadragon svgOverlay plugin, which from what I can tell
    // seems to be if you're working with arbitrary SVG code and not really suited to our files.

    // Clone our overlay, otherwise OSD seems to want to move it
    // (which makes destruction cleanup hard)
    const cloneEl = this.overlays.element
      .querySelector(`#layered-image-viewer-${this.id}-overlays-${index}`)
      .cloneNode();
    cloneEl.id = `layered-image-viewer-${this.id}-overlays-${index}-clone`;

    // May already be active (e.g. if on by default + reset)
    if (!this.overlays.active.includes(index)) {

      // Add to active list
      this.overlays.active.push(index);

      this.viewer.addOverlay({
        element: cloneEl,
        location: new OpenSeadragon.Point(0, 0),
        width: 1, // (viewport unit)
        index: index,
        opacity: 0.4,
      });
    }

  }

  /**
   * Deactivate an overlay by the internally tracked index
   * @public
   * @method
   * @param {Number} index - Index of overlay to activate. Mirrors the order of the initial HTML
   */
  deactivateOverlay(index) {
    if (!this.overlays.items[index]) return;

    // Remove from active list
    this.overlays.active = this.overlays.active.filter(
      (item) => item !== index
    );

    this.viewer.removeOverlay(
      `layered-image-viewer-${this.id}-overlays-${index}-clone`
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
