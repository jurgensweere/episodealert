(function(){
	angular.module('eaApp').controller('GuideCtrl',
        function($scope, $routeParams, seriesFactory) {

        	$scope.guide = [];
        	$scope.seriesDescription = '';

        	seriesFactory.getGuide()
                .success(function (guide) {
                    $scope.guide = guide;
                    if (guide.length > 0) {
                    	$scope.seriesDescription = guide[0].description;
                    }
                })
                .error(function (error) {
                    //$scope.status = 'error error error beep beep;
            });
        }
    );
})();