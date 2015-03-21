(function(){
    angular.module('eaApp').controller('SearchBoxCtrl', function($scope, $location, seriesFactory) {

        $scope.$watch('mainPageQuery', function (newValue, oldValue)
        {
            if (newValue !== oldValue) {
                doSearch(newValue);
            }
        });

        $scope.clickSearchButton = function () {
            doSearch($scope.mainPageQuery);
        };

        function doSearch(query){
            if ($location.path() != '/search') {
                $location.path('/search');
            }

            $location.search('query', query);
        }

    });
})();
