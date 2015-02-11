(function(){
    angular.module('eaApp').controller('SeriesSearchCtrl', function($scope, $location, seriesFactory, searchService) {

        $scope.mainPageQuery = '';

        /* 
         * watch the service
         */ 
        $scope.$watch(function() {
             return searchService.results;
            },
            function(newResult, oldResult) {
                if(newResult !== oldResult) {
                    if(newResult.length === 0){
                        showNoResults();
                    }
                    $scope.searchResult = newResult;
                }
            }
        );

        /**
         * Show a no results page
         */
        function showNoResults() {
            $scope.results = 0;
            seriesFactory.getTopSeries()
                .success(function (series) {
                    $scope.searchResult = series;
                })
                .error(function (error) {
                    //$scope.status = 'error error error beep beep;
                });
        }
    });
})();