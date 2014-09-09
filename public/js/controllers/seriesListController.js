(function(){

    angular.module('eaApp').controller('SeriesListCtrl',
        function($scope, $routeParams, seriesFactory) {
        	var genre = $routeParams.genre;
        	$scope.genre = toTitleCase(genre);
        	 getByGenre(genre);

          function getByGenre(genre) {
            seriesFactory.getByGenre(genre)
            .success(function (series) {            	        	
              $scope.series = series;
            })
            .error(function (error) {
              //$scope.status = 'error error error beep beep;
            });
          }

          function toTitleCase(str) {
		    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
		  }
        }
    );

})();