(function(){
    var app = angular.module('eaApp', ['ngRoute','ngAnimate']);

    app.config(['$routeProvider',
        function($routeProvider) {
            $routeProvider.when('/home', {
                templateUrl: 'templates/carousel.html',
                controller: 'CarouselCtrl'
            }).when('/series', {
                templateUrl: 'templates/series-list.html',
                controller: 'SeriesListCtrl'
            }).when('/series/:seriesname', {
                templateUrl: 'templates/series-detail.html',
                controller: 'SeriesDetailCtrl'
            }).otherwise({
                redirectTo: '/home'
            });
        }]
    );

})();