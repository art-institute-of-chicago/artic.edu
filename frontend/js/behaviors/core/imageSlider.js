import OpenSeadragon from '../../libs/openseadragon';
import '../../libs/imgixtilesource';

const imageSlider = function(container) {

  const handleElement = container.querySelector('.m-image-slider__handle');
  const viewerElement = container;

  const imageData = JSON.parse(container.dataset.images);

  let viewer;
  let middle;

  let leftImage = null;
  let rightImage = null;

  let leftRect = new OpenSeadragon.Rect(0,0,0,0);
  let rightRect = new OpenSeadragon.Rect(0,0,0,0);

  function updateMiddle(offset) {
    middle.x = offset;
  }

  function imagesLoaded() {
    if (leftImage && rightImage) {
      leftRect.height = leftImage.getContentSize().y;
      rightRect.height = rightImage.getContentSize().y;
      imagesClip();
      initClip();
    }
  }

  function imagesClip() {
    var rox = rightImage.viewerElementToImageCoordinates(middle).x;
    var lox = leftImage.viewerElementToImageCoordinates(middle).x;

    rightRect.x = rox;
    rightRect.width = rightImage.getContentSize().x - rox;

    leftRect.width = lox;

    leftImage.setClip(leftRect);
    rightImage.setClip(rightRect);
  }

  var oldSpringX = 0.5;

  function imagesClipAggressive() {
    if (!rightImage || !leftImage) {
      window.setTimeout(imagesClipAggressive, 200);
      return;
    }

    var newSpringX = viewer.viewport.centerSpringX.current.value;
    var deltaSpringX = newSpringX - oldSpringX;
    oldSpringX = newSpringX;

    var fixedMiddle = viewer.viewport.viewerElementToViewportCoordinates(middle);
    fixedMiddle.x += deltaSpringX;

    var rox = rightImage.viewportToImageCoordinates(fixedMiddle).x;
    var lox = leftImage.viewportToImageCoordinates(fixedMiddle).x;

    imagesClipShared(rox, lox);
  }

  function imagesClip() {
    if (!rightImage || !leftImage) {
      window.setTimeout(imagesClip, 200);
      return;
    }

    var rox = rightImage.viewerElementToImageCoordinates(middle).x;
    var lox = leftImage.viewerElementToImageCoordinates(middle).x;

    imagesClipShared(rox, lox);
  }

  function imagesClipShared(rox, lox) {
    rightRect.x = rox ;
    rightRect.width = rightImage.getContentSize().x - rox;

    leftRect.width = lox;

    leftImage.setClip(leftRect);
    rightImage.setClip(rightRect);
  }

  function initClip() {
    // We will assume that the width of the handle element does not change
    var dragWidth = handleElement.offsetWidth;

    // However, we will track when the container resizes
    var containerWidth, containerOffset, minLeft, maxLeft;

    function updateContainerDimensions() {
      containerWidth = viewerElement.offsetWidth;
      containerOffset = viewerElement.getBoundingClientRect().left + window.scrollX;
      minLeft = containerOffset + 10;
      maxLeft = containerOffset + containerWidth - dragWidth - 10;

      // Spoof the mouse events
      var offset = handleElement.getBoundingClientRect().left + window.scrollX + dragWidth / 2;
      var event;

      // Bind the drag event
      event = new Event('mousedown');
      event.pageX = offset;

      handleElement.dispatchEvent(event);

      // Execute the drag event
      event = new Event('mousemove');
      event.pageX = offset;

      viewerElement.dispatchEvent(event);

      // Unbind the drag event
      handleElement.dispatchEvent(new Event('mouseup'));
    }

    // Retrieve initial container dimention
    updateContainerDimensions();

    // Bind the container resize
    window.addEventListener('resize', updateContainerDimensions);

    function handleTouchStart(event) {
      handleStartShared(event.targetTouches[0].pageX);
    }

    function handleMouseDown(event) {
      handleStartShared(event.pageX);
    }

    function handleStartShared(pageX) {
      var xPosition = handleElement.getBoundingClientRect().left + window.scrollX + dragWidth - pageX;

      function trackDragMouse(event) {
        trackDragShared(event.pageX);
      }

      function trackDragTouch(event) {
        trackDragShared(event.changedTouches[0].pageX);
      }

      function trackDragShared(pageX) {
        var leftValue = pageX + xPosition - dragWidth;

        //constrain the draggable element to move inside its container
        leftValue = Math.max(leftValue, minLeft);
        leftValue = Math.min(leftValue, maxLeft);

        var widthPixel = (leftValue + dragWidth/2 - containerOffset);
        var widthFraction = widthPixel/containerWidth;
        var widthPercent = widthFraction*100+'%';

        handleElement.style.left = widthPercent;

        updateMiddle(widthPixel);
        imagesClip();
      }

      viewerElement.addEventListener('mousemove', trackDragMouse);
      viewerElement.addEventListener('touchmove', trackDragTouch);

      function unbindTrackDrag(event) {
        viewerElement.removeEventListener('mousemove', trackDragMouse);
        viewerElement.removeEventListener('touchmove', trackDragTouch);
      }

      document.addEventListener('mouseup', unbindTrackDrag, {once: true});
      document.addEventListener('touchend', unbindTrackDrag, {once: true});

      event.preventDefault();
    }

    handleElement.addEventListener('mousedown', handleMouseDown);
    handleElement.addEventListener('touchstart', handleTouchStart);
  }

  this.destroy = function() {
    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {

    viewer = OpenSeadragon({
      element:         viewerElement,
      xmlns:           'http://schemas.microsoft.com/deepzoom/2008',
      prefixUrl:       '//openseadragon.github.io/openseadragon/images/',
      springStiffness: 15, // 6.5
      visibilityRatio: 1, // 0.5
      zoomPerClick: imageData.isSliderZoomable ? 1.3 : 1, // 2.0
      constrainDuringPan: true, // false
      animationTime: 1.5, // 1.2
      minZoomLevel: 0, // null
      maxZoomPixelRatio: 1.0, // 1.1
      minZoomImageRatio: 1.0, // 0.9
      gestureSettingsMouse: {
        scrollToZoom: false,
      },
      zoomInButton: imageData.zoomInButtonId,
      zoomOutButton: imageData.zoomOutButtonId,
      showZoomControl: true,
      showHomeControl: true,
      showFullPageControl: false,
      showRotationControl: false,
      showSequenceControl: false,
    });

    middle = new OpenSeadragon.Point(viewerElement.clientWidth / 2, viewerElement.clientHeight / 2);

    viewer.addHandler('animation-start', imagesClip);
    viewer.addHandler('animation', imagesClipAggressive);

    viewer.addTiledImage({
        tileSource: imageData.leftImage,
        success: function(event) {
            leftImage = event.item;
            imagesLoaded();
        }
    });

    viewer.addTiledImage( {
        tileSource: imageData.rightImage,
        success: function(event) {
            rightImage = event.item;
            imagesLoaded();
        }
    });
  };
};

export default imageSlider;
