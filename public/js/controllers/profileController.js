(function(){
    angular.module('eaApp').controller('ProfileCtrl',  
        function($scope, seriesFactory , flash, userSettingService, Page) {

            Page.setTitle('Profile | Episode Alert');

            /** scope **/
            $scope.activePage = 'profile';
            $scope.archive = userSettingService.getProfileArchive();
            $scope.ended = userSettingService.getProfileEnded();
            $scope.seen = userSettingService.getProfileSeen(); // exclude seen?

            $scope.toggleArchive = function () {
                userSettingService.setProfileArchive(!$scope.archive);
                $scope.archive = !$scope.archive;
                getFollowingSeries();
            };

            $scope.toggleEnded = function () {
                userSettingService.setProfileEnded(!$scope.ended);
                $scope.ended = !$scope.ended;
                getFollowingSeries();
            };

            $scope.toggleUnseen = function () {
                userSettingService.setProfileSeen(!$scope.seen);                
                $scope.seen = !$scope.seen;
                getFollowingSeries();
            };
        

            /** init **/
            getFollowingSeries();
            getUnseenAmount();                
                
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