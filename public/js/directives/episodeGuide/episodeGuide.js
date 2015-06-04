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

        var loadGuide = function () {
            seriesFactory.getGuide()
                .success(function (response) {
                    guide.episodes = response;
                })
                .error(function (error) {
                    //$scope.status = 'error error error beep beep;
                });
        };

        loadGuide();

    }

})();