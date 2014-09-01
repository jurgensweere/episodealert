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
                controller: 'SeriesCtrl'
            }).when('/search/', {
                templateUrl: 'templates/series-search.html',
                controller: 'SeriesSearchCtrl'
            }).otherwise({
                redirectTo: '/home'
            });
        }]
    );

    //Helper/filter to create image path from a series
    app.filter('createImageUrl', function(){
        return function(poster, unique_name){
            if(poster){
                return 'img/poster/' + unique_name.substring(0, 2) + '/' + poster;
            }
        };
    });
})();

