(function(){
    angular.module('eaApp').controller('ProfileCtrl',  
        function($scope, seriesFactory ,flash) {
    	    getFollowingSeries();
            getUnseenAmount();

            $scope.date = new Date();
        
            /** Load the series that this user is following */
            function getFollowingSeries() {
                seriesFactory.getFollowingSeries()
                    .success(function (response) {
                        $scope.series = response;
                    })
                    .error(function (response) {
                        flash(response.flash);
                    });
            }  
        
            /** Load the total unseen count */
            function getUnseenAmount() {
                seriesFactory.getUnseenAmount()
                    .success(function (response) {
                        $scope.unseenAmount = response.unseenepisodes;
                    })
                    .error(function (response) {
                        flash(response.flash);
                    });
            }
                
        }
    );
})();