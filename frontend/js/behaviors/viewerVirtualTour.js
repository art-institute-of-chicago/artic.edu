const viewerVirtualTour = function(container) {

  let xmlFile = container.dataset.vtourxml;
  let targetDiv = container.dataset.id;
  let vtourImages = container.dataset.vtourimages;

  this.init = function() {
    embedpano(
      {
        xml: xmlFile,
        target: targetDiv,
        html5: 'only',
        mobilescale: 1.0,
        passQueryParameters: true,
        initvars: {imagepath: vtourImages}
      }
    );
  }
}

export default viewerVirtualTour;
