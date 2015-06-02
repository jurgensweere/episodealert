(function(){

    angular.module('eaApp').controller('SeriesListCtrl',
        function($scope, $stateParams, seriesFactory, Page, eaConstants) {

            Page.setTitle('Browse Series | Episode Alert');
            $scope.loadingGenre = false;
            $scope.series = [];
            var skip = 0;

            $scope.getGenreInLowerCase = function (selectedGenre) {
                return selectedGenre.toLowerCase();
            };

            $scope.highlightGenre = function(selectedGenre, genre) {
                return selectedGenre.toLowerCase() == genre.toLowerCase();
            };

            /**
             * Get all series by genre
             */
            $scope.getByGenre = function() {
                if ($scope.loadingGenre) return;
                $scope.loadingGenre = true;

                seriesFactory.getByGenre($scope.selectedGenre, skip)
                    .then(function (series) {
                        for (var i = 0; i < series.length - 1; i++) {
                            $scope.series.push(series[i]);

                        }
                        skip += series.length;
                        $scope.loadingGenre = false;
                    });
            };

            /** 
             * Get all available genres
             *
             * @return {array} List of genres
             */
            function getAllGenres() {
                return eaConstants.genres;
            }

            if($stateParams.genre) {
                var genre = $stateParams.genre;
                $scope.selectedGenre = genre;
                $scope.getByGenre();
            }

            $scope.allGenres = getAllGenres();
        }
    );

})();