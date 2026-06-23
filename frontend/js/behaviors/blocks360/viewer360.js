import { includes, memoize } from 'lodash';
import assetURL from "../../functions/core/assetURL";
import fetchImageBlob from '../../functions/core/fetchImageBlob';
import { protectFromUnmount } from '../../functions/core/protectFromUnmount';

const viewer360 = function(container) {
	let wrapper = container;
	let currentFrame = 0;
	let targetFrame = 0;
	let animFrame = null;
	let touchX = null;
	let touchFrame = 0;
	let windowWidth = window.innerWidth;
	let windowHeight = window.innerHeight;
	let isLarge = windowWidth >= 900;
	let image360Src = wrapper.querySelector('.m-viewer-360-image');
	let control360 = wrapper.querySelector('.m-viewer-360-control');
	let input360 = wrapper.querySelector('.m-viewer-360-control .input360');
	let rotateArrows = wrapper.closest('.m-media--360-embed')?.querySelector('.m-rotate-arrows');
	let loadedFrames = {};
	let protect = protectFromUnmount();

	//get JSON content from web page
	let sequenceId = wrapper.dataset.id;
	let assetLibrary = document.getElementById(sequenceId).textContent;
	let viewer360Files = JSON.parse(assetLibrary);
	let frames360 = viewer360Files.src;

	const viewerType = wrapper.closest('[data-360-type]')?.getAttribute('data-360-type');
	//optimize image size with imgix urls
	frames360 = frames360.map(frame => ({
		frame: frame.frame,
		src: assetURL(frame.src, {
			w: isLarge ? (windowWidth - 120) * (window.devicePixelRatio || 1) : windowWidth * (window.devicePixelRatio || 1),
			h: isLarge ? (windowHeight - 80) * (window.devicePixelRatio || 1) : windowHeight * (window.devicePixelRatio || 1),
			q: 75
		})
	}));

	//store indexes of frames
	const loadedFrameIndexes = Object.keys(frames360).map(k => parseInt(k));
	input360.setAttribute('max', frames360.length-1);

	//get index to find image to show
	function update360(tocurrentFrame) {
		const closestFrame = findClosestFrame(loadedFrameIndexes, tocurrentFrame);
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

	function wrapFrame(frame) {
		const len = loadedFrameIndexes.length;
		return ((parseInt(frame, 10) % len) + len) % len;
	}

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
					update360(currentFrame);
				}
			}));

		})

	};

	//cursor
	if (viewerType === 'digital-explorer') {
		wrapper.style.cursor = 'grab';
		control360.style.margin = 0;
		control360.style.width = '100%';
		input360.style.width = '100%';
		wrapper.addEventListener('mousedown', () => { wrapper.style.cursor = 'grabbing'; });
		wrapper.addEventListener('mouseup', () => { wrapper.style.cursor = 'grab'; });
		wrapper.addEventListener('mouseleave', () => { wrapper.style.cursor = 'grab'; });
	}

	//inputs
	wrapper.addEventListener("mousedown", handleEvents.bind(this));
	wrapper.addEventListener("mousemove", handleEvents.bind(this));
	wrapper.addEventListener("mouseup", handleEvents.bind(this));
	wrapper.addEventListener("touchstart", handleEvents.bind(this));
	wrapper.addEventListener("touchmove", handleEvents.bind(this));
	wrapper.addEventListener("touchend", handleEvents.bind(this));
	wrapper.addEventListener("touchcancel", handleEvents.bind(this));
	wrapper.addEventListener("mouseleave", handleEvents.bind(this));

	function handleEvents(e) {
		let { pageX, touches } = e;
		if (touches && touches.length) pageX = touches[0].pageX;
		switch (e.type) {
			case "mousedown":
			case "touchstart":
				touchX = pageX;
				touchFrame = currentFrame;
				if (rotateArrows) rotateArrows.classList.add('is-interacting');
				break;

			case "mousemove":
			case "touchmove":
				if (touchX === null) return;
				const delta = frames360.length / Math.min(1000, (control360.offsetWidth * 0.8));
				const diff = (pageX - touchX) * delta;
				let newFrame = constrainFrame(touchFrame + diff);
				if (viewerType === 'digital-explorer') {
					let wrapped = touchFrame - diff;
					let nextTarget = wrapFrame(wrapped);
					if (Math.abs(nextTarget - currentFrame) > loadedFrameIndexes.length / 2) {
						cancelAnimationFrame(animFrame);
						animFrame = null;
						currentFrame = nextTarget;
						update360(Math.round(currentFrame));
					}
					targetFrame = nextTarget;
					if (!animFrame) animFrame = requestAnimationFrame(smoothFrame);
				} else {
					if (currentFrame == newFrame) return;
					currentFrame = newFrame;
					update360(currentFrame);
				}
				break;

			case "touchend":
			case "touchcancel":
			case "mouseup":
				touchX = null;
				touchFrame = null;
				if (rotateArrows) rotateArrows.classList.remove('is-interacting');
				break;

			case "mouseleave":
				touchX = null;
				touchFrame = null;
				if (rotateArrows) rotateArrows.classList.remove('is-interacting');
				break;
		}
	}

	function _init() {
		preloadFrameIndexes(loadedFrameIndexes);
	}

	function smoothFrame() {
		const gap = Math.abs(targetFrame - currentFrame);
		currentFrame += (targetFrame - currentFrame) * 0.35;
		if (gap < 0.01) {
			currentFrame = targetFrame;
			animFrame = null;
		} else {
			animFrame = requestAnimationFrame(smoothFrame);
		}
		update360(Math.round(currentFrame));
	}

	this.init = function() {
			_init();
	};

	this.destroy = function() {
		A17.Helpers.purgeProperties(this);
	}
}

export default viewer360;
