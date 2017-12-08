a17cms.Behaviors.google_maps = function(container){
  'use strict';

  var map, places, infoWindow,
      map_canvas = $('.map-canvas', container)[0],
      center     = container.data('latlng-center'),
      zoom_level = container.data('zoom'),
      markers    = [];

  // Split string to create n markers (pls refactor)
  container.data('latlng').split('|').forEach(function(points) {
    var splitted = points.split(',');
    markers.push([splitted[0], splitted[1]]);
  });

  // Style to make the map gray
  var styles = [{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}];

  initialize();

  function initialize() {
    var latlng_split = center.split(',');
    var myOptions = {
      zoom: zoom_level,
      center: createPoint(latlng_split[0], latlng_split[1]),
      mapTypeControl: false,
      panControl: false,
      zoomControl: false,
      streetViewControl: false,
      styles: styles
    };
    map = new google.maps.Map(map_canvas, myOptions);

    // Add a marker at the center
    addMarker(createPoint(latlng_split[0], latlng_split[1]));

    // Add a marker at the designed places
    markers.forEach(function(marker) {
      addMarker(createPoint(marker[0], marker[1]), '/images/marker.png');
    });
  }

  function createPoint(lat, lng) {
    return new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
  }

  function addMarker(location, icon = null) {
    var options = {
      position: location,
      map: map,
    };

    if (icon) {
      options.icon =  new google.maps.MarkerImage(icon, null, null, null, new google.maps.Size(30,30));
    }

    var marker = new google.maps.Marker(options);
  }

};
