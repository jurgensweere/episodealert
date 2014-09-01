angular.module('eaApp').factory('seriesFactory', ['$http', function($http) {

    var urlBase = '/api/series/';
    var seriesFactory = {};

    seriesFactory.getSeries = function (uniqueName) {
        return $http.get(urlBase + uniqueName);
    };

    seriesFactory.getTopSeries = function () {
        return $http.get(urlBase + 'top');
    };

    seriesFactory.searchSeries = function (query) {
        return $http.get(urlBase + 'search/' + query);
    };

    return seriesFactory;
}]);