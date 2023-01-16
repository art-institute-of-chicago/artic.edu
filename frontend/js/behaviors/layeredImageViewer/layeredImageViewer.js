import OpenSeadragon from '../../libs/openseadragon4.min';


const layeredImageViewer = function(container) {
  this.init = function() {
    console.log('init');
  };
  this.destroy = function() {
    console.log('destroy');
  };
};

export default layeredImageViewer;
