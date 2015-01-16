angular.module('eaApp').factory('seriesFactory', ['$http', function($http) {

    var urlBase = '/api/series/';
    var seriesFactory = {};

    /**
     * Get a series by unique name
     *
     * @param {string} uniqueName   Unique identifying series name
     * @return {Series}
     */
    seriesFactory.getSeries = function (uniqueName) {
        return $http.get(urlBase + uniqueName);
    };

    /**
     * Get random selection of Top Series 
     *
     * @return {array} List of series
     */
    seriesFactory.getTopSeries = function () {
        return $http.get(urlBase + 'top');
    };

    /**
     * Get series by search query
     *
     * @param {string} query    Search query
     * @return {array}          List of series
     */
    seriesFactory.searchSeries = function (query) {
        return $http.get(urlBase + 'search/' + query);
    };

    /**
     * Get series by genre
     *
     * @param {string} genre    Genre
     * @return {array}          List of series
     */
    seriesFactory.getByGenre = function (genre, skip) {
        skip = typeof skip !== 'undefined' ? skip : 0;
        return $http.get(urlBase + 'genre/' + genre + '/' + skip);
    };

    //TODO Add factory for following
    /**
     * Start following a series
     *
     * @param {int} series_id   ID of series to follow
     * @return {string}         Response message
     */
    seriesFactory.followSeries = function(series_id) {
        return $http.get('/api/follow/' + series_id);
    };

    /**
     * Stop following a series
     *
     * @param {int} series_id   ID of series to no longer follow
     * @return {string}         Response message
     */
    seriesFactory.unfollowSeries = function(series_id) {
        return $http.get('/api/unfollow/' + series_id);
    };    

    /**
     * Get a list of series followed by user
     *
     * @return {array}  List of series followed, including amount of (un)seen episodes
     */
    seriesFactory.getFollowingSeries = function() {
        return $http.get('/api/profile/following');
    };    

    /**
     * Get a list of episodes by series
     *
     * @param {int} series_id   ID of series to get episodes for
     * @return {array}          List of Episodes
     */
    seriesFactory.getEpisodes = function(series_id) {
    	return $http.get('/api/series/episodes/' + series_id);
    };

    /**
     * Get a list of episodes by series and season
     *
     * @param {int} series_id   ID of series to get episodes for
     * @param {int} season      season number to get episodes for
     * @return {array}          List of Episodes
     */
    seriesFactory.getEpisodesBySeason = function (series_id, season){
    	return $http.get('/api/series/episodesbyseason/' + series_id + '/' + season);
    };

    // seen
    /**
     * Mark an episode as seen
     *
     * @param {int} episode_id      ID of episode to mark as seen
     * @param {int} episode_season  Season number
     * @param {int} episode_number  Episode number
     * @param {int} series_id       ID of series this episode belongs to
     * @return {string}             Response message
     */
    seriesFactory.setSeenEpisode = function (episode_id, episode_season, episode_number, series_id){
        return $http.post('/api/series/seen', data = { 'episode_id' : episode_id,
         'episode_season' : episode_season, 
         'episode_number' : episode_number, 
         'series_id' : series_id });
    };

    /**
     * Mark an episode as unseen
     *
     * @param {int} episode_id  ID of episode to mark as unseen
     * @return {string}         Response message
     */
    seriesFactory.setUnseenEpisode = function (episode_id){
        return $http.post('/api/series/unseen', data = { 'episode_id' : episode_id });
    };

    /**
     * Get total amount of unseen episodes
     *
     * @return {int}                Amount of episodes not seen by user
     */
    seriesFactory.getUnseenAmount = function (){
        return $http.get(urlBase + 'unseenamount');
    };


    /**
     * Get amount of unseen episodes by series and season
     *
     * @param {int} series_id       ID of series
     * @param {int} season_number   Season number in series
     * @return {int}                Amount of episodes not seen by user
     */
    seriesFactory.getUnseenAmountBySeason = function (series_id, season_number){
        return $http.get(urlBase + 'unseenamountbyseason/' + series_id + '/' + season_number);
    };

    seriesFactory.getUnseenSeasonsBySeries = function (series_id, seasons_amount){
        return $http.get(urlBase + 'unseenamountbyseries/' + series_id + '/' + seasons_amount);
    };

    return seriesFactory;
}]);