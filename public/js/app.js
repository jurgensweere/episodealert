/*jshint loopfunc: true */
(function(){
    var app = angular.module('eaApp', ['ngRoute', 'ngTouch', 'ngAnimate', 'flash', 'ui.bootstrap', 'infinite-scroll']);
        
    // Configure All routing
    app.config(['$routeProvider', '$locationProvider',
                function($routeProvider, $locationProvider) {

                    $locationProvider.html5Mode(true);

                    $routeProvider.when('/trending', {
                        templateUrl: 'templates/carousel.html',
                        controller: 'CarouselCtrl'
                    })

                    .when('/series', {
                        templateUrl: 'templates/series-list.html',
                        controller: 'SeriesListCtrl'
                    })

                    .when('/series/genre/:genre', {
                        templateUrl: 'templates/series-browse.html',
                        controller: 'SeriesListCtrl'
                    })

                    .when('/series/:seriesname', {
                        templateUrl: 'templates/series-detail.html',
                        controller: 'SeriesCtrl'
                    })

                    .when('/search/', {
                        templateUrl: 'templates/series-search.html',
                        controller: 'SeriesSearchCtrl'
                    })

                    .when('/login', {
                        templateUrl: 'templates/auth/login.html',
                        controller: 'LoginCtrl'
                    })

                    .when('/register', {
                        templateUrl: 'templates/auth/register.html',
                        controller: 'RegisterCtrl'
                    })            

                    .when('/profile', {
                        templateUrl: 'templates/profile.html',
                        controller: 'ProfileCtrl'
                    })

                    .when('/profile/settings', {
                        templateUrl: 'templates/profile/settings.html',
                        controller: 'ProfileSettingsCtrl'
                    })
                    
                    .when('/guide', {
                        templateUrl: 'templates/guide.html',
                        controller: 'GuideCtrl'
                    })          

                    .otherwise({
                        redirectTo: '/trending'
                    });
                }]
              );

    // We can add some stuff to the rootscope here
    app.run(function($rootScope, $location, AuthenticationService){

        // check if a user is logged in at the backend
        AuthenticationService.check();

        $rootScope.credentials = {};

        $rootScope.hello = function() {
            //console.log('hello');
            // you can use this in anywhere using $scope.hello();
        };      

        // Add routes that required auth from the front-end
        var routesThatRequireAuth = ['/profile', '/profile/settings'];

        $rootScope.$on('$routeChangeStart', function(event, next, current){

            for(var i = 0, max = routesThatRequireAuth.length ; i < max ; i++){
                if ( ($location.path() === routesThatRequireAuth[i]) && (!AuthenticationService.isLoggedIn() ) ) {
                    $rootScope.$evalAsync(function () { 
                        $location.path('/login');
                    });
                }
            }

        });

    });

    app.config(function($provide, $httpProvider){

        var logsOutUserOn401 = function($location, $q, SessionService) { 
            var success = function(response) {
                return response;
            };
            var error = function(response) { 
                if(response.status === 401){ // HTTP NotAuthorized
                    SessionService.unset('authenticated');
                    $location.path('/login');
                    return $q.reject(response);
                }else{
                    return $q.reject(response);
                }
            };

            return function(promise){
                return promise.then(success, error);
            };

        };

        $provide.factory("xhrResponseInterceptor", ['$q', function($q) {
            return {
                'request': function (config) {
                    $('#spinner').show();
                    return config;
                },
                'requestError': function(rejection) {
                    $('#spinner').hide();
                    //if (canRecover(rejection)) {
                    //    return responseOrNewPromise;
                    //}
                    return $q.reject(rejection);
                },
                'response': function(response) {
                    $('#spinner').hide();
                    return response;
                },
                'responseError': function(rejection) {
                    $('#spinner').hide();
                    //if (canRecover(rejection)) {
                    //    return responseOrNewPromise;
                    //}
                    return $q.reject(rejection);
                }
            };
        }]);

        $httpProvider.interceptors.push('xhrResponseInterceptor');

    });


    //Helper/filter to create image path from a series
    app.filter('createImageUrl', function(){
        return function(poster, unique_name, size){
            if(poster){
                if(size){
                    var returnPoster = poster.split('.');
                    returnPoster = returnPoster[0] + '_' + size + '.jpg';
                    return 'img/poster/' + unique_name.substring(0, 2) + '/' + returnPoster;
                }else{
                    return 'img/poster/' + unique_name.substring(0, 2) + '/' + poster;
                }
            }else{
                return 'img/missing.png';
            }
        };
    });
    app.filter('createBannerUrl', function(){
        return function(banner, unique_name){
            if(banner){
                return 'img/banner/' + unique_name.substring(0, 2) + '/' + banner;
            }else{
                return 'img/missing-banner.png';
            }
        };
    });

    //Create fanart url
    app.filter('createFanartUrl', function(){
        return function(fanart, unique_name){
            if(fanart !== undefined){
                return 'img/fanart/' + unique_name.substring(0, 2) + '/' + fanart;
            }
            return 'img/fanart/nofanart.jpg';
        };
    });
    
    app.filter('greet', function(dateFilter) {
        return function(date, name) {
            input = dateFilter(date, "H");
            if (input < 12) {
                return 'Good Morning, ' + name;
            } else if (input >= 12 && input <= 17) {
                return 'Good Afternoon, ' + name;
            } else if (input > 17 && input <= 24) {
                return 'Good Evening, ' + name;
            } else {
                return 'Hello, ' + name;
            }
        };
    });

    app.factory('SessionService', function() {
        return{
            get: function(key){
                //HTML5 only
                return sessionStorage.getItem(key);
            },
            set: function(key, val){
                return sessionStorage.setItem(key, val);
            },
            unset: function(key){
                return sessionStorage.removeItem(key);
            }
        };
    });

    app.factory('Page', function(){
      var title = 'Episode Alert';
      return {
        getTitle: function() { 
            return title; 
        },
        setTitle: function(newTitle) { 
            title = newTitle; 
        }
      };
    });


    app.controller("LoginCtrl", function($route, $scope, $location, AuthenticationService) {
        $scope.credentials = { username: "", password: "" };

        $scope.login = function() {
            AuthenticationService.login($scope.credentials).success(function(){
                $location.path('/profile');
            });
        };

        $scope.logout = function() {
            AuthenticationService.logout($scope.credentials).success(function(){
                $location.path('/login');   
            });
        };
    });  

    app.controller('RegisterCtrl', function($route, $scope, $location, AuthenticationService){
        $scope.credentials = { username: "", password:"", email: "" };

        $scope.login = function() {
            AuthenticationService.register($scope.credentials).success(function(){
                $location.path('/login');
            });
        };

    });

    app.controller("HeaderCtrl", function($scope, $location) {
        $scope.isActive = function (viewLocation) { 
            return $location.path().indexOf(viewLocation) === 0;
        };
    });

})();

