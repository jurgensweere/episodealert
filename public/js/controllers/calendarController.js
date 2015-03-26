(function () {

    angular.module('eaApp').controller('CalendarCtrl',
        function ($scope, $http, $interval, $filter, seriesFactory, Page) {

            /*
             * Scope
             */

            $scope.dayOneName = 'Yesterday';
            $scope.dayTwoName = 'Today';
            $scope.dayThreeName = 'Tomorrow';

            $scope.yesterdayEpisodes = null;
            $scope.todayEpisodes = null;
            $scope.tomorrowEpisodes = null;

            $scope.clickPreviousDaysButton = function(){
                $scope.yesterdayEpisodes = null;
                $scope.todayEpisodes = null;
                $scope.tomorrowEpisodes = null;
                dayOffset = dayOffset - 3;
                setDays();
                loadDays();
            };

            $scope.clickNextDaysButton = function(){
                $scope.yesterdayEpisodes = null;
                $scope.todayEpisodes = null;
                $scope.tomorrowEpisodes = null;
                dayOffset = dayOffset + 3;
                setDays();
                loadDays();
            };

            $scope.init = function(){
                loadDays();
            };


            /*
             * Prototype that adds a possibility to add or subtract days from a date
             */

            Date.prototype.addDays = function (days) {
                var dat = new Date(this.valueOf());
                dat.setDate(dat.getDate() + days);
                return dat;
            };

            var dayOffset = 0;
            var referenceDate = new Date();
            var format = 'yyyy-MM-dd';
            var day1Date = $filter('date')(referenceDate.addDays(dayOffset), format);
            var day2Date = $filter('date')(referenceDate.addDays(-1 + dayOffset), format);
            var day3Date = $filter('date')(referenceDate.addDays(1 + dayOffset), format);


            /* set the dates that need to be collected */
            function setDays(){
                day1Date = $filter('date')(referenceDate.addDays(dayOffset), format);
                day2Date = $filter('date')(referenceDate.addDays(-1 + dayOffset), format);
                day3Date = $filter('date')(referenceDate.addDays(1 + dayOffset), format);

                if(dayOffset === 0){
                    $scope.dayOneName = 'Yesterday';
                    $scope.dayTwoName = 'Today';
                    $scope.dayThreeName = 'Tomorrow';
                }else{
                    if(dayOffset < 0){
                        $scope.dayOneName = String((dayOffset - 1)).replace('-', '') + ' days ago';
                        $scope.dayTwoName = String(dayOffset).replace('-', '') + ' days ago';
                        $scope.dayThreeName = String((dayOffset + 1)).replace('-', '') + ' days ago';
                    }else{
                        $scope.dayOneName = 'in ' + (dayOffset - 1) + ' days';
                        $scope.dayTwoName = 'in ' + dayOffset + ' days';
                        $scope.dayThreeName = 'in ' + (dayOffset + 1) + ' days';
                    }
                }

            }

            /* change reference date */
            function loadDays(){
                getTodayEpisodes();
                getTomorrowEpisodes();
                getYesterdayEpisodes();
            }

            /** Load the series that this user is following */
            function getTodayEpisodes() {
                seriesFactory.getEpisodesForUserByDate(day1Date)
                    .success(function (response) {
                        $scope.todayEpisodes = response;
                    })
                    .error(function (response) {
                        //flash(response.flash);
                    });
            }

            function getYesterdayEpisodes() {
                seriesFactory.getEpisodesForUserByDate(day2Date)
                    .success(function (response) {
                        $scope.yesterdayEpisodes = response;
                    })
                    .error(function (response) {
                        //flash(response.flash);
                    });
            }

            function getTomorrowEpisodes() {
                seriesFactory.getEpisodesForUserByDate(day3Date)
                    .success(function (response) {
                        $scope.tomorrowEpisodes = response;
                    })
                    .error(function (response) {
                        //flash(response.flash);
                    });
            }



        }
    );
})();