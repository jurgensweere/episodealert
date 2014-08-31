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

         for ( i = 0; i < series.length; i++){
          if(series[i].poster_image){
            series[i].posterurl = 'img/poster/' + series[i].unique_name.substring(0, 2) + '/' + series[i].poster_image;
          }else{
            series[i].posterurl = 'img/missing.png';
          }

         }

         $scope.series = series;
        })
        .error(function (error) {
          //$scope.status = 'error error error beep beep;
        });
    };
  }
);})();