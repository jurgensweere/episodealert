(function(){
    angular.module('eaApp').controller('ProfileCtrl',  
        function($scope, seriesFactory ,flash) {
    	    getFollowingSeries();
            getUnseenAmount();

            $scope.date = new Date();
            $scope.archive = true;
            $scope.ended = true;
            $scope.seen = false; // exclude seen?

            $scope.toggleArchive = function () {
                $scope.archive = !$scope.archive;
                getFollowingSeries();
            };

            $scope.toggleEnded = function () {
                $scope.ended = !$scope.ended;
                getFollowingSeries();
            };

            $scope.toggleUnseen = function () {
                $scope.seen = !$scope.seen;
                getFollowingSeries();
            };
        
            /** Load the series that this user is following */
            function getFollowingSeries() {
                seriesFactory.getFollowingSeries($scope.seen, $scope.ended, $scope.archive)
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