(function(){

    angular.module('eaApp').controller('SeriesCtrl',
        function($scope, $routeParams, seriesFactory) {

          var unique_name = $routeParams.seriesname;

          getSeries(unique_name);

          function getSeries(unique_name) {
            seriesFactory.getSeries(unique_name)
            .success(function (series) {
              $scope.series = series;

              //Gogo gadget episodes
              getEpisodes(series.id);
            })
            .error(function (error) {
              //$scope.status = 'error error error beep beep;
            });
          }

          function getEpisodes(id){
          	seriesFactory.getEpisodes(id)
          	.success(function (episodes){
          		$scope.episodes = episodes;
          	})
          	.error(function (error){
          		//stuff
          	});
          }

        }
    );

})();