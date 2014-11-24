(function(){
    angular.module('eaApp').controller('SeriesCtrl',
        function($scope, $routeParams, seriesFactory) {

            /* declaration */
            var unique_name = $routeParams.seriesname;

            /* Execute on load */
            var loadProfileSeries = getSeries(unique_name);

            loadProfileSeries.success(function(series){

                $scope.series = series;
                $scope.seasons = buildSeasonObject(series.season_amount, series.has_specials);

                // add unseen episodes to the tabs
                // var loadUnseen = getUnseenAmountBySeason(series.id, 8);
                // loadUnseen.success(function(unseen){
                //  console.log(unseen);
                // });

            });

            /* scope */
            $scope.loadSeason = function(series_id, seasonNumber) {
                var episodes = getEpisodesBySeason(series_id, seasonNumber);

                episodes.success(function(episodes) {
                    $scope.seasons[$scope.series.has_specials ? seasonNumber : seasonNumber - 1].content = episodes;
                });
            };

            $scope.loadUnseenForSeason = function(series_id, seasonNumber) {
                // why is this killing the login session?? ? ? ? ? too many requests??

                // var unseen = getUnseenAmountBySeason(series_id, seasonNumber);

                // //TODO: best would be to add/update the data to the season object
                // unseen.success(function(unseen){
                //  console.log(unseen);
                // });
            };

            
            /**
             * Get Series info
             *
             * @param {string} unique_name  Unique Identifying name for series
             * @return {Series}
             */
            function getSeries(unique_name) {
                var series = seriesFactory.getSeries(unique_name);
                return series;
            }

            /**
             * Get the number of unseen episodes for series in a season
             *
             * @param {int} series_id       ID of series
             * @param {int} seasonNumber    The season to look for
             * @return {int}
             */
            function getUnseenAmountBySeason(series_id, seasonNumber) {
                var unseenBySeries = seriesFactory.getUnseenAmountBySeason(series_id, seasonNumber);
                return unseenBySeries;
            }

            /**
             * Get the episodes for a series in a season
             *
             * @param {int} series_id       ID of series
             * @param {int} seasonNumber    The season to look for
             * @return {array}
             */
            function getEpisodesBySeason(series_id, seasonNumber) {
                var episodesBySeason = seriesFactory.getEpisodesBySeason(series_id, seasonNumber);

                return episodesBySeason;
            }

            /**
             * Get the episodes for a series
             *
             * @param {int} id ID of series
             * @return {array} List of Episodes
             */
            function getEpisodes(id) {
                seriesFactory.getEpisodes(id)
                    .success(function (episodes) {
                        $scope.episodes = episodes;
                    })
                    .error(function (error) {
                        //Beep beep error
                    }
                );
            }

            /* functions */
            function buildSeasonObject(numberOfSeasons, hasSpecials) {
        
                var seasons = [];

                if (hasSpecials) {
                    seasons.push({ number : 0, title : 'Specials', active : false });
                }

                for (var i = 1; i <= numberOfSeasons; i++) {
                    seasons.push( { number : i, title : i, active : false } );
                }

                seasons[seasons.length-1].active = true;

                return seasons;
            }
        }
    );
})();