(function(){
    angular.module('eaApp').controller('ProfileHeaderCtrl',
        function($scope, seriesFactory, userSettingService) {

            $scope.date = new Date();
            $scope.following = 0;
            $scope.unseen = 0;
            $scope.followingMoreThan = 0;

            getStats();

            /** Load the profile stats */
            function getStats() {
                userSettingService.getProfileStats()
                    .success(function (response) {
                        $scope.following = response.following;
                        $scope.unseen = response.unseen;
                        $scope.followingMoreThan = response.followmorethan;
                    })
                    .error(function (response) {
                        //flash(response.flash);
                    });
            }

        }
    );
})();
