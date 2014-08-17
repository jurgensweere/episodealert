(function(){
    var app = angular.module('eaApp', []);

    app.directive("carousel", function() {
        return {
            restrict: 'E',
            templateUrl: 'carousel.html',
            controller: ['$http', function($http) {
                var carousel = this;
                carousel.series = [];
                carousel.currentSeries = 0;
                carousel.backgroundStyle = {};

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
                        }
                    };
                }
                carousel.isSelected = function(seriesId) {
                    return seriesId == carousel.currentSeries;
                }
            }],
            controllerAs: 'carousel'
        };
    });
})();