import { includes, memoize } from 'lodash'; 
import assetURL from "../functions/assetURL";

const viewer360 = function(container) {
	let wrapper = container;
	console.log('wrapper', wrapper);
	let frame = 0;
	let touchX = null;
	let touchFrame = null;
	let windowWidth = window.innerWidth;
	let windowHeight = window.innerHeight;
	let isLarge = windowWidth >= 900;
	let image360Src = wrapper.querySelector('.m-viewer-360-image');
	let control360 = wrapper.querySelector('.m-viewer-360-control .input360');

	//get JSON content from web page
	let assetLibrary = document.getElementById("assetLibrary").textContent;
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
	control360.setAttribute('max', frames360.length-1);

	//get index to find image to show
	function update360(frame) {
		const closestFrame = findClosestFrame(loadedFrameIndexes, frame);
		const image360 = frames360[closestFrame].src;
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

	//inputs
	wrapper.addEventListener("wheel", handleMouseWheel.bind(this));
	control360.addEventListener("input", handleInputChange.bind(this));

	window.addEventListener("mousedown", handleTouchEvents.bind(this));
	window.addEventListener("mousemove", handleTouchEvents.bind(this));
	window.addEventListener("mouseup", handleTouchEvents.bind(this));
	window.addEventListener("touchstart", handleTouchEvents.bind(this));
	window.addEventListener("touchmove", handleTouchEvents.bind(this));
	window.addEventListener("touchend", handleTouchEvents.bind(this));
	window.addEventListener("touchcancel", handleTouchEvents.bind(this));

	function handleTouchEvents(e) {
		/*
		console.log('frame1', this.frame);
		let { pageX, touches } = e;
		if (touches && touches.length) pageX = touches[0].pageX;
		switch (e.type) {
      case "mousedown":
      case "touchstart":
        this.touchX = pageX;
				this.touchFrame = frame;
				console.log('mousedown', this);
				break;
			case "mousemove":
			case "touchmove":
				console.log('mousemove', this);
				if (this.touchX === null) return;
				//console.log('frame2', frame);
				const delta = frames360.length / Math.min(1000, (wrapper.offsetWidth * 0.8));
				const diff = (pageX - this.touchX) * delta;
				//console.log('this.touchX', this.touchX);
				//console.log('pageX', pageX);
				let newFrame = this.touchFrame + diff;
				//console.log('newFrame', newFrame);
				frame = constrainFrame(newFrame);
				//console.log('new frame', frame);
				//update360(frame);
				break;
				/*
			case "touchend":
			case "touchcancel":
			case "mouseup":
				this.touchX = null;
				this.touchFrame = null;
				break;
			default:
				return;

		}*/
		
	}
	
	function handleInputChange(e) {
		frame = constrainFrame(e.target.value);
		update360(frame);
	};
	

	function handleMouseWheel(e) {
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