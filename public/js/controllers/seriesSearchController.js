(function() {
    angular.module('eaApp').controller('SeriesSearchCtrl', function($scope, $rootScope, $routeParams, seriesFactory) {

        // Extract search term from route parameters
        var query = $routeParams.searchquery;

        // Put query back in text box if we're just loading the page now from a direct link?
        if (!$rootScope.mainPageQuery) {
            $rootScope.mainPageQuery = query;
        }

        // Execute search
        searchFor(query).success(function(series) {
            $scope.results = series.length;
            $scope.searchResult = series;

            if (series.length === 0) {
                showNoResults();
            }
        });

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
