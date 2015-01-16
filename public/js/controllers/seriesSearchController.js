(function(){
    angular.module('eaApp').controller('SeriesSearchCtrl', function($scope, $location, seriesFactory) {

        $scope.mainPageQuery = '';

        //There is some debouncing (500ms delay to wait for the user to stop typing) in the HTML, this will start to work with angular 1.3 it seems
        // Start watching the search box for input
        $scope.$watch('mainPageQuery', function (newValue, oldValue)
        {
            if (newValue !== oldValue) {
                $location.path("/search");
                searchSeries(newValue);
            }
        });

        $scope.followSeries = function() {
            // TODO: Implement
            alert('follow me');
        };

        /**
         * Search for series and show results
         *
         * @param {string} query    Search query
         */
        function searchSeries(query) {
            seriesFactory.searchSeries(query)
                .success(function (series) {
                    $scope.seriesSearchResults = series;
                })
                .error(function (error) {
                    //$scope.status = 'error error error beep beep;
                });
            }
        }
    );
})();