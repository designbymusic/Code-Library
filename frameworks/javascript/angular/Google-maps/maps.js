function initMap(lat, longitude, zoom, marker_json) {

    var map = document.getElementById('map');

    if(document.contains(map)){
        initialize();
    }

    var lat = lat,
    map,
    longitude = longitude,
    zoom = zoom;
    locLatLong = new google.maps.LatLng(lat, longitude);

    function initialize() {
        var mapOptions = {
            mapTypeId: google.maps.MapTypeId.ROAD,
            ZoomControlOptions:{}
        }
        map = new google.maps.Map(document.getElementById("map"), mapOptions);
        addMarkers();
    }

    function addMarkers(){
        var bounds  = new google.maps.LatLngBounds();
        var latLong = new google.maps.LatLng(lat, longitude);
        var LatLngList = new Array();
        for (var key in marker_json) {
            var marker = marker_json[key];
            latLong = new google.maps.LatLng(marker.location_data.lat, marker.location_data.lon);
            var marker = new google.maps.Marker({
                map: map,
                position: latLong
            });
            bounds.extend(latLong);
        }
        map.fitBounds(bounds);
    }
}