(function(){

    angular.module('eaApp').controller('SeriesListCtrl',
        function($scope, $routeParams, seriesFactory) {
        	var genre = $routeParams.genre;
        	$scope.genre = genre;
        	 getByGenre(genre);

          function getByGenre(genre) {
            seriesFactory.getByGenre(genre)
            .success(function (series) {
            	console.log(series);            	
              $scope.series = series;
            })
            .error(function (error) {
              //$scope.status = 'error error error beep beep;
            });
          }
        }
    );

})();