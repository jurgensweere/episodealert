(function () {
    'use strict';

    angular
        .module('app.routes', ['ngRoute'])
        .config(config);

    function config($routeProvider, $locationProvider) {

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

            .when('/search', {
                templateUrl: 'templates/series-search.html',
                controller: 'SeriesSearchCtrl',
                reloadOnSearch: false
            })

            .when('/login', {
                templateUrl: 'templates/auth/login.html',
                controller: 'LoginCtrl'
            })

            .when('/register', {
                templateUrl: 'templates/auth/register.html',
                controller: 'RegisterCtrl'
            })

            .when('/passwordreset', {
                templateUrl: 'templates/auth/passwordreset.html'
            })

            .when('/password/reset/:token', {
                templateUrl: 'templates/auth/passwordresetconfirm.html',
                controller: 'PasswordResetCtrl'
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

            .when('/profile/calendar', {
                templateUrl: 'templates/calendar.html',
                controller: 'CalendarCtrl'
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
    }
})();