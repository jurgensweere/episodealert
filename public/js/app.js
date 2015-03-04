/*jshint loopfunc: true */
(function () {
    var app = angular.module('eaApp', ['ngRoute', 'ngTouch', 'ngAnimate', 'ui.bootstrap', 'infinite-scroll']);

    // Configure All routing
    app.config(['$routeProvider', '$locationProvider',
                function ($routeProvider, $locationProvider) {

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

            .when('/profile/guide', {
                templateUrl: 'templates/guide.html',
                controller: 'GuideCtrl'
            })

            .when('/contact', {
                templateUrl: 'templates/contact.html',
                controller: 'ContactCtrl'
            })

            .when('/privacy', {
                templateUrl: 'templates/privacy.html'
            })

            .otherwise({
                redirectTo: '/trending'
            });
    }]);

    // We can add some stuff to the rootscope here
    app.run(function ($rootScope, $location, $window, AuthenticationService) {
        $rootScope.credentials = {};
        AuthenticationService.pageLoadInit();

        // Add routes that required auth from the front-end
        var routesThatRequireAuth = ['/profile', '/profile/settings'];

        // check if a user is logged in at the backend
        AuthenticationService.check();

        $rootScope.hello = function () {
            //console.log('hello');
            // you can use this in anywhere using $scope.hello();
        };

        

        $rootScope.$on('$routeChangeStart', function (event, next, current) {

            for (var i = 0, max = routesThatRequireAuth.length; i < max; i++) {
                if (($location.path() === routesThatRequireAuth[i]) && (!AuthenticationService.isLoggedIn())) {

                    $rootScope.$evalAsync(function () {
                        $location.path('/login');
                    });
                }
            }

        });

    });

    app.config(function ($provide, $httpProvider) {

        var logsOutUserOn401 = function ($location, $q, SessionService) {
            var success = function (response) {
                return response;
            };
            var error = function (response) {
                if (response.status === 401) { // HTTP NotAuthorized
                    SessionService.unset('authenticated');
                    $location.path('/login');
                    return $q.reject(response);
                } else {
                    return $q.reject(response);
                }
            };

            return function (promise) {
                return promise.then(success, error);
            };

        };

        $provide.factory("xhrResponseInterceptor", ['$q', function ($q) {
            return {
                'request': function (config) {
                    $('#spinner').show();
                    return config;
                },
                'requestError': function (rejection) {
                    $('#spinner').hide();
                    //if (canRecover(rejection)) {
                    //    return responseOrNewPromise;
                    //}
                    return $q.reject(rejection);
                },
                'response': function (response) {
                    $('#spinner').hide();
                    return response;
                },
                'responseError': function (rejection) {
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
    app.filter('createImageUrl', function () {
        return function (poster, unique_name, size) {
            if (poster) {
                if (size) {
                    var returnPoster = poster.split('.');
                    returnPoster = returnPoster[0] + '_' + size + '.jpg';
                    return 'img/poster/' + unique_name.substring(0, 2) + '/' + returnPoster;
                } else {
                    return 'img/poster/' + unique_name.substring(0, 2) + '/' + poster;
                }
            } else {
                return 'img/missing.png';
            }
        };
    });
    app.filter('createBannerUrl', function () {
        return function (banner, unique_name) {
            if (banner) {
                return 'img/banner/' + unique_name.substring(0, 2) + '/' + banner;
            } else {
                return 'img/missing-banner.png';
            }
        };
    });

    //Create fanart url
    app.filter('createFanartUrl', function () {
        return function (fanart, unique_name) {
            if (fanart !== undefined) {
                return 'img/fanart/' + unique_name.substring(0, 2) + '/' + fanart;
            }
            return 'img/fanart/nofanart.jpg';
        };
    });

    app.filter('greet', function (dateFilter) {
        return function (date, name) {
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

    /*
     * Action cache for pre login (will contain following actions for now)
     */
    app.factory('ActionCache', function () {

        var actions = [];

        return {
            addAction: function (newAction) {
                actions.push(newAction);
            },

            executeActions: function () {
                for (var i = actions.length - 1; i >= 0; i--) {
                    actions.shift().call();
                }
            },

            deleteActions: function () {
                actions = [];
            }
        };

    });

    app.factory('FollowingQueue', function (seriesFactory) {

        var actions = {};

        return {
            addFollowing: function (series_id) {
                actions.series_id = series_id;
                this.saveState();
            },

            executeActions: function () {
                this.restoreState();

                if(actions.series_id){

                    seriesFactory.followSeries(actions.series_id)
                        .success(function (response) {
                        });
                }

                actions = {};
                this.saveState();
            },

            saveState: function () {
                localStorage.followingItem = angular.toJson(actions);
            },

            restoreState: function () {
                //check if the userSettings is available in the users local storage
                if(localStorage.followingItem){
                    //collect the data and set it to local model
                    actions = angular.fromJson(localStorage.followingItem);
                }else{
                    //save the default values
                    actions = {};
                }
            }

        };
    });

    app.factory('SessionService', function () {
        return {
            get: function (key) {
                //HTML5 only
                return sessionStorage.getItem(key);
            },
            set: function (key, val) {
                return sessionStorage.setItem(key, val);
            },
            unset: function (key) {
                return sessionStorage.removeItem(key);
            }
        };
    });

    /*
     * Page factory supplies dynamic page title and meta information
     */

    app.factory('Page', function () {
        var title = 'Episode Alert';
        var metaDescription = 'The best source for show and episode info. Keeping you up to date on the latest broadcasts';
        var image = '';

        return {
            getTitle: function () {
                return title;
            },
            
            setTitle: function (newTitle) {
                title = newTitle;
            },

            getMetaDescription: function () {
                return metaDescription;
            },
            
            setMetaDescription: function (newDescription) {
                metaDescription = newDescription;
            },
            
            getImage : function () {
                return image;
            },
            
            setImage : function (newImage) {
                image = newImage;
            }
        };
    });


    app.controller("LoginCtrl", function ($route, $scope, $rootScope, $location, AuthenticationService) {

        $scope.credentials = {
            username: "",
            password: ""
        };

        $scope.login = function () {
            AuthenticationService.login($scope.credentials).success(function () {
                $location.path('/profile');
            });
        };

        $scope.logout = function () {
            AuthenticationService.logout($scope.credentials).success(function () {
                $location.path('/login');
            });
        };
    });

    app.controller('RegisterCtrl', function ($route, $scope, $location, AuthenticationService) {
        $scope.credentials = {
            username: "",
            password: "",
            email: ""
        };

        $scope.login = function () {
            AuthenticationService.register($scope.credentials).success(function () {
                $location.path('/login');
            });
        };

    });

    app.controller("HeaderCtrl", function ($scope, $location) {
        $scope.isActive = function (viewLocation) {
            return $location.path().indexOf(viewLocation) === 0;
        };
    });

})();