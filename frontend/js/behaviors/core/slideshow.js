const CAROUSEL_CLASS = 'slideshow-carousel';
const POSITION_CLASS = 'slideshow-position';
const POSITION_INDEX_PREFIX = `${POSITION_CLASS}-`;
const CURRENT_POSITION_CLASS = `${POSITION_INDEX_PREFIX}current`;
const DISPLAY_INTERVAL_MILLISECONDS = 5000; // 5 seconds

const slideshow = function(container) {
  const carousel = container.querySelector(`.${CAROUSEL_CLASS}`);
  const positions = Array.from(container.querySelector(`.${POSITION_CLASS}`).children);

  let displayInterval;

  function automaticallyAdvanceSlide() {
    const currentPosition = container.querySelector(`.${CURRENT_POSITION_CLASS}`);
    const currentIndex = getPositionIndex(currentPosition);
    let nextIndex = currentIndex + 1;
    // Reset the index if the current position is the end of the slideshow.
    if (nextIndex == positions.length) {
      nextIndex = 0;
    }
    const nextPosition = container.querySelector(`#${POSITION_INDEX_PREFIX}${nextIndex}`)
    changePosition(currentPosition, nextPosition);
  }

  function selectSlide(event) {
    clearInterval(displayInterval);
    displayInterval = setInterval(automaticallyAdvanceSlide, DISPLAY_INTERVAL_MILLISECONDS);
    const currentPosition = container.querySelector(`.${CURRENT_POSITION_CLASS}`);
    changePosition(currentPosition, event.target);
  }

  function changePosition(currentPosition, nextPosition) {
    currentPosition.classList.remove(CURRENT_POSITION_CLASS);
    nextPosition.classList.add(CURRENT_POSITION_CLASS);
    const positionIndex = getPositionIndex(nextPosition);
    // Move the carousel horizontally to display the adjacent slide.
    // For example, `translateX(-100%)` moves the carousel 100% of its parent
    // element's width (one slide's width) to the left.
    carousel.style.transform = `translateX(-${positionIndex * 100}%)`;
  }

  function getPositionIndex(position)
  {
    return parseInt(position.id.replace(POSITION_INDEX_PREFIX, ''));
  }

  this.init = function() {
    displayInterval = setInterval(automaticallyAdvanceSlide, DISPLAY_INTERVAL_MILLISECONDS);
    positions.forEach(pip => pip.addEventListener('click', selectSlide));
  };

  this.destroy = function() {
    clearInterval(displayInterval);
    positions.forEach(pip => pip.removeEventListener('click', selectSlide));
    A17.Helpers.purgeProperties(this);
  };
}

export default slideshow;
