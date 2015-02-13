(function(){
    angular.module('eaApp')
    .directive('seenButton', function() {
        var directive = { restrict: 'E', replace: true, transclude: true };
        directive.template =
            '<div class="ea-seen-button" ng-if="episode.aired > 0">'+
            '    <button ng-controller="SeenCtrl" class="btn seen-button seen-button--season hidden-xs" ng-click="toggleSeason(episode)">entire season</button>' +
            '    <button ng-controller="SeenCtrl" class="btn seen-button seen-button--untill hidden-xs" ng-click="toggleUntil(episode)">until here</button>' +
            '    <button ng-controller="SeenCtrl" class="btn seen-button seen-button--episode" ng-click="toggleEpisode(episode)">{{ episode.seen ? \'Seen\' : \'Not seen\' }}</button>' +
            '</div>';
        directive.scope = {
            episode: '='
        };

        return directive;
    })

    .directive('followButton', function(seriesFactory) {
        var directive = { restrict: 'E', replace: true, transclude: true };
        directive.template =
            '<button' +
            ' class="btn following-button"' +
            ' ng-class="series.following ? \'following\' : \'notfollowing\'"' +
            ' ng-show="series"' +
            ' ng-mouseover="mouseOver(series)"' +
            ' ng-mouseout="mouseOut(series)"' +
            ' ng-click="toggleFollowing(series)"' +
            '>{{ buttonLabel }}' +
            '</button>';
        directive.scope = {
            series: '='
        };

        directive.link = function (scope, element, attrs) {
            scope.$watch('series', function(series) {
                if (series) {
                    scope.buttonLabel = series.following ? 'Following' : 'Follow';
                }
            }, true);

            scope.mouseOver = function(series) {
                if (series.following) {
                    scope.buttonLabel = 'Unfollow';
                }
            };

            scope.mouseOut = function (series) {
                if (series.following) {
                    scope.buttonLabel = 'Following';
                }  
            };

            scope.toggleFollowing = function (series) {
                if (series.following) {   
                    unfollowServiceCall(series);
                } else {
                    followServiceCall(series);
                }
            };
        };

        /** Call service to unfollow a series */
        function unfollowServiceCall(series) {
            seriesFactory.unfollowSeries(series.id)
                .success(function (response) {
                    //flash(response.follow);
          
                    series.following = 0;
                })
                .error(function (error) {
                    flash(error.follow);
                });
        }

        /** Call service to follow a series */
        function followServiceCall(series) {
            seriesFactory.followSeries(series.id)
                .success(function (response) {
                    //flash(response.follow);
          
                    series.following = 1;
                })
                .error(function (error) {
                    flash(error.follow);
                });
        }

        return directive;
    });
})();