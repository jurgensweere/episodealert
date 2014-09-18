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

    seriesFactory.getByGenre = function (genre) {
        return $http.get(urlBase + 'genre/' + genre);
    };

    //TODO Add factory for following
    seriesFactory.followSeries = function(user_id) {
        return $http.get('/api/follow/' + user_id);
    };

    seriesFactory.unfollowSeries = function(user_id) {
        return $http.get('/api/unfollow/' + user_id);
    };    

    seriesFactory.getFollowingSeries = function() {
        return $http.get('/api/profile/following');
    };    

    seriesFactory.getEpisodes = function(series_id) {
    	return $http.get('/api/series/episodes/' + series_id);
    };

    return seriesFactory;
}]);