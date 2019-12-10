import Sketchfab from '@sketchfab/viewer-api';
import vec3 from 'gl-vec3';
import ScrollWindow from '../functions/scrollWindow';
import distance2d from '../functions/distance2D';
import { purgeProperties, triggerCustomEvent } from '@area17/a17-helpers';

const viewer3D = function(container) {
  let wrapper = container;
  let el = wrapper.querySelector('iframe');
  let layer = wrapper.querySelector('.m-viewer-3d__hotspots');
  let descriptionBlock = wrapper.querySelector('.m-viewer-3d__annotation');
  let btnContainer = wrapper.querySelector('.m-viewer-3d__tools');
  let btnFullscreen = wrapper.querySelector('.m-viewer-3d__fullscreen');
  let btnZoomIn = wrapper.querySelector('.m-viewer-3d__zoom-in');
  let btnZoomOut = wrapper.querySelector('.m-viewer-3d__zoom-out');
  let btnExplore = wrapper.querySelector('.m-viewer-3d__overlay');
  let btnCloseAnnotation = descriptionBlock.querySelector('.m-viewer-3d__annotation__close');
  let hideAnnots = JSON.parse(wrapper.dataset.hideannot);
  let cc0 = JSON.parse(wrapper.dataset.cc);
  let isGuided = JSON.parse(wrapper.dataset.guided);
  let uid = wrapper.dataset.uid;
  let moduleType = wrapper.dataset.type; 
  let moduleTitle = wrapper.dataset.title;
  let annotationList = JSON.parse(wrapper.dataset.annotations);
  let hasTransparency = (moduleType == 'modal' || moduleType == 'standalone') ? false : true;
  let hasZoom = (moduleType == 'modal' || moduleType == 'standalone') ? true : false;
  let annots = (moduleType != 'article') ? annotationList : [];

  let annotations = annots.map(function(annotation) {
    return {
      position3d: annotation.position,
      position2d: null,
      eye: annotation.eye,
      distance: null,
      title: annotation.name,
      description: annotation.content.raw
    };
  });
  let annotationEls = null;
  let selectedAnnotation = null;
  let cameraPosition = null;
  let initialCameraTarget = null;
  let initialCameraPosition = null;
  let requestMethod = wrapper.requestFullScreen || wrapper.webkitRequestFullScreen || wrapper.mozRequestFullScreen || wrapper.msRequestFullScreen;

  const client = new Sketchfab(el);
  let cameraConst = null;
  let apiConst = null;

  function updateAnnotation(annot, i) {
    function setPosition(coord) {
      annot.position2d = coord.canvasCoord;
      if(annotationEls) {
        var transform = `translate(${coord.canvasCoord[0]}px, ${coord.canvasCoord[1]}px)`;
        annotationEls[i].style.transform = transform;
      }
    }
    apiConst.getWorldToScreenCoordinates(annot.position3d, setPosition.bind(this));
  };

  function onTick() {
    if(apiConst && cameraConst && cameraPosition && moduleType != 'modal' && moduleType != 'standalone') {
      apiConst.setCameraLookAt(cameraPosition, cameraConst.target, 0);
    }
    annotations.forEach(updateAnnotationFct);
    requestAnimationFrame(onTickFct);
  };

  function onClick(e) {
    var closest = null;
    var maxDistance = +Infinity;
    var distance;
    for (var i = 0, l = annotations.length; i < l; i++) {
      distance = distance2d(annotations[i].position2d, e.position2D);
      if (distance < maxDistance) {
        closest = i;
        maxDistance = distance;
      }
    }

    if(maxDistance < 30) {
      selectedAnnotation = closest;
    } else {
      selectedAnnotation = null;
    }

    _renderAnnotation();
  };

  let updateAnnotationFct = updateAnnotation.bind(this);
  let onTickFct = onTick.bind(this);
  let onClickFct = onClick.bind(this);

  function _init() {
    client.init(uid, {
      ui_controls: 0,
      ui_infos: 0,
      ui_stop: 0,
      ui_inspector: 0,
      ui_annotations: 0,
      ui_hint: 0,
      ui_watermark_link: 0,
      annotations_visible: 0,
      preload: 0,
      camera: 0,
      autostart: (moduleType == 'article') ? 1 : 0,
      scrollwheel: (moduleType == 'modal') ? 1 : 0,
      //orbit_constraint_pan: 1,
      transparent: hasTransparency,
      success: function onSuccess(apiVar) {

        apiVar.start();
        apiVar.addEventListener(
          'viewerready',
          function() {

            apiConst = apiVar;
            onTick();
            _buildDOM();
            apiConst.setCameraEasing('easeLinear');
            apiConst.getCameraLookAt(
              function(err, cameraVar) {
                cameraConst = cameraVar;
                _isReady();
              }.bind(this)
            );

            if(btnContainer) btnContainer.classList.add('is-visible');
            if(btnCloseAnnotation) btnCloseAnnotation.addEventListener('click', _closeAnnotation.bind(this, 2));
            if(btnFullscreen && cc0 && requestMethod) {
              btnFullscreen.addEventListener('click', _onClickFullscreen.bind(this, 2));
              document.addEventListener('fullscreenchange', _exitFullscreenHandler);
              document.addEventListener('webkitfullscreenchange', _exitFullscreenHandler);
              document.addEventListener('mozfullscreenchange', _exitFullscreenHandler);
              document.addEventListener('MSFullscreenChange', _exitFullscreenHandler);
            }

            /*if(document.querySelector('.f-headline-editorial')) {
              moduleTitle += document.querySelector('.f-headline-editorial').textContent;
            }*/

            var duration = 0.2, factor = 0.5;

            if(hasZoom) {
              apiConst.zoom = function(factor, duration) {
                apiConst.getCameraLookAt(function(err, camera) {
                  if(!err) {
                    var currentPos = camera.position,
                    x = currentPos[0],
                    y = currentPos[1],
                    z = currentPos[2],
                    target = camera.target,
                    rho = Math.sqrt((x * x) + (y * y) + (z * z)),
                    phi,
                    theta,
                    minRadius = 0.1,
                    maxRadius = Infinity;

                    if(rho === minRadius || rho === maxRadius) return;
                    rho = (rho * factor);

                    if(rho < minRadius && factor < 1) {
                      rho = minRadius;
                    } else if (rho > maxRadius && factor > 1) {
                      rho = maxRadius;
                    }

                    phi = Math.atan2(y, x);
                    theta = Math.atan2((Math.sqrt((x * x) + (y * y))), z);
                    x = (rho * Math.sin(theta) * Math.cos(phi));
                    y = (rho * Math.sin(theta) * Math.sin(phi));
                    z = (rho * Math.cos(theta));
                    apiConst.setCameraLookAt([x, y, z], target, duration);
                  }
                });
              };

              btnZoomIn.addEventListener('click', function() {
                apiConst.zoom(1 - factor, duration);
              });

              btnZoomOut.addEventListener('click', function() {
                apiConst.zoom(1 + factor, duration);
              });
            }

          }.bind(this)
        );
        apiVar.addEventListener('click', onClickFct);

      }.bind(this),
      error: function onError() {
        //error
      }
    });

    if((!cc0 || !requestMethod) && btnFullscreen) btnFullscreen.remove();

    if(!hasZoom) {
      if(btnZoomIn) btnZoomIn.remove();
      if(btnZoomOut) btnZoomOut.remove();
    }

    if(hideAnnots) {
      wrapper.parentNode.classList.add('no-annotations');
    }

    if(moduleType == 'standalone') {
      wrapper.classList.add('has-overlay');
      triggerCustomEvent(document, 'gtm:push', {
        'event': '3D-tap-start',
        'eventCategory': 'in-page',
        'eventAction': moduleTitle
      });
      if(btnExplore) btnExplore.addEventListener('click', _onClickExplore.bind(this, 2));
    }
  };

  function _buildDOM() {
    var html = annotations.map(function(annotation, i) {
      return `<div class="a-hotspot" data-id="${i}" data-num="${i+1}" style="transform: translate(-100%, -100%)"><button class="a-hotspot__point" aria-label="Open hotspot"></button></div>`;
    }).join('');
    layer.innerHTML = html;
    annotationEls = Array.from(layer.querySelectorAll('.a-hotspot'));
    document.addEventListener('keyup', _onKeyUp);
  };

  function _isReady() {
    cameraPosition = vec3.fromValues(
      cameraConst.position[0],
      cameraConst.position[1],
      cameraConst.position[2]
    );

    initialCameraTarget = vec3.fromValues(
      cameraConst.target[0],
      cameraConst.target[1],
      cameraConst.target[2]
    );

    initialCameraPosition = vec3.clone(cameraPosition);

    var cameraPathArr = [],
      cameraScrollSpeed = 1.5,
      nbHotspots = annotationList.length;

    if(moduleType == 'article') {
      var containerText = wrapper.parentNode;
    }

    annotationList.forEach(function(annot, i) {
      var cameraPathSingle,
        blockText = document.createElement("div");

      if(moduleType == 'article') {
        var blockWindow = document.createElement("div");
        blockWindow.classList.add('m-media--3d-tour__sep');
        blockWindow.setAttribute('data-hotspot', i);
        blockText.innerHTML = '<p class="m-media--3d-tour__p"><strong>' + annot.name + '</strong>' + annot.content.raw + '</p>';
        containerText.appendChild(blockWindow);
        containerText.appendChild(blockText);
        containerText.classList.remove('is-not-loaded');
      }

      if(i == 0) {
        cameraPathSingle = [initialCameraPosition, annotationList[i].eye];
      } else {
        cameraPathSingle = [annotationList[i-1].eye, annotationList[i].eye];
      }

      cameraPathArr.push(cameraPathSingle);
    });

    if(moduleType == 'article') {

      var windowDiv = wrapper.parentNode.querySelectorAll('.m-media--3d-tour__sep'); 
      windowDiv.forEach(function(div, i) {
        var scrollWindow = new ScrollWindow(div, function(progress) {
          if(cameraPosition && progress > 0 && progress < 100) {
            var cameraProgress = Math.min(100, progress * cameraScrollSpeed);
            cameraPosition[0] = cameraPathArr[i][0][0] + ((cameraPathArr[i][1][0] - cameraPathArr[i][0][0]) / 100) * cameraProgress;
            cameraPosition[1] = cameraPathArr[i][0][1] + ((cameraPathArr[i][1][1] - cameraPathArr[i][0][1]) / 100) * cameraProgress;
            cameraPosition[2] = cameraPathArr[i][0][2] + ((cameraPathArr[i][1][2] - cameraPathArr[i][0][2]) / 100) * cameraProgress;
          }
        });
      });

      triggerCustomEvent(document, 'module3d:loaded');

    }
  };

  function _onClickFullscreen() {
    if(cc0 && requestMethod) {
      if(document.fullscreenElement) {
        btnFullscreen.classList.remove('is-active');
        document.exitFullscreen();
      } else {
        btnFullscreen.classList.add('is-active');
        requestMethod.call(wrapper);
      }
    }
  };

  function _exitFullscreenHandler() {
    if(!document.fullscreenElement && btnFullscreen) btnFullscreen.classList.remove('is-active');
  };

  function _onClickExplore() {
    wrapper.classList.remove('has-overlay');
    if(btnExplore) btnExplore.removeEventListener('click', _onClickExplore.bind(this, 2));
  };

  function _closeAnnotation() {
    selectedAnnotation = null;
    _renderAnnotation();
  };

  function _renderAnnotation() {
    if(layer.querySelector('.a-hotspot--selected') !== null) {
      layer.querySelector('.a-hotspot--selected').classList.remove('a-hotspot--selected');
    }
    if(selectedAnnotation !== null) {
      descriptionBlock.querySelector('.m-viewer-3d__annotation__content').innerHTML = '<p class="m-viewer-3d__annotation__title">' + annotations[selectedAnnotation].title + '</p> ' + annotations[selectedAnnotation].description;
      if (descriptionBlock.className.indexOf(' is-visible') === -1) {
        descriptionBlock.className += ' is-visible';
      }
      if(moduleType == 'modal' || moduleType == 'standalone') {
        apiConst.setCameraLookAt(annotations[selectedAnnotation].eye, annotations[selectedAnnotation].position3d, 0.6);
      }
      annotationEls[selectedAnnotation].classList.add('a-hotspot--selected');
      descriptionBlock.querySelector('.m-viewer-3d__annotation__close').tabIndex = 0;
      descriptionBlock.querySelector('.m-viewer-3d__annotation__close').focus();
      triggerCustomEvent(document, 'gtm:push', {
        'event': '3D-tap-hotspot',
        'eventCategory': 'in-page',
        'eventAction': moduleTitle+' - '+selectedAnnotation
      });
    } else {
      descriptionBlock.className = descriptionBlock.className.replace(' is-visible', '');
      descriptionBlock.querySelector('.m-viewer-3d__annotation__close').tabIndex = -1;
      setTimeout(function() {
        descriptionBlock.querySelector('.m-viewer-3d__annotation__content').innerHTML = '';
      },400);
      if(moduleType == 'modal' || moduleType == 'standalone') {
        apiConst.setCameraLookAt(initialCameraPosition, initialCameraTarget, 0.6);
      }
    }
  };

  function _onKeyUp(event) {
    if(event.target.matches('.a-hotspot__point') && (event.keyCode == 13 || event.keyCode == 32)) {
      selectedAnnotation = parseInt(event.target.parentNode.dataset.id);
      _renderAnnotation();
    }
  };

  this.destroy = function() {
    // remove specific event handlers
    if(apiVar) apiVar.removeEventListener('click', onClickFct);
    if(btnCloseAnnotation) btnCloseAnnotation.removeEventListener('click', _closeAnnotation.bind(this, 2));
    if(btnExplore) btnExplore.removeEventListener('click', _onClickExplore.bind(this, 2));
    if(btnFullscreen && cc0 && requestMethod) {
      btnFullscreen.removeEventListener('click', _onClickFullscreen.bind(this, 2));
      document.removeEventListener('fullscreenchange', _exitFullscreenHandler);
      document.removeEventListener('webkitfullscreenchange', _exitFullscreenHandler);
      document.removeEventListener('mozfullscreenchange', _exitFullscreenHandler);
      document.removeEventListener('MSFullscreenChange', _exitFullscreenHandler);
    }
    document.removeEventListener('keyup', _onKeyUp);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default viewer3D;