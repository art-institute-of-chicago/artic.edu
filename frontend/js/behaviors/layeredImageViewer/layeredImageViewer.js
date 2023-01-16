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
    this.setInitialState();
    this._initViewer();
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

    imgEls.forEach((imgEl) => {
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
    const _this = this;

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
      tileSources: {
        type: 'image',
        url: this.images[0].url, // First image from markup by default
      },
    });

    this.viewer.addHandler('open', () => {});
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
