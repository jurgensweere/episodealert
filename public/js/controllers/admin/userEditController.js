(function(){
    angular.module('eaAdminApp').controller('AdminUserEditCtrl',
        function($scope, $window, $stateParams, userFactory) {
            
            $scope.user = {};

            $scope.assumeDirectControl = function() {
                console.log('assume control over ' + $scope.user.accountname);
                userFactory.assumeDirectControl($scope.user.id)
                    .success(function (response) {
                        $window.location.href = '/profile/series';
                    })
                    .error(function (response) {
                        //
                    });
            };

            /** init **/
            getUser($stateParams.userId);

            function getUser(userId) {
                userFactory.getUser(userId)
                    .success(function (response) {
                        $scope.user = response;
                    })
                    .error(function (response) {
                        //flash(response.flash);
                    });
            }
        }
    );
})();