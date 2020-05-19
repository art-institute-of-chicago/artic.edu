import { purgeProperties } from '@area17/a17-helpers';

const imageSlider = function(container) {

let dragWidth;
let xPosition;
let containerOffset;
let containerWidth;
let minLeft;
let maxLeft;

const dragElement = container.querySelector('.m-image-slider__handle');
  const resizeElement = container.querySelector('.m-image-slider__resize-img');

  function enableDragFunction(event) {
    dragElement.classList.add('draggable')
    resizeElement.classList.add('resizable');

    dragWidth = dragElement.outerWidth(),
    xPosition = dragElement.offset().left + dragWidth - event.pageX,
    containerOffset = container.offset().left,
    containerWidth = container.outerWidth(),
    minLeft = containerOffset + 10,
    maxLeft = containerOffset + containerWidth - dragWidth - 10;

    event.preventDefault();
  }

  function enableParentDragFunction(event) {
    let leftValue = event.pageX + xPosition - dragWidth;

    //constrain the draggable element to move inside its container
    if(leftValue < minLeft ) {
        leftValue = minLeft;
    } else if ( leftValue > maxLeft) {
        leftValue = maxLeft;
    }

    let widthValue = (leftValue + dragWidth/2 - containerOffset)*100/containerWidth+'%';

    dragElement.style.left = widthValue;
    resizeElement.style.width = widthValue;
  }

  function disableDragFunction(event) {
    dragElement.classList.remove('draggable');
    resizeElement.classList.remove('resizable');
  }

  this.destroy = function() {
    dragElement.removeEventListener('mousedown', enableDragFunction);
    dragElement.removeEventListener('vmousedown', enableDragFunction);
    dragElement.removeEventListener('mouseup', disableDragFunction);
    dragElement.removeEventListener('vmouseup', disableDragFunction);

    dragElement.parentNode.removeEventListener('mousedown', enableDragFunction);
    dragElement.parentNode.removeEventListener('vmousedown', enableDragFunction);
    dragElement.parentNode.removeEventListener('mouseup', disableDragFunction);
    dragElement.parentNode.removeEventListener('vmouseup', disableDragFunction);

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    dragElement.addEventListener('mousedown', enableDragFunction, false);
    dragElement.addEventListener('vmousedown', enableDragFunction, false);
    dragElement.addEventListener("mouseup", disableDragFunction);
    dragElement.addEventListener("vmouseup", disableDragFunction);

    dragElement.parentNode.addEventListener('mousedown', enableParentDragFunction, false);
    dragElement.parentNode.addEventListener('vmousedown', enableParentDragFunction, false);
    dragElement.parentNode.addEventListener("mouseup", disableDragFunction);
    dragElement.parentNode.addEventListener("vmouseup", disableDragFunction);
  };
};

export default imageSlider;
