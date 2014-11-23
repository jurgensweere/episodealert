(function(){

    angular.module('eaApp').controller('SeenCtrl',
        function($scope, seriesFactory, flash) {

          $scope.toggleEpisode = function(episode, series){
            if(episode.seen){
              unseenServiceCall(episode);
            }else{
              seenServiceCall(episode, series);
            }            
          };

          function seenServiceCall(episode, series) {
            seriesFactory.setSeenEpisode(episode.id, episode.season, episode.episode, series.id)
            .success(function (response) {
              //flash(response.follow);
              
              episode.seen = 1;

            })

            .error(function (error) {
              flash(error.seen);
            });
          }

          function unseenServiceCall(episode) {
            seriesFactory.setUnseenEpisode(episode.id)
            .success(function (response) {
              //flash(response.follow);
              
              episode.seen = 0;

            })

            .error(function (error) {
              flash(response.seen);
            });
          }          

        }
    );

})();