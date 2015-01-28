(function(){
    angular.module('eaApp').controller('SeenCtrl',
        function($scope, seriesFactory, flash) {
            /** Toggle an episode (un)seen */
            $scope.toggleEpisode = function(episode) {
                if (episode.seen) {
                    unseenServiceCall(episode, 'single');
                } else {
                    seenServiceCall(episode, 'single');
                }            
            };

            /** Toggle a episodes (un)seen until here */
            $scope.toggleUntil = function (episode) {
                if (episode.seen) {
                    unseenServiceCall(episode, 'until');
                } else {
                    seenServiceCall(episode, 'until');
                }  
            };

            /** Toggle a season (un)seen */
            $scope.toggleSeason = function (episode) {
                if (episode.seen) {
                    unseenServiceCall(episode, 'season');
                } else {
                    seenServiceCall(episode, 'season');
                }  
            };

            /**
             * Set an episode to 'seen'
             *
             * @param episode
             * @param mode
             */
            function seenServiceCall(episode, mode) {
                seriesFactory.setSeenEpisode(episode.id, mode)
                    .success(function (response) {
                        // Mark episodes as seen from response
                        angular.forEach($scope.seasons[episode.season].content, function(episode, key) {
                            if (response.seen.indexOf(episode.id) > -1) {
                                episode.seen = 1;
                            }
                        });

                        //After the episode is succesfully set to seen, we should request an update on the unseen object
                        var loadUnseen = getUnseenAmountBySeries($scope.series.id, $scope.series.season_amount);
                        loadUnseen.success(function(unseen){
                            for( var i = 0; i < unseen.length; i++){
                                var index = i + 1; 
                                $scope.seasons[index].unseen = unseen[i];
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
            function unseenServiceCall(episode, mode) {
                seriesFactory.setUnseenEpisode(episode.id, mode)
                    .success(function (response) {
                        //flash(response.follow);
                        angular.forEach($scope.seasons[episode.season].content, function(episode, key) {
                            if (response.unseen.indexOf(episode.id) > -1) {
                                episode.seen = 0;
                            }
                        });

                        //After the episode is succesfully set to unseen, we should request an update on the unseen object
                        var loadUnseen = getUnseenAmountBySeries($scope.series.id, $scope.series.season_amount);
                        loadUnseen.success(function(unseen){
                            for( var i = 0; i < unseen.length; i++){
                                var index = i + 1; 
                                $scope.seasons[index].unseen = unseen[i];
                            }
                        });                         
                    })
                    .error(function (error) {
                        flash(response.unseen);
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
