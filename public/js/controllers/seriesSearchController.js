(function(){
angular.module('eaApp').controller('SeriesSearchCtrl', function($scope, $location, seriesFactory) {

    $scope.mainPageSearch = function(){
      $location.path("/search");
      searchSeries(this.mainpageQuery);
    };

    $scope.search = function(){
      searchSeries(this.query);
    };

    function searchSeries(query) {
      seriesFactory.searchSeries(query)
        .success(function (series) {
          $scope.series = series;
        })
        .error(function (error) {
          //$scope.status = 'error error error beep beep;
        });
    }
  }
)})();