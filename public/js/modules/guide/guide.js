(function () {

    angular.module('eaApp.guide', ['eaApp.guide.episodes', 'eaApp.guide.calendar'])


    .controller('GuideCtrl',
        function($scope, $interval, seriesFactory, Page, userSettingService) {

            Page.setTitle('Guide | Episode Alert');

            $scope.guide = [];
            $scope.activePage = 'guide';

        }
    );

})();