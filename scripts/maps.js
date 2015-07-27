
//################### GoogleMap ###################
var googleMaps = {
  maps: {},
  init: function() {
    var mapElements = document.getElementsByClassName('map');
    for(var i = 0; i < mapElements.length; i ++){
      var mapCanvas = mapElements[i];
      var mapId = mapCanvas.id;
      var lat = parseFloat(mapCanvas.dataset.locationX);
      var lng = parseFloat(mapCanvas.dataset.locationY);
      var zoom = parseInt(mapCanvas.dataset.zoom, 10);

      var latLng = new google.maps.LatLng(lat,lng)
      var mapOptions = {
        center: latLng,
        zoom: zoom,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      googleMaps.maps[mapId] = {};
      googleMaps.maps[mapId].map = new google.maps.Map(mapCanvas, mapOptions);
      googleMaps.maps[mapId].marker = new google.maps.Marker({
        position: latLng,
        map: googleMaps.maps[mapId].map,
        title: mapId
      });

    }
  },
  getMap: function(id) {
    return googleMaps.maps[id];
  }
}

if(typeof google === 'object' && typeof google.maps === 'object') { //executes the following code if google maps has loaded
  googleMaps.init();
}
