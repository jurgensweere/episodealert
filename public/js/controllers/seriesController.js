(function(){

    angular.module('eaApp').controller('SeriesCtrl', ['$scope', '$routeParams',
        function($scope, $routeParams) {

          $scope.followSeries = function(){
            alert('follow me');
          };

        }]
    );

})();