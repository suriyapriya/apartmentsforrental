/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

angular.module('project', ['ngRoute', 'google-maps', 'ngSanitize', 'ui.bootstrap'])

.config(function($routeProvider) {
  console.log("config");
  $routeProvider
    .when('/', {
      controller:'ListApts',
      templateUrl:'showMainPage.html'
    })
    .when('/about', {
      controller:'aboutCtrl',
      templateUrl:'showAbout.html'
    })
    .when('/signin', {
      controller:'signInCtrl',
      templateUrl:'showSignIn.html'
    })
    .when('/subscribe', {
      controller:'subscribeCtrl',
      templateUrl:'showSubscribe.html'
    })
    .when('/map/:projectID', {
      controller:'map',
      templateUrl:'showMap.html'
    })
    .when('/amenities/:projectID', {
      controller:'amenities',
      templateUrl:'showAmenities.html'
    })
    .when('/images/:projectID', {
      controller:'images',
      templateUrl:'showImages.html'
    })
    .when('/search', {
      controller:'SearchCtrl',
      templateUrl:'searchPage.html'
    })
    .when('/search', {
      controller:'SearchCtrl',
      templateUrl:'searchPage.html'
    })
    .when('/city/:city', {
      controller:'SearchCityCtrl',
      templateUrl:'showMainPage.html'
    })
    .otherwise({
      redirectTo:'/'
    });
})
.controller('ListApts', function($scope, $http) {
    //console.log("listing");
    $http.post("../model/getApartment.php").success(function(data){
            console.log("inserted Successfully");
    $scope.aptobj = data;
});
})

.controller('aboutCtrl', function() {
    //console.log("listing");
})

.controller('signInCtrl', function() {
    //console.log("listing");
})

.controller('subscribeCtrl', function() {
    //console.log("listing");
})

.controller('map', function($scope, $http, $routeParams) {
    var id = $routeParams.projectID;
    //console.log("map");
            $scope.map = {
        center: {
            latitude: 0,
            longitude: 0,
        },
        markers : [],
        zoom: 8
    };
    $http.post("../model/getApartment.php", {'id' : id}).success(function(data){
        console.log("inserted Successfully");
        $scope.aptobj = data;
        $scope.map.center.latitude = $scope.aptobj.latitude;
        $scope.map.center.longitude = $scope.aptobj.longitude;
        $scope.map.markers.push({
            latitude : $scope.map.center.latitude,
            longitude : $scope.map.center.longitude
        });
        console.log($scope.aptobj);
    });
})

.controller('amenities', function($scope, $http, $routeParams) {
    var id = $routeParams.projectID;
    console.log("amenities");
    $http.post("../model/getApartment.php", {'id' : id}).success(function(data){
            console.log("inserted Successfully");            
    $scope.aptobj = data;
    $scope.amenities = $scope.aptobj.amenities;
});
})
   
.controller('images', function($scope, $http, $routeParams) {
 var id = $routeParams.projectID;
//console.log("images");

 $http.post("../model/getApartment.php", {'id' : id}).success(function(data){
         console.log("inserted Successfully");
 $scope.aptobj = data;
 $scope.images = $scope.aptobj.images;
 //console.log($scope.images);
});
})

.controller('SearchCtrl', function($scope, $http, $location) {
    //console.log("Searching");
    $scope.word = "";
    $scope.minprice = 0;
    $scope.maxprice = 3000;
    $scope.bedrooms = [1, 2, 3, 4];
    $scope.bedroom = 1;
    $scope.search = function() {
        $http.post("../model/getApartment.php", {'word' : $scope.word, 'br' : $scope.bedroom, 'minprice' : $scope.minprice, 'maxprice' : $scope.maxprice})
                .success(function(data){
            console.log("search inserted Successfully");
            $scope.aptobj = data;
        });
    }    
})

.controller('SearchCityCtrl', function($scope, $routeParams, $http) {
    var city = $routeParams.city;
    //console.log("listing");
    $http.post("../model/getApartment.php", {'word' : city, 'br':0, 'minprice' : 0, 'maxprice' : 100000}).success(function(data){
            console.log("inserted Successfully");
    $scope.aptobj = data;
});
});