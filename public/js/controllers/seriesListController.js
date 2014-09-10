(function(){

    angular.module('eaApp').controller('SeriesListCtrl',
        function($scope, $routeParams, seriesFactory) {
        	if($routeParams.genre) {
        		var genre = $routeParams.genre;
	        	$scope.selectedGenre = genre;
	        	getByGenre(genre);         		
        	} 

        	$scope.allGenres = getAllGenres();
        	
        	$scope.getGenreInLowerCase = function (selectedGenre) {
        		return selectedGenre.toLowerCase();
        	};

        	$scope.highlightGenre = function(selectedGenre, genre) {
        		return selectedGenre.toLowerCase() == genre.toLowerCase();
        	}

          function getByGenre(genre) {
            seriesFactory.getByGenre(genre)
            .success(function (series) {            	        	
              $scope.series = series;
            })
            .error(function (error) {
              //$scope.status = 'error error error beep beep;
            });
          }

          function getAllGenres() {
		  	return new Array("Action", "Adventure", "Animation", "Comedy", "Children", "Crime", "Drama", "Documentary", "Fantasy", "Game Show" , "Horror", "News", "Reality", "Science-Fiction", "Soap", "Sport", "Talk Show", "Western");
		  }
        }
    );

})();