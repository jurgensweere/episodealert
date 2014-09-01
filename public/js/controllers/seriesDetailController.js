(function(){
    //todo: not used at the moment
    angular.module('eaApp').controller('SeriesDetailCtrl', ['$scope', '$routeParams',
        function($scope, $routeParams) {
            $scope.param = $routeParams.seriesname;
        }]
    );

})();