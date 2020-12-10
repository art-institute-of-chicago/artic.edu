const viewerVirtualTour = function(container) {

  let xmlFile = container.dataset.vtourxml;
  let targetDiv = container.dataset.id;

  this.init = function() {
    embedpano(
      {
        xml: xmlFile,
        target: targetDiv,
        html5: 'only',
        mobilescale: 1.0,
        passQueryParameters: true,
        initvars: {imagepath:'https://artic-panos.s3.amazonaws.com/'}
      }
    );
  }
}

export default viewerVirtualTour;
