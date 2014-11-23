 (function(){
    angular.module('eaApp').controller('ProfileCtrl',  
        function($scope, seriesFactory ,flash) {


    	  getFollowingSeries();

          function getFollowingSeries() {
            seriesFactory.getFollowingSeries()
            .success(function (response) {
              $scope.series = response;
            })
            .error(function (response) {
              flash(response.flash);
            });
          }        	

        }
    );

})();