(function(){
    angular.module('eaApp')
    .directive('seenButton', ['seriesFactory', function(seriesFactory) {
        return {
            restrict: 'E',
            scope: {
                episode: '=',
                seenResponse: '&onSeenResponse',
                unseenResponse: '&onUnseenResponse'
            },
            template:
                '<div class="ea-seen-button" ng-if="episode.aired > 0">'+
                '    <button class="btn seen-button seen-button--season hidden-xs" ng-click="toggleSeason(episode)">entire season</button>' +
                '    <button class="btn seen-button seen-button--untill hidden-xs" ng-click="toggleUntil(episode)">until here</button>' +
                '    <button class="btn seen-button seen-button--episode" ng-click="toggleEpisode(episode)">{{ episode.seen ? \'Seen\' : \'Not seen\' }}</button>' +
                '</div>',
            link: function(scope, element, attrs) {
                /** Toggle an episode (un)seen */
                scope.toggleEpisode = function(episode) {
                    if (episode.seen) {
                        unseenServiceCall(episode, 'single');
                    } else {
                        seenServiceCall(episode, 'single');
                    }
                };

                /** Toggle a episodes (un)seen until here */
                scope.toggleUntil = function (episode) {
                    if (episode.seen) {
                        unseenServiceCall(episode, 'until');
                    } else {
                        seenServiceCall(episode, 'until');
                    }
                };

                /** Toggle a season (un)seen */
                scope.toggleSeason = function (episode) {
                    if (episode.seen) {
                        unseenServiceCall(episode, 'season');
                    } else {
                        seenServiceCall(episode, 'season');
                    }
                };

                /**
                 * Set an episode to 'seen'
                 *
                 * @param episode
                 * @param mode
                 */
                function seenServiceCall(episode, mode) {
                    seriesFactory.setSeenEpisode(episode.id, mode)
                        .success(function (response) {
                            scope.seenResponse({response: response});
                        })
                        .error(function (error) {
                            //flash(error.seen);
                        });
                }

                /**
                 * Set an episode to 'unseen'
                 *
                 * @param episode
                 * @param series
                 */
                function unseenServiceCall(episode, mode) {
                    seriesFactory.setUnseenEpisode(episode.id, mode)
                        .success(function (response) {
                            scope.unseenResponse({response: response});
                        })
                        .error(function (error) {
                            //flash(response.unseen);
                        });
                }
            }
        };
    }])

    .directive('followButton', function(seriesFactory, AuthenticationService, FollowingQueue, alertService, $location) {
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
                    if(AuthenticationService.isLoggedIn()){
                        followServiceCall(series);
                    }else{
                        //Save the action in the cache
                        var functionToQueue = function(){
                            followServiceCall(series);
                        };

                        //Add the function call to the action cache, will be called after user logs in
                        FollowingQueue.addFollowing(series.id);

                        //add alert info
                        //alertService.add('success', 'je moet wel inloggen');
                        //alertService.add('info', 'om lekker');
                        alertService.add('Please register or login to follow this show and continue to your profile', { type : 'warning', location: 'top', time : 20000 });
                        //alertService.add('danger', 'te volgen');

                        //Redirect to login or registration
                        $location.path("/login");

                        //Set a message to be shown
                        //TODO: implement decent actions (ui-bootstrap)
                    }
                }
            };
        };

        /** Call service to unfollow a series */
        function unfollowServiceCall(series) {
            seriesFactory.unfollowSeries(series.id)
                .success(function (response) {
                    //flash(response.follow);
                    alertService.add('Unfollowed ' + series.name, { type : 'success', location: 'toast', time : 5000 });
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
                    alertService.add('Following ' + series.name, { type : 'success', location: 'toast', time : 5000 });
                    series.following = 1;
                })
                .error(function (error) {
                    flash(error.follow);
                });
        }

        return directive;
    });
})();