(function(){
    var app = angular.module('eaApp', ['ngRoute','ngAnimate']);
    app.config(['$routeProvider', '$locationProvider',
        function($routeProvider, $locationProvider) {
            $locationProvider.html5Mode(true);

            $routeProvider.when('/home', {
                templateUrl: 'templates/carousel.html',
                controller: 'CarouselCtrl'
            })

            .when('/series', {
                templateUrl: 'templates/series-list.html',
                controller: ''
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

            .when('/profile', {
                templateUrl: 'templates/profile.html',
                controller: 'ProfileCtrl'
            })            


            .otherwise({
                redirectTo: '/home'
            });
        }]
    );


    app.factory('FlashService', function($rootScope){
        return{
            show: function (message) {
                $rootScope.flash = message;
            },
            clear: function() {
                $rootScope.flash = '';
            }
        };

    });

    app.run(function($rootScope, $location, AuthenticationService, FlashService){        

        var routesThatRequireAuth = ['/search', '/profile'];

        $rootScope.$on('$routeChangeStart', function(event, next, current){

        //clear messages at scope change
        //FlashService.clear();

            for(var i = 0, max = routesThatRequireAuth.length ; i < max ; i++){
                if ( ($location.path() === routesThatRequireAuth[i]) && (!AuthenticationService.isLoggedIn() ) ) {
                    $location.path('/login');
                }
            }
        });

    });

    app.config(function($httpProvider){

        var logsOutUserOn401 = function($location, $q, SessionService, FlashService) { 
            var success = function(response) {
                return response;
            };
            var error = function(response) { 
                if(response.status === 401){ // HTTP NotAuthorized
                    SessionService.unset('authenticated');
                    FlashService.show(response.data.flash);
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

    });


    //Helper/filter to create image path from a series
    app.filter('createImageUrl', function(){
        return function(poster, unique_name){
            if(poster){
                return 'img/poster/' + unique_name.substring(0, 2) + '/' + poster;
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

    app.factory("AuthenticationService", function($location, $http, SessionService, FlashService) {

        var cacheSession = function(){
            SessionService.set('authenticated', true);
        };

        var uncacheSession = function(){
            SessionService.unset('authenticated');
        };

        var loginError = function(response) {
            FlashService.show(response.flash);
        };

        return {
            login: function(credentials) {
                var login = $http.post('api/auth/login', credentials);
                login.success(cacheSession);
                login.success(FlashService.clear);
                login.error(loginError);
                return login;

            },
            logout: function() {
                console.log('AuthenticationService -> logout');
                var logout =  $http.get('api/auth/logout');
                logout.success(uncacheSession);
                return logout;
            },
            isLoggedIn: function() {
                return SessionService.get('authenticated');
            }
      };
    });

    app.controller("LoginCtrl", function($scope, $location, AuthenticationService) {
        $scope.credentials = { username: "", password: "" };

        $scope.login = function() {
            AuthenticationService.login($scope.credentials).success(function(){
                $location.path('/home');
            });
        };

        $scope.logout = function() {
            AuthenticationService.logout($scope.credentials).success(function(){
                $location.path('/login');   
            });
        };

    });    

})();

