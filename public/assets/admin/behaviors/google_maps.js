a17cms.Behaviors.google_maps = function(container){
  'use strict';

  var map, places, infoWindow,
      markers = [],
      map_canvas = $('.map-canvas', container)[0],
      latlng = container.data('latlng');

  // Style to make the map gray
  var styles = [{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}];

  initialize();

  function initialize() {
    var latlng_split = latlng.split(',');
    var myOptions = {
      zoom: 13,
      center: new google.maps.LatLng(parseFloat(latlng_split[0]), parseFloat(latlng_split[1])),
      mapTypeControl: false,
      panControl: false,
      zoomControl: false,
      streetViewControl: false,
      styles: styles
    };
    map = new google.maps.Map(map_canvas, myOptions);

    // Add a marker at the center
    addMarker(new google.maps.LatLng(parseFloat(latlng_split[0]), parseFloat(latlng_split[1])));
  }

  function addMarker(location) {
    var marker = new google.maps.Marker({
      position: location,
      map: map,
      icon: new google.maps.MarkerImage('/images/marker.png', null, null, null, new google.maps.Size(30,30))
    });

    markers.push(marker);

    setLatLng(marker.position);
  }

};
