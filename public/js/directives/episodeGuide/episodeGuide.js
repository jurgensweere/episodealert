(function () {

    angular.module('eaApp')

        .directive('episodeGuide', [function () {
            return {
                scope: {},
                controller: episodeGuide,
                controllerAs: 'guide',
                templateUrl: '/js/directives/episodeGuide/episodeGuide.tpl.html',
            };
        }]);

    function episodeGuide($filter, seriesFactory) {
        var guide = this;

        guide.episodes = {};
        guide.numberOfDays = 7;

        guide.toggleDays = function(){
            guide.episodes = {};
            loadGuide(guide.numberOfDays);
        };

        var loadGuide = function (numberOfDays) {
            seriesFactory.getGuide(numberOfDays)
                .success(function (response) {
                    guide.episodes = response;
                })
                .error(function (error) {
                    //$scope.status = 'error error error beep beep;
                });
        };

        loadGuide(guide.numberOfDays);

    }

})();