(function(){
    var app = angular.module('eaApp', ['ngAnimate']);

    app.directive("carousel", function() {
        return {
            restrict: 'E',
            templateUrl: 'carousel.html',
            controller: ['$scope', '$http', '$interval', function($scope, $http, $interval) {
                var carousel = this;
                carousel.series = [];
                carousel.currentSeries = 0;
                carousel.backgroundStyle = {};

                var timer = $interval(function() {
                    for (var i = carousel.series.length - 1; i >= 0; i--) {
                        if (carousel.series[i].id == carousel.currentSeries) {
                            // i is the current series, go to the next.
                            i++;
                            if (i == carousel.series.length) {
                                i = 0;
                            }
                            carousel.selectSeries(carousel.series[i].id);
                            break;
                        }
                    };
                }, 5000);

                $http.get('/api/series/top').success(function(data) {
                    carousel.series = data;
                    if (data[0] != undefined) {
                        carousel.selectSeries(data[0].id);
                    }
                });

                carousel.selectSeries = function(seriesId) {
                    carousel.currentSeries = seriesId;

                    for (var i = carousel.series.length - 1; i >= 0; i--) {
                        if (carousel.series[i].id == carousel.currentSeries) {
                            carousel.backgroundStyle = {'background-image': 'url(../img/fanart/' + carousel.series[i].fanart_image +')'};
                            break;
                        }
                    };
                }
                carousel.isSelected = function(seriesId) {
                    return seriesId == carousel.currentSeries;
                }

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
            }],
            controllerAs: 'carousel'
        };
    });
})();