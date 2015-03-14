(function(){

    angular.module('eaApp').controller('SeriesListCtrl',
        function($scope, $routeParams, seriesFactory, Page) {

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
                    .success(function (series) {
                        for (var i = 0; i < series.length - 1; i++) {
                            $scope.series.push(series[i]);
                        }
                        skip += series.length;
                        $scope.loadingGenre = false;
                    })
                    .error(function (error) {
                        //$scope.status = 'error error error beep beep;
                        $scope.loadingGenre = false;
                });
            };

            /**
             * Get all available genres
             *
             * @return {array} List of genres
             */
            function getAllGenres() {
                return new Array("Action", "Adventure", "Animation", "Comedy", "Children", "Crime", "Drama", "Documentary", "Fantasy", "Game Show" , "Horror", "News", "Reality", "Science-Fiction", "Soap", "Sport", "Talk Show", "Western");
            }

            if($routeParams.genre) {
                var genre = $routeParams.genre;
                $scope.selectedGenre = genre;
                $scope.getByGenre();
            }

            $scope.allGenres = getAllGenres();
        }
    );

})();