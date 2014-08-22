(function(){
    var app = angular.module('eaApp', ['ngRoute','ngAnimate']);
    app.config(['$routeProvider', '$locationProvider',
        function($routeProvider, $locationProvider) {
            $locationProvider.html5Mode(true);
            $routeProvider.when('/home', {
                templateUrl: 'templates/carousel.html',
                controller: 'CarouselCtrl'
            }).when('/series', {
                templateUrl: 'templates/series-list.html',
                controller: 'SeriesListCtrl'
            }).when('/series/:seriesname', {
                templateUrl: 'templates/series-detail.html',
                controller: 'SeriesDetailCtrl'
            }).when('/search/', {
                templateUrl: 'templates/series-search.html',
                controller: 'SeriesSearchCtrl'
            }).otherwise({
                redirectTo: '/home'
            });
        }]
    );

})();

