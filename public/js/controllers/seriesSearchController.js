angular.module('eaApp').controller('SeriesSearchCtrl', function($scope, seriesFactory) {

  $scope.search = function(query){
    searchSeries($scope.query);
  }

  function searchSeries(query) {
    console.log('search series');
    seriesFactory.searchSeries(query)
      .success(function (series) {
        $scope.series = series;
      })
      .error(function (error) {
        //$scope.status = 'error error error beep beep;
      });
  }

  }
);