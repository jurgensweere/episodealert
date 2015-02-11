(function(){
    angular.module('eaApp').controller('SearchBoxCtrl', function($scope, $location, seriesFactory, searchService) {

        // There is some debouncing (500ms delay to wait for the user to stop typing) in the HTML, this will start to work with angular 1.3 it seems
        // Start watching the search box for input
        $scope.$watch('mainPageQuery', function (newValue, oldValue)
        {
            if (newValue !== oldValue) {

                /* for some reason $location.path() was not working */
                if(window.location.pathname !== "/search/"){ 
                    $location.path("/search");
                }

                search(newValue);
            }
        });


        search = function ( query ) {
            seriesFactory.searchSeries(query)
                .success(function (series) {
                    searchService.results = series;
                })
                .error(function (error) {
                //error = 'error error error beep beep;
            });
        }        

    });
})();