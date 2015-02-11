(function(){
    angular.module('eaApp').controller('SeriesSearchCtrl', function($scope, $location, seriesFactory) {

        $scope.mainPageQuery = '';
        $scope.results = 0;

        //There is some debouncing (500ms delay to wait for the user to stop typing) in the HTML, this will start to work with angular 1.3 it seems
        // Start watching the search box for input
        $scope.$watch('mainPageQuery', function (newValue, oldValue)
        {
            if (newValue !== oldValue) {
                $location.path("/search");
                searchSeries(newValue);
            }
        });

        /**
         * Search for series and show results
         *
         * @param {string} query    Search query
         */
        function searchSeries(query) {
            seriesFactory.searchSeries(query)
                .success(function (series) {
                    if (series.length === 0 || series.length === undefined) {
                        // load the no-search result page
                        showNoResults();
                    } else {
                        $scope.results = series.length;
                        $scope.seriesSearchResults = series;
                    }
                })
                .error(function (error) {
                    //$scope.status = 'error error error beep beep;
                });
        }

        /**
         * Show a no results page
         */
        function showNoResults() {
            $scope.results = 0;
            seriesFactory.getTopSeries()
                .success(function (series) {
                    $scope.seriesSearchResults = series;
                })
                .error(function (error) {
                    //$scope.status = 'error error error beep beep;
                });
        }
    });
})();