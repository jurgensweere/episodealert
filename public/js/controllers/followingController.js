(function(){
    angular.module('eaApp').controller('FollowingCtrl',
        function($scope, seriesFactory, flash) {

            /* watch for any series.following */
            $scope.$watch('series.following', function(following) {
                if (typeof following !== 'undefined') {
                    if (following) {
                        $scope.buttonLabel = 'Following';
                    } else {
                        $scope.buttonLabel = 'Follow';
                    }
                }
            });          

            $scope.mouseOver = function(series) {
                if (series.following) {
                    $scope.buttonLabel = 'Unfollow';
                }
            };

            $scope.mouseOut = function(series) {
                if (series.following) {
                    $scope.buttonLabel = 'Following';
                }           
            };

            $scope.toggleFollowing = function(series) {
                if (series.following) {   
                    unfollowServiceCall(series);              
                } else {
                    followServiceCall(series);
                }
            };

            $scope.followSeries = function() {
                console.log('test');
            };

            /** Call service to unfollow a series */
            function unfollowServiceCall(series) {
                seriesFactory.unfollowSeries(series.id)
                    .success(function (response) {
                        //flash(response.follow);
              
                        series.following = 0;
                    })
                    .error(function (error) {
                        flash(response.follow);
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
                        flash(response.follow);
                    });
            }
        }
    );
})();