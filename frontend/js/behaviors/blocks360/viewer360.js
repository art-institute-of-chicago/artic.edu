import { includes, memoize } from 'lodash';
import assetURL from "../../functions/core/assetURL";
import fetchImageBlob from '../../functions/core/fetchImageBlob';
import { protectFromUnmount } from '../../functions/core/protectFromUnmount';

const viewer360 = function(container) {
	let wrapper = container;
	let curFrame = 0;
	let touchX = null;
	let touchFrame = 0;
	let windowWidth = window.innerWidth;
	let windowHeight = window.innerHeight;
	let isLarge = windowWidth >= 900;
	let image360Src = wrapper.querySelector('.m-viewer-360-image');
	let control360 = wrapper.querySelector('.m-viewer-360-control');
	let input360 = wrapper.querySelector('.m-viewer-360-control .input360');
	let loadedFrames = {};
	let protect = protectFromUnmount();

	//get JSON content from web page
	let sequenceId = wrapper.dataset.id;
	let assetLibrary = document.getElementById(sequenceId).textContent;
	let viewer360Files = JSON.parse(assetLibrary);
	let frames360 = viewer360Files.src;
	//optimize image size with imgix urls
	frames360 = frames360.map(frame => ({
		frame: frame.frame,
		src: assetURL(frame.src, {
			w: isLarge ? windowWidth - 120 : windowWidth,
			h: isLarge ? windowHeight - 80 : windowHeight,
			q: 75
		})
	}));

	//store indexes of frames
	const loadedFrameIndexes = Object.keys(frames360).map(k => parseInt(k));
	input360.setAttribute('max', frames360.length-1);

	//get index to find image to show
	function update360(curFrame) {
		const closestFrame = findClosestFrame(loadedFrameIndexes, curFrame);
		const image360 = loadedFrames[closestFrame];
		if (typeof image360 != 'undefined') {
			wrapper.classList.remove('loader');
			image360Src.style.opacity = 1;
			image360Src.src = image360;
			control360.style.opacity = 1;
		}
		//update input control
		input360.value = closestFrame;
		input360.setAttribute('value', closestFrame);
	}

	//find closest frame based on input
	var findClosestFrame = memoize((frames, target) => {
    if (!frames.length) return null;
    if (includes(frames, target)) return target;
    return frames.reduce(function(prev, curr) {
      return Math.abs(curr - target) < Math.abs(prev - target)
        ? curr
        : prev;
    });
  }, (frames, target) => `${frames.join(',')}@${target}`);

	function constrainFrame(frame) {
    return Math.max(0, Math.min(loadedFrameIndexes.length - 1, parseInt(frame, 10)));
	};

	//preload all 360 images for smoother transition
	function preloadFrameIndexes(frameIndexesToLoad) {
		let fetchedAll = 0;
    frameIndexesToLoad.map(frame => {
      if( !frames360[frame] ) return [];
      return frames360[frame];
    }).forEach(({ src, frame }) => {
      fetchImageBlob(src, protect((blob) => {
				const url = URL.createObjectURL(blob);
				Object.assign( loadedFrames, {
					[frame]: url
				});
				fetchedAll++
				if (fetchedAll == frames360.length) {
					update360(curFrame);
				}
			}));

		})

  };

	//inputs
	wrapper.addEventListener("wheel", handleMouseWheel.bind(this));
	wrapper.addEventListener("mousedown", handleEvents.bind(this));
	wrapper.addEventListener("mousemove", handleEvents.bind(this));
	wrapper.addEventListener("mouseup", handleEvents.bind(this));
	wrapper.addEventListener("touchstart", handleEvents.bind(this));
	wrapper.addEventListener("touchmove", handleEvents.bind(this));
	wrapper.addEventListener("touchend", handleEvents.bind(this));
	wrapper.addEventListener("touchcancel", handleEvents.bind(this));

	function handleEvents(e) {
		let { pageX, touches } = e;
		if (touches && touches.length) pageX = touches[0].pageX;
		switch (e.type) {
      case "mousedown":
      case "touchstart":
				touchX = pageX;
				touchFrame = curFrame;
				break;

			case "mousemove":
			case "touchmove":
				if (touchX === null) return;
				const delta = frames360.length / Math.min(1000, (control360.offsetWidth * 0.8));
				const diff = (pageX - touchX) * delta;
				let newFrame = constrainFrame(touchFrame + diff);
				if (curFrame == newFrame) return;
				curFrame = newFrame;
				update360(curFrame);
				break;

			case "touchend":
			case "touchcancel":
			case "mouseup":
				touchX = null;
				touchFrame = null;
				break;

			default:
				return;
		}
	}

	function handleMouseWheel(e) {
		e.preventDefault();
    //if (this.state.touchX !== null) return;
    let dir;
    if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
      dir = Math.sign(e.deltaY);
    } else {
      dir = Math.sign(e.deltaX);
		}
		let newFrame = curFrame + dir;
		curFrame = constrainFrame(newFrame);
		update360(curFrame);
	}

	function _init() {
		preloadFrameIndexes(loadedFrameIndexes);
	}

	this.init = function() {
			_init();
	};

  this.destroy = function() {
    A17.Helpers.purgeProperties(this);
  }
}

export default viewer360;
