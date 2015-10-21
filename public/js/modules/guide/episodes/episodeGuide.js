(function () {

    angular.module('eaApp.guide.episodes', [])

        .directive('episodeGuide', [function () {
            return {
                scope: {},
                controller: episodeGuide,
                controllerAs: 'guide',
                templateUrl: '/js/modules/guide/episodes/guide.episodes.tpl.html',
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