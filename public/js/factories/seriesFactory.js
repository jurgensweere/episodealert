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

    seriesFactory.getEpisodesBySeason = function (series_id, season){
    	return $http.get('/api/series/episodesbyseason/' + series_id + '/' + season);
    };

    // seen
    seriesFactory.setSeenEpisode = function (episode_id, episode_season, episode_number, series_id){
        return $http.post('/api/series/seen', data = { 'episode_id' : episode_id,
         'episode_season' : episode_season, 
         'episode_number' : episode_number, 
         'series_id' : series_id });
    };

    seriesFactory.setUnseenEpisode = function (episode_id){
        return $http.post('/api/series/unseen', data = { 'episode_id' : episode_id });
    };

    seriesFactory.getUnseenAmountBySeason = function (series_id, season_number){
        return $http.get(urlBase + 'unseenamountbyseason/' + series_id + '/' + season_number);
    };

    return seriesFactory;
}]);