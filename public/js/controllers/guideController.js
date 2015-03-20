(function(){
    angular.module('eaApp').controller('GuideCtrl',
        function($scope, $routeParams, $interval, seriesFactory, Page, userSettingService) {
            Page.setTitle('Guide | Episode Alert');

            $scope.guide = [];
            // $scope.series = {};
            $scope.activePage = 'guide';

            $scope.unseen = userSettingService.getGuideIncludeUnseen();
            $scope.upcoming = userSettingService.getGuideIncludeUpcoming();

            $scope.toggleUnseen = function () {
                userSettingService.setGuideIncludeUnseen(!$scope.unseen);
                $scope.unseen = !$scope.unseen;
                loadGuide();
            };

            $scope.toggleUpcoming = function () {
                userSettingService.setGuideIncludeUpcoming(!$scope.upcoming);
                $scope.upcoming = !$scope.upcoming;
                loadGuide();
            };

            $scope.onSeen = function (episode, response) {
                loadGuide();
            };

            $scope.onUnseen = function (episode, response) {
                loadGuide();
            };

            var loadGuide = function () {
                seriesFactory.getGuide($scope.unseen, $scope.upcoming)
                    .success(function (guide) {
                        $scope.guide = guide;
                        // if (guide.length > 0) {
                        //     $scope.series = guide[0];
                        // }
                    })
                    .error(function (error) {
                        //$scope.status = 'error error error beep beep;
                });
            };

            /** Select a different Series to highlight, every 5 seconds */
            // var timer = $interval(function() {
            //     for (var i = $scope.guide.length - 1; i >= 0; i--) {
            //         if ($scope.guide[i].id == $scope.series.id) {
            //             // i is the current series, go to the next.
            //             i++;
            //             if (i == $scope.guide.length) {
            //                 i = 0;
            //             }
            //             $scope.series = $scope.guide[i];
            //             break;
            //         }
            //     }
            // }, 5000);

            /**
             * Stop and Destroy timer
             */
            // $scope.stopTimer = function() {
            //     if (angular.isDefined(timer)) {
            //         $interval.cancel(timer);
            //         timer = undefined;
            //     }
            // };

            // $scope.$on('$destroy', function() {
            //     // Make sure that the interval is destroyed too
            //     $scope.stopTimer();
            // });

            loadGuide();
        }
    );
})();