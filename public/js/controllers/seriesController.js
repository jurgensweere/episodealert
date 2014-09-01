(function(){

    angular.module('eaApp').controller('SeriesCtrl',
        function($scope, $routeParams, seriesFactory) {

          var unique_name = $routeParams.seriesname;

          getSeries(unique_name);

          function getSeries(unique_name) {
            seriesFactory.getSeries(unique_name)
            .success(function (series) {
              $scope.series = series;
            })
            .error(function (error) {
              //$scope.status = 'error error error beep beep;
            });
          }

        }
    );

})();