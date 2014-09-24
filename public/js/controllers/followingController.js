(function(){

    angular.module('eaApp').controller('FollowingCtrl',
        function($scope, seriesFactory, flash) {

          $scope.hoverFollowing = function(event){
            event.currentTarget.innerHTML = 'Unfollow';
          };

          $scope.hoverFollowingOut = function(event){
            event.currentTarget.innerHTML = 'Following';
          };

          $scope.followSeries = function(series, event){
            followServiceCall(series, event);
          };

          $scope.unfollowSeries = function(series, event){
          	unfollowServiceCall(series, event);
          };

          function unfollowServiceCall(series, event) {
            seriesFactory.unfollowSeries(series.id)
            .success(function (response) {
              //flash(response.follow);
              
              series.following = 0;

            })
            .error(function (error) {
              flash(response.follow);
            });
          }

          function followServiceCall(series, event) {
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