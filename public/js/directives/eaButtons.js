(function(){
    angular.module('eaApp')



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
            });

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