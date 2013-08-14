mapApp.service('mapService', function () {
    var map;
    this.setMap = function (myMap) {
        map = myMap;
    };
    this.getMap = function () {
        if (map) return map;
        throw new Error("Map not defined");
    };
    this.getLatLng = function () {
        var center = map.getCenter();
        return {
            lat: center.lat(),
            lng: center.lng()
        };
    };
});

mapApp.service('todosService', function ($filter) {
    // nextId and list both have mock starting data
    this.nextId = 4;
    this.items = [
        {
            id: 1,
            completed: false,
            title: 'Play Tennis',
            desc: '',
            lat: 43.09278984218124,
            lng: -89.36774236078266
        },
        {
            id: 2,
            completed: true,
            title: 'Buy Groceries',
            desc: 'Steak, Pasta, Spinach',
            lat: 43.06487353914984,
            lng: -89.41749499107603
        },
        {
            id: 3,
            completed: false,
            title: 'Picnic Time',
            desc: 'Hang out with friends',
            lat: 43.0869882068853,
            lng: -89.42141638065578
        }
    ];
    this.filter = {};
    this.filtered = function () {
        return $filter('filter')(this.items, this.filter);
    };
    this.remainingCount = function () {
        return $filter('filter')(this.items, {completed: false}).length;
    };
    this.getTodoById = function (todoId) {
        var todo, i;
        for (i = this.items.length - 1; i >= 0; i--) {
            todo = this.items[i];
            if (todo.id === todoId) {
                return todo;
            }
        }
        return false;
    };
    this.addTodo = function (title, desc, lat, lng) {
        var newTodo = {
            id: this.nextId++,
            completed: false,
            title: title,
            desc: desc,
            lat: lat,
            lng: lng
        };
        this.items.push(newTodo);
    };
    this.updateTodo = function (todoId, title, desc, lat, lng, comp) {
        var todo = this.getTodoById(todoId);
        if (todo) {
            todo.title = title;
            todo.desc = desc;
            todo.lat = lat;
            todo.lng = lng;
            todo.completed = comp;
            todo.id = this.nextId++;
        }
    };
    this.prune = function () {
        var flag = false, i;
        for (var i = this.items.length - 1; i >= 0; i--) {
            if (this.items[i].completed) {
                flag = true;
                this.items.splice(i, 1);
            }
        }
        if (flag) this.nextId++;
    };
});

mapApp.service('markersService', function () {
    this.markers = [];

    this.getMapData = function(){
        $http.jsonp('http://api.trakt.tv/calendar/premieres.json/' + $scope.apiKey + '/' + apiDate + '/' + 30 + '/?callback=JSON_CALLBACK').success(function (data) {
            angular.forEach(data, function (value, index) {
                //The API stores the full date separately from each episode. Save it so we can use it later
                var date = value.date;
                angular.forEach(value.episodes, function (tvshow, index) {
                    //Create a date string from the timestamp so we can filter on it based on user text input
                    tvshow.date = date; //Attach the full date to each episode
                    $scope.results.push(tvshow);
                    //Loop through each genre for this episode
                    angular.forEach(tvshow.show.genres, function (genre, index) {
                        //Only add to the availableGenres array if it doesn't already exist
                        var exists = false;
                        angular.forEach($scope.availableGenres, function (avGenre, index) {
                            if (avGenre == genre) {
                                exists = true;
                            }
                        });
                        if (exists === false) {
                            $scope.availableGenres.push(genre);
                        }
                    });
                });
            });
        }).error(function (error) {
            });
    }


    this.getMarkerByTodoId = function (todoId) {
        var marker, i;
        for (i = this.markers.length - 1; i >= 0; i--) {
            marker = this.markers[i];
            if (marker.get("id") === todoId) {
                return marker;
            }
        }
        return false;
    };
});

mapApp.service('infoWindowService', function (mapService) {
    var infoWindow;
    this.data = {};
    this.registerInfoWindow = function (myInfoWindow) {
        infowindow = myInfoWindow;
    };
    this.setData = function (todoId, todoTitle, todoDesc) {
        this.data.id = todoId;
        this.data.title = todoTitle;
        this.data.desc = todoDesc;
    };
    this.open = function (marker) {
        infowindow.open(mapService.getMap(), marker);
    };
    this.close = function () {
        if (infowindow) {
            infowindow.close();
            this.data = {};
        }
    };
});

mapApp.service('mapControlsService', function (infoWindowService, markersService, NEW_TODO_ID) {
    this.editTodo = false;
    this.editTodoId = NEW_TODO_ID;
    this.newTodo = function () {
        this.editTodoById();
    };
    this.editTodoById = function (todoId) {
        this.editTodoId = todoId || NEW_TODO_ID;
        this.editTodo = true;
    };
    this.openInfoWindowByTodoId = function (todoId) {
        var marker = markersService.getMarkerByTodoId(todoId);
        if (marker) {
            infoWindowService.setData(todoId, marker.getTitle(), marker.get("desc"));
            infoWindowService.open(marker);
            return;
        }
    };
});