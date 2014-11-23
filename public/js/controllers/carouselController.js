(function(){

  angular.module('eaApp').controller('CarouselCtrl', ['$scope', '$http', '$interval',
      function($scope, $http, $interval) {
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

          $http.get('/api/series/top').success(function(data) {
              $scope.series = data;
              if (data[0] !== undefined) {
                  $scope.selectSeries(data[0].id);
              }
          });

          $scope.selectSeries = function(seriesId) {
              $scope.currentSeries = seriesId;

              for (var i = $scope.series.length - 1; i >= 0; i--) {
                  if ($scope.series[i].id == $scope.currentSeries) {
                      $scope.backgroundStyle = {'background-image': 'url(../img/fanart/' + $scope.series[i].fanart_image +')'};
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
      }]
  );

})();