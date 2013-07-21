//Add the requried module 'angular-ui' as a dependency
angular.module('maptesting', ['ui.map', 'ui.event']);

function MapCtrl($scope) {
    var latLong = {};
    var point   = {};
    var markers = {};
    var bounds  = new google.maps.LatLngBounds();

    $scope.mapMarkers = [
        {
            "id": "3",
            "title": "Sticky Project 1",
            "intro": "This is the project detail.  80 days around the...",
            "location_data": {
                "wkt": "POINT (-0.1846312 51.4159483)",
                "lat": "51.4159",
                "lon": "-0.184631"
            }
        },
        {
            "id": "4",
            "title": "BT River of Music [SAMPLE]",
            "intro": "The British Council curated a series of high...",
            "location_data": {
                "wkt": "POINT (-2.3417683 53.6020955)",
                "lat": "53.6021",
                "lon": "-2.34177"
            }
        }
    ];


    angular.forEach($scope.mapMarkers, function (marker, index) {
        var lat = marker.location_data.lat;
        var long = marker.location_data.long;
        point = new google.maps.LatLng(marker.location_data.lat, marker.location_data.lon);
        $scope.addMarker = function ($event) {
            $scope.myMarkers.push(new google.maps.Marker({
                map: $scope.myMap,
                position: point
            }));

        };
        $scope.setMarkerPosition = function (marker, lat, lng) {
            marker.setPosition(new google.maps.LatLng(lat, lng));
        };
    });

    //Markers should be added after map is loaded
    $scope.onMapIdle = function () {
        if ($scope.mapMarkers === undefined) {
            var marker = new google.maps.Marker({
                map: $scope.myMap,
                position: ll
            });
            $scope.mapMarkers = [marker, ];
        }else{
            //$scope.mapMarkers = markers;
        }
    };
    $scope.mapOptions = {
        center: new google.maps.LatLng(53.6021, -2.34177),
        zoom: 12,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    $scope.markerClicked = function (m) {
        window.alert("clicked");
    };

}