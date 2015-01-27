(function(){
    angular.module('eaApp').controller('SeenCtrl',
        function($scope, seriesFactory, flash) {
            /** Toggle an episode (un)seen */
            $scope.toggleEpisode = function(episode, series) {
                if (episode.seen) {
                    unseenServiceCall(episode);
                } else {
                    seenServiceCall(episode, series);
                }            
            };

            /**
             * Set an episode to 'seen'
             *
             * @param episode
             * @param series
             */
            function seenServiceCall(episode, series) {
                seriesFactory.setSeenEpisode(episode.id, episode.season, episode.episode, series.id)
                    .success(function (response) {
                        //flash(response.follow);
                        episode.seen = 1;

                        //After the episode is succesfully set to seen, we should request an update on the unseen object
                        var loadUnseen = getUnseenAmountBySeries($scope.series.id, $scope.series.season_amount);
                        loadUnseen.success(function(unseen){
                            for( var i = 0; i < unseen.length; i++){
                                $scope.seasons[i].unseen = unseen[i];
                            }
                        }); 

                    })
                    .error(function (error) {
                        flash(error.seen);
                    });
            }      

            /**
             * Set an episode to 'unseen'
             *
             * @param episode
             * @param series
             */
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

            /**
             * Update unseenamount of the series
             * @param series_id
             * @param seasonsAmount
             */

            function getUnseenAmountBySeries(series_id, seasonsAmount){
                var unseenBySeries = seriesFactory.getUnseenSeasonsBySeries(series_id, seasonsAmount);
                return unseenBySeries;
            }    

        }
    );
})();
