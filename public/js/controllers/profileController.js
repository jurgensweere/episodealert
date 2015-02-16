(function () {
    angular.module('eaApp').controller('ProfileCtrl',
        function ($scope, seriesFactory, flash, userSettingService, Page) {

            Page.setTitle('Profile | Episode Alert');
            var series = [];

            /** scope **/
            $scope.activePage = 'profile';
            $scope.archive = userSettingService.getProfileArchive();
            $scope.ended = userSettingService.getProfileEnded();
            $scope.seen = userSettingService.getProfileSeen(); // exclude seen?

            $scope.toggleArchive = function () {
                userSettingService.setProfileArchive(!$scope.archive);
                $scope.archive = !$scope.archive;
                filterSeries();
            };

            $scope.toggleEnded = function () {
                userSettingService.setProfileEnded(!$scope.ended);
                $scope.ended = !$scope.ended;
                filterSeries();
            };

            $scope.toggleUnseen = function () {
                userSettingService.setProfileSeen(!$scope.seen);
                $scope.seen = !$scope.seen;
                filterSeries();
            };


            /* filter out the series */
            function filterSeries() {
                $scope.profileSeries = series.slice();

                if ($scope.seen || !$scope.ended || !$scope.archive) {

                    for (var i = $scope.profileSeries.length - 1; i >= 0; i--) {

                        //check and remove series that don't have unseen episodes
                        if ($scope.seen) {
                            if ($scope.profileSeries[i].unseen_episodes === 0) {
                                $scope.profileSeries.splice(i, 1);
                            }
                        }

                        //check and remove series that are ended
                        if (!$scope.ended) {
                            if ($scope.profileSeries[i].status === "Ended") {
                                $scope.profileSeries.splice(i, 1);
                            }
                        }

                        //check and remove series that are archived
                        if (!$scope.archive) {
                            if ($scope.profileSeries[i].archive) {
                                $scope.profileSeries.splice(i, 1);
                            }
                        }
                    }
                }
            }

            /** init **/
            getFollowingSeries();
            getUnseenAmount();

            /** Load the series that this user is following */
            function getFollowingSeries() {
                seriesFactory.getFollowingSeries(false, true, true)
                    .success(function (response) {
                        $scope.profileSeries = response;
                        series = response;
                        filterSeries();
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