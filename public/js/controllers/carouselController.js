(function(){

    angular.module('eaApp').controller('TrendingCtrl',
        function($scope, $http, $interval, $filter, seriesFactory, Page) {

            Page.setTitle('Episode Alert - Trending');

            $scope.series = [];
            $scope.currentSeries = 0;
            $scope.backgroundStyle = {};

            /** Select a different Series to highlight, every 5 seconds */
            var timer = $interval(function() {
                for (var i = $scope.series.length - 1; i >= 0; i--) {
                    if ($scope.series[i].id == $scope.currentSeries) {
                        // i is the current series, go to the next.
                        i++;
                        if (i == $scope.series.length) {
                            i = 0;
                        }
                        $scope.selectSeries($scope.series[i].id);
                        break;
                    }
                }
            }, 5000);

            /** Load the top series to show case */
            seriesFactory.getTopSeries()
                .success(function (series) {
                    $scope.series = series;
                    if (series[0] !== undefined) {
                        $scope.selectSeries(series[0].id);
                    }
                })
                .error(function (error) {
                    //$scope.status = 'error error error beep beep;
                });

            /**
             * Select a series to Show Case
             *
             * @param {int} seriesId  ID of the series
             */
            $scope.selectSeries = function(seriesId) {
                $scope.currentSeries = seriesId;
            };

            /**
             * Check if a series is currently selected
             *
             * @param {int} seriesId  ID of the series
             * @return {Boolean}
             */
            $scope.isSelected = function(seriesId) {
                return seriesId == $scope.currentSeries;
            };

            /**
             * Stop and Destroy timer
             */
            $scope.stopTimer = function() {
                if (angular.isDefined(timer)) {
                    $interval.cancel(timer);
                    timer = undefined;
                }
            };

            $scope.$on('$destroy', function() {
                // Make sure that the interval is destroyed too
                $scope.stopTimer();
            });

            function getAllGenres() {
                return new Array("Action", "Adventure", "Animation", "Comedy", "Children", "Crime", "Drama", "Documentary", "Fantasy", "Game Show" , "Horror", "News", "Reality", "Science-Fiction", "Soap", "Sport", "Talk Show", "Western");
            }

            $scope.allGenres = getAllGenres();

        }
    );
})();