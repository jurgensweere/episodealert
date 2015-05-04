(function() {
    angular.module('eaApp').controller('SeriesSearchCtrl', function($scope, $location, $stateParams, seriesFactory) {

        // Catch changing search terms and cancel changing the entire page
        $scope.$on('$locationChangeSuccess', function() {
            // Search parameter changed
            var params = $location.search();
            var query = params['query'];

            if (query != ""){
                doSearch(query);    
            }
            
        });

        // Extract search term from route parameters
        var query = $stateParams.query;

        // Put query back in text box if we're just loading the page now from a direct link
        // TODO: write a service that shares this and other site wide data
        if (!$scope.mainPageQuery) {
           $scope.mainPageQuery = query;
        }

        doSearch(query);

        function doSearch(query) {
            // Execute search
            searchFor(query).success(function(series) {
                $scope.results = series.length;
                $scope.searchResult = series;

                if (series.length === 0) {
                    showNoResults();
                }
            });
        }

        /**
         * Search for series.
         */
        function searchFor(query) {
            return seriesFactory.searchSeries(query);
        }

        /**
         * Show a no results page.
         */
        function showNoResults() {
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
