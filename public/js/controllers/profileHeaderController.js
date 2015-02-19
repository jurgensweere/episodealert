(function(){
    angular.module('eaApp').controller('ProfileHeaderCtrl',  
        function($scope, seriesFactory) {

            $scope.date = new Date();

            getUnseenAmount();

            /** Load the total unseen count */
            function getUnseenAmount() {
                seriesFactory.getUnseenAmount()
                    .success(function (response) {
                        $scope.unseenAmount = response.unseenepisodes;
                    })
                    .error(function (response) {
                        //flash(response.flash);
                    });
            }            
                
        }
    );
})();