(function(){
    angular.module('eaApp').controller('GuideCtrl',
        function($scope, $routeParams, $interval, seriesFactory, Page, userSettingService) {
            Page.setTitle('Guide | Episode Alert');

            $scope.guide = [];
            // $scope.series = {};
            $scope.activePage = 'guide';

//            $scope.unseen = userSettingService.getGuideIncludeUnseen();
//            $scope.upcoming = userSettingService.getGuideIncludeUpcoming();
//
//            $scope.toggleUnseen = function () {
//                userSettingService.setGuideIncludeUnseen(!$scope.unseen);
//                $scope.unseen = !$scope.unseen;
//                loadGuide();
//            };
//
//            $scope.toggleUpcoming = function () {
//                userSettingService.setGuideIncludeUpcoming(!$scope.upcoming);
//                $scope.upcoming = !$scope.upcoming;
//                loadGuide();
//            };

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

            loadGuide();
        }
    );
})();