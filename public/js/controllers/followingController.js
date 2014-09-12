(function(){

    angular.module('eaApp').controller('FollowingCtrl',
        function($scope, seriesFactory, flash) {

          $scope.followSeries = function(series_id, event){
            console.log(event.currentTarget);
            followServiceCall(series_id);
          };

          function followServiceCall(series_id) {
            seriesFactory.followSeries(series_id)
            .success(function (response) {
              flash(response.follow);
            })
            .error(function (error) {
              flash(response.follow);
            });
          }

        }
    );

})();