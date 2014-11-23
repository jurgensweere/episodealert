(function(){

  angular.module('eaApp').controller('CarouselCtrl',
      function($scope, $http, $interval, $filter, seriesFactory) {
          $scope.series = [];
          $scope.currentSeries = 0;
          $scope.backgroundStyle = {};

          var timer = $interval(function() {
              for (var i = $scope.series.length - 1; i >= 0; i--) {
                  if ($scope.series[i].id == $scope.currentSeries) {
                      // i is the current series, go to the next.
                      i++;
                      if (i == $scope.series.length) {
                          i = 0;
                      }
                      $scope.selectSeries($scope.series[i].id);
                      break;
                  }
              }
          }, 5000);

          seriesFactory.getTopSeries()
            .success(function (series) {

              $scope.series = series;

              if (series[0] !== undefined) {
                  $scope.selectSeries(series[0].id);
              }
            })
            .error(function (error) {
              //$scope.status = 'error error error beep beep;
            });

          $scope.selectSeries = function(seriesId) {
              $scope.currentSeries = seriesId;

              for (var i = $scope.series.length - 1; i >= 0; i--) {
                  if ($scope.series[i].id == $scope.currentSeries) {

                      var fanArtUrl = $filter('createFanartUrl')($scope.series[i].poster_image, $scope.series[i].unique_name);
                      $scope.backgroundStyle = {'background-image': 'url(' + fanArtUrl +')'};
                      break;
                  }
              }
          };
          $scope.isSelected = function(seriesId) {
              return seriesId == $scope.currentSeries;
          };

          $scope.stopTimer = function() {
              if (angular.isDefined(timer)) {
                  $interval.cancel(timer);
                  timer = undefined;
              }
          };

          $scope.$on('$destroy', function() {
              // Make sure that the interval is destroyed too
              $scope.stopTimer();
          });
      }
  );

})();