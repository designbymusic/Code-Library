app.controller("mapController", function ($scope, $http) {
// Set up the default filters.

    $scope.filters = {};
    $scope.projects = [];

    $scope.location = null;
    $scope.loc = {
        lat: 51.5069986,
        lon: -0.1297437
    };

    $scope.gotoCurrentLocation = function () {
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var c = position.coords;
                $scope.gotoLocation(c.latitude, c.longitude);
            });
            return true;
        }
        return false;
    };
    $scope.gotoLocation = function (m) {

        if ($scope.lat != m.lat || $scope.lon != m.lon) {
            $scope.loc = { lat: m.lat, lon: m.lon };
            if (!$scope.$$phase) $scope.$apply("loc");
        }

        $scope.curr_item = m;
        var infowindow = new google.maps.InfoWindow({
            content: m.title
        });
    };
    $scope.setFilter = function (type, value) {
       // console.log(type, value);
       // console.log($scope.projects)
        $scope.filters = {
            type: type,
            filter: value
        };
        for(var project_key in $scope.projects){
            for(var key in $scope.projects[project_key]){
                if(key == type){
                    if($scope.projects[project_key][type] == value){
                        console.log('match')
                    }else{
                        var index = $scope.projects.indexOf(project_key);
                        $scope.projects.splice(index, 1);
                    }
                }
            }
        }
        console.log($scope.projects)
    }
    // geo-coding
    $scope.search = "";
    $scope.geoCode = function () {
        if ($scope.search && $scope.search.length > 0) {
            if (!this.geocoder) this.geocoder = new google.maps.Geocoder();
            this.geocoder.geocode({ 'address': $scope.projects }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var loc = results[0].geometry.location;
                    $scope.search = results[0].formatted_address;
                    $scope.gotoLocation(loc.lat(), loc.lng());
                } else {
                    alert("Sorry, this search produced no results.");
                }
            });
        }
    };
    $scope.init = function () {
        var projects = [];
        $http.jsonp('data.json?callback=JSON_CALLBACK').success(function (data) {
            angular.forEach(data, function (value, index) {
                projects[index] = [];
                angular.forEach(data[index], function (value2, index2) {
                    projects[index][index2] = value2;
                });
            });
            $scope.projects = projects
        }).error(function (error) {
        });
    };
});


// formats a number as a latitude (e.g. 40.46... => "40°27'44"N")
app.filter('lat', function () {
    return function (input, decimals) {
        if (!decimals) decimals = 0;
        input = input * 1;
        var ns = input > 0 ? "N" : "S";
        input = Math.abs(input);
        var deg = Math.floor(input);
        var min = Math.floor((input - deg) * 60);
        var sec = ((input - deg - min / 60) * 3600).toFixed(decimals);
        return deg + "°" + min + "'" + sec + '"' + ns;
    }
});

// formats a number as a longitude (e.g. -80.02... => "80°1'24"W")
app.filter('lon', function () {
    return function (input, decimals) {
        if (!decimals) decimals = 0;
        input = input * 1;
        var ew = input > 0 ? "E" : "W";
        input = Math.abs(input);
        var deg = Math.floor(input);
        var min = Math.floor((input - deg) * 60);
        var sec = ((input - deg - min / 60) * 3600).toFixed(decimals);
        return deg + "°" + min + "'" + sec + '"' + ew;
    }
});
