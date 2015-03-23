(function () {

    angular.module('eaApp').controller('CalendarCtrl',
        function ($scope, $http, $interval, $filter, seriesFactory, Page) {

            /*
             * Scope
             */

            $scope.yesterdayEpisodes;
            $scope.todayEpisodes;
            $scope.tomorrowEpisodes;

            /*
             * Prototype that adds a possibility to add or subtract days from a date
             */

            Date.prototype.addDays = function (days) {
                var dat = new Date(this.valueOf());
                dat.setDate(dat.getDate() + days);
                return dat;
            }

            var date = new Date();
            var format = 'yyyy-MM-dd';

            var todayDate = $filter('date')(date, format);
            var yesterdayDate = $filter('date')(date.addDays(-1), format);
            var tomorrowDate = $filter('date')(date.addDays(1), format);

            console.log(yesterdayDate);
            console.log(todayDate);
            console.log(tomorrowDate);


            /** Load the series that this user is following */
            function getTodayEpisodes() {
                seriesFactory.getEpisodesForUserByDate(todayDate)
                    .success(function (response) {
                        $scope.todayEpisodes = response;
                    })
                    .error(function (response) {
                        //flash(response.flash);
                    });
            }

            function getYesterdayEpisodes() {
                seriesFactory.getEpisodesForUserByDate(yesterdayDate)
                    .success(function (response) {
                        $scope.yesterdayEpisodes = response;
                    })
                    .error(function (response) {
                        //flash(response.flash);
                    });
            }

            function getTomorrowEpisodes() {
                seriesFactory.getEpisodesForUserByDate(tomorrowDate)
                    .success(function (response) {
                        $scope.tomorrowEpisodes = response;
                    })
                    .error(function (response) {
                        //flash(response.flash);
                    });
            }

            getTodayEpisodes();
            getTomorrowEpisodes();
            getYesterdayEpisodes();

        }
    );
})();