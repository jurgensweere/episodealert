(function () {

    angular.module('eaApp.guide.calendar', [])

    .directive('calendarCarousel', [function () {
        return {
            scope: {},
            controller: calendarController,
            controllerAs: 'calendar',
            templateUrl: '/js/modules/guide/calendar/guide.calendar.tpl.html',
        };
    }]);

    function calendarController($filter, seriesFactory) {
        var calendar = this;

        /*
         * Prototype that adds a possibility to add or subtract days from a date
         */

        Date.prototype.addDays = function (days) {
            var dat = new Date(this.valueOf());
            dat.setDate(dat.getDate() + days);
            return dat;
        };

        calendar.dayOffset = 0;
        var referenceDate = new Date();        
        var format = 'yyyy-MM-dd';
        var day1Date = $filter('date')(referenceDate.addDays(calendar.dayOffset), format);
        var day2Date = $filter('date')(referenceDate.addDays(-1 + calendar.dayOffset), format);
        var day3Date = $filter('date')(referenceDate.addDays(1 + calendar.dayOffset), format);

        calendar.dayOneName = 'Yesterday';
        calendar.dayTwoName = 'Today';
        calendar.dayThreeName = 'Tomorrow';

        calendar.yesterdayEpisodes = null;
        calendar.todayEpisodes = null;
        calendar.tomorrowEpisodes = null;

        calendar.clickPreviousDaysButton = function () {
            calendar.yesterdayEpisodes = null;
            calendar.todayEpisodes = null;
            calendar.tomorrowEpisodes = null;
            calendar.dayOffset = calendar.dayOffset - 3;
            setDays();
            loadDays();
        };

        calendar.clickNextDaysButton = function () {
            calendar.yesterdayEpisodes = null;
            calendar.todayEpisodes = null;
            calendar.tomorrowEpisodes = null;
            calendar.dayOffset = calendar.dayOffset + 3;
            setDays();
            loadDays();
        };

        calendar.init = function () {
            loadDays();
        };

        /* set the dates that need to be collected */
        function setDays() {
            day1Date = $filter('date')(referenceDate.addDays(calendar.dayOffset), format);
            day2Date = $filter('date')(referenceDate.addDays(-1 + calendar.dayOffset), format);
            day3Date = $filter('date')(referenceDate.addDays(1 + calendar.dayOffset), format);

            if (calendar.dayOffset === 0) {
                calendar.dayOneName = 'Yesterday';
                calendar.dayTwoName = 'Today';
                calendar.dayThreeName = 'Tomorrow';
            } else {
                if (calendar.dayOffset < 0) {
                    calendar.dayOneName = String((calendar.dayOffset - 1)).replace('-', '') + ' days ago';
                    calendar.dayTwoName = String(calendar.dayOffset).replace('-', '') + ' days ago';
                    calendar.dayThreeName = String((calendar.dayOffset + 1)).replace('-', '') + ' days ago';
                } else {
                    calendar.dayOneName = 'in ' + (calendar.dayOffset - 1) + ' days';
                    calendar.dayTwoName = 'in ' + calendar.dayOffset + ' days';
                    calendar.dayThreeName = 'in ' + (calendar.dayOffset + 1) + ' days';
                }
            }

        }

        /* change reference date */
        function loadDays() {
            getTodayEpisodes();
            getTomorrowEpisodes();
            getYesterdayEpisodes();
        }

        /** Load the series that this user is following */
        function getTodayEpisodes() {
            seriesFactory.getEpisodesForUserByDate(day1Date)
                .success(function (response) {
                    calendar.todayEpisodes = response;
                })
                .error(function (response) {
                    //flash(response.flash);
                });
        }

        function getYesterdayEpisodes() {
            seriesFactory.getEpisodesForUserByDate(day2Date)
                .success(function (response) {
                    calendar.yesterdayEpisodes = response;
                })
                .error(function (response) {
                    //flash(response.flash);
                });
        }

        function getTomorrowEpisodes() {
            seriesFactory.getEpisodesForUserByDate(day3Date)
                .success(function (response) {
                    calendar.tomorrowEpisodes = response;
                })
                .error(function (response) {
                    //flash(response.flash);
                });
        }
    }

})();