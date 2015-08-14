(function(){
    angular.module('eaApp').controller('GuideCtrl',
        function($scope, $interval, seriesFactory, Page, userSettingService) {
            Page.setTitle('Guide | Episode Alert');

            $scope.guide = [];
            $scope.activePage = 'guide';

        }
    );
})();