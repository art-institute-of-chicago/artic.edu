import { includes, memoize } from 'lodash'; 
import assetURL from "../functions/assetURL";

const viewer360 = function(container) {
	let wrapper = container;
	console.log('wrapper', wrapper);
	let frame = 0;
	let windowWidth = window.innerWidth;
	let windowHeight = window.innerHeight;
	let isLarge = windowWidth >= 900;
	let image360Src = wrapper.querySelector('.m-viewer-360-image');
	let control360 = wrapper.querySelector('.m-viewer-360-control .input360');


	//inputs
	wrapper.addEventListener("wheel", handleMouseWheel);

	//get JSON content from web page
	let assetLibrary = document.getElementById("assetLibrary").textContent;
	let viewer360Files = JSON.parse(assetLibrary);
	let frames360 = viewer360Files.src;
	//optimize image size
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
	console.log('loadedFrameIndexes', loadedFrameIndexes);
	control360.setAttribute('max', frames360.length-1);

	//get index to find image to show
	function update360(frame) {
		const closestFrame = findClosestFrame(loadedFrameIndexes, frame);
		console.log('frames360', frames360);
		const image360 = frames360[closestFrame].src;
		console.log('image360', image360);
		image360Src.src = image360;
		//update input control
		control360.setAttribute('value', closestFrame);
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

	function handleMouseWheel(e) {
		console.log('WORD');
		e.preventDefault();
    //if (this.state.touchX !== null) return;
    let dir;
    if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) {
      dir = Math.sign(e.deltaY);
    } else {
      dir = Math.sign(e.deltaX);
		}
		let newFrame = frame + dir;
		frame = constrainFrame(newFrame);
		console.log('frame', frame);
		update360(frame);
	}

	function _init() {
		update360(frame);
	}  

	this.init = function() {
			_init();
	};
}

export default viewer360;