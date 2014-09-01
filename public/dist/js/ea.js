(function(){
    var app = angular.module('eaApp', ['ngRoute','ngAnimate']);
    app.config(['$routeProvider', '$locationProvider',
        function($routeProvider, $locationProvider) {
            $locationProvider.html5Mode(true);
            $routeProvider.when('/home', {
                templateUrl: 'templates/carousel.html',
                controller: 'CarouselCtrl'
            }).when('/series', {
                templateUrl: 'templates/series-list.html',
                controller: 'SeriesListCtrl'
            }).when('/series/:seriesname', {
                templateUrl: 'templates/series-detail.html',
                controller: 'SeriesDetailCtrl'
            }).when('/search/', {
                templateUrl: 'templates/series-search.html',
                controller: 'SeriesSearchCtrl'
            }).otherwise({
                redirectTo: '/home'
            });
        }]
    );

})();

;(function(){

  angular.module('eaApp').controller('CarouselCtrl',
      function($scope, $http, $interval, seriesFactory) {
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
      }
  );

})();;(function(){

    angular.module('eaApp').controller('SeriesDetailCtrl', ['$scope', '$routeParams',
        function($scope, $routeParams) {
            $scope.param = $routeParams.seriesname;
        }]
    );

})();;(function(){

    angular.module('eaApp').controller('SeriesListCtrl', ['$scope',
        function($scope) {

        }]
    );

})();;angular.module('eaApp').controller('SeriesSearchCtrl', function($scope, seriesFactory) {

  $scope.search = function(query){
    searchSeries($scope.query);
  };

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