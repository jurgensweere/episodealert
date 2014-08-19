(function(){

    angular.module('eaApp').controller('SeriesDetailCtrl', ['$scope', '$routeParams',
        function($scope, $routeParams) {
            $scope.param = $routeParams.seriesname;
        }]
    );

})();