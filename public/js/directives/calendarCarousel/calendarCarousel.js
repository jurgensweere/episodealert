(function(){
    
    angular.module('eaApp')
    
    .directive('calendarCarousel', [function() {
      return {
        templateUrl : '/js/directives/calendarCarousel/calendarCarousel.tpl.html',
        controllerAs : 'calendar',
        controller : calendarController,
      }
    }]);    
    
    function calendarController($filter, seriesFactory) {

            var that = this;

            this.dayOneName = 'Yesterday';
            this.dayTwoName = 'Today';
            this.dayThreeName = 'Tomorrow';

            this.yesterdayEpisodes = null;
            this.todayEpisodes = null;
            this.tomorrowEpisodes = null;

            this.clickPreviousDaysButton = function(){
                this.yesterdayEpisodes = null;
                this.todayEpisodes = null;
                this.tomorrowEpisodes = null;
                dayOffset = dayOffset - 3;
                setDays();
                loadDays();
            };

            this.clickNextDaysButton = function(){
                this.yesterdayEpisodes = null;
                this.todayEpisodes = null;
                this.tomorrowEpisodes = null;
                dayOffset = dayOffset + 3;
                setDays();
                loadDays();
            };

            this.init = function(){
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
                    dayOneName = 'Yesterday';
                    dayTwoName = 'Today';
                    dayThreeName = 'Tomorrow';
                }else{
                    if(dayOffset < 0){
                        dayOneName = String((dayOffset - 1)).replace('-', '') + ' days ago';
                        dayTwoName = String(dayOffset).replace('-', '') + ' days ago';
                        dayThreeName = String((dayOffset + 1)).replace('-', '') + ' days ago';
                    }else{
                        dayOneName = 'in ' + (dayOffset - 1) + ' days';
                        dayTwoName = 'in ' + dayOffset + ' days';
                        dayThreeName = 'in ' + (dayOffset + 1) + ' days';
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
                        that.todayEpisodes = response;
                    })
                    .error(function (response) {
                        //flash(response.flash);
                    });
            }

            function getYesterdayEpisodes() {
                seriesFactory.getEpisodesForUserByDate(day2Date)
                    .success(function (response) {
                        that.yesterdayEpisodes = response;
                    })
                    .error(function (response) {
                        //flash(response.flash);
                    });
            }

            function getTomorrowEpisodes() {
                seriesFactory.getEpisodesForUserByDate(day3Date)
                    .success(function (response) {
                        that.tomorrowEpisodes = response;
                    })
                    .error(function (response) {
                        //flash(response.flash);
                    });
            }



        }

})();