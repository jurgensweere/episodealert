(function(){
    angular.module('eaApp').controller('SearchBoxCtrl', function($scope, $location, seriesFactory) {

        // There is some debouncing (500ms delay to wait for the user to stop typing) in the HTML, this will start to work with angular 1.3 it seems
        // Start watching the search box for input
        $scope.$watch('mainPageQuery', function (newValue, oldValue)
        {
            if (newValue !== oldValue) {

                $location.path("/search/" + newValue);

            }
        });

    });
})();
