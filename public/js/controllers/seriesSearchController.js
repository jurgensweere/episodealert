(function(){
angular.module('eaApp').controller('SeriesSearchCtrl', function($scope, $location, seriesFactory) {

    $scope.mainPageQuery = '';

    //There is some debouncing (500ms delay to wait for the user to stop typing) in the HTML, this will start to work with angular 1.3 it seems
    $scope.$watch('mainPageQuery', function (newValue, oldValue)
    {
      if (newValue !== oldValue) {
        $location.path("/search");
        searchSeries(newValue);
      }

    });

    $scope.followSeries = function(){
      alert('follow me');
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
);})();