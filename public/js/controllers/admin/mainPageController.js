(function(){

	/*
	 * This controller is used for binding things that need to be available page wide
	 */

    angular.module('eaAdminApp').controller('MainPageCtrl',
        function($scope/*, Page, alertService*/) {
            //$scope.Page = Page;
        	//$scope.alerts = alertService.get();
        	$scope.context = '';
        }
    );
})();
