/*jshint loopfunc: true */
(function () {
    var app = angular.module('eaApp', ['ngRoute', 'ngTouch', 'ngAnimate', 'ui.bootstrap', 'infinite-scroll', 'app.routes']);


    // Init
    app.run(function ($rootScope, $location, $window, AuthenticationService, alertService) {
        $rootScope.credentials = {};
        AuthenticationService.pageLoadInit();

        // Add routes that required auth from the front-end
        var routesThatRequireAuth = ['/profile', '/profile/settings', '/profile/guide', '/profile/settings'];

        // check if a user is logged in at the backend
        AuthenticationService.check();

        $rootScope.$on('$routeChangeStart', function (event, next, current) {

            for (var i = 0, max = routesThatRequireAuth.length; i < max; i++) {
                if (($location.path() === routesThatRequireAuth[i]) && (!AuthenticationService.isLoggedIn())) {

                    $rootScope.$evalAsync(function () {
                        alertService.add('You need to login to go to ' + $location.path(), { type : 'warning', location : 'top', time: 10000 });
                        $location.path('/login');
                    });
                }
            }

        });

        $rootScope.$on('$routeChangeSuccess', function (event, next, current) {
            $window.ga('send', 'pageview', { page: $location.url() });
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

        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
        $httpProvider.interceptors.push('xhrResponseInterceptor');

    });

    app.filter('numberFixedLen', function () {
        return function (n, len) {
            var num = parseInt(n, 10);
            len = parseInt(len, 10);
            if (isNaN(num) || isNaN(len)) {
                return n;
            }
            num = ''+num;
            while (num.length < len) {
                num = '0'+num;
            }
            return num;
        };
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
            email: "",
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
            password: "",
            password_confirmation: "",
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
