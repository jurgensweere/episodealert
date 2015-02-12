(function(){
    angular.module('eaApp').controller('ProfileSettingsCtrl',  
        function($scope, userSettingService, flash) {

            $scope.activePage = 'settings';
            $scope.password = {};
            $scope.cred = {};

            $scope.savePassword = function() {
                userSettingService.savePassword($scope.password.old, $scope.password.new, $scope.password.new_confirmation)
                    .success(function (msg) {
                        $scope.password = {};
                        flash('success', msg.flash);
                    })
                    .error(function (error) {
                        $scope.password = {};
                        flash('warning', error.flash);
                    });
            }

            $scope.saveCredentials = function() {
                userSettingService.saveCredentials($scope.cred.username, $scope.cred.email)
                    .success(function (msg) {
                        $scope.cred = {};
                        flash('success', msg.flash);
                    })
                    .error(function (error) {
                        $scope.cred = {};
                        flash('warning', error.flash);
                    });
            }
        }
    );
})();