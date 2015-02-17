(function(){
    angular.module('eaApp').controller('ProfileSettingsCtrl', 
        function($scope, $rootScope, userSettingService, Page, flash) {

			Page.setTitle('Settings | Episode Alert');
            $scope.activePage = 'settings';
            $scope.password = {};
            $scope.cred = {};
            $scope.preferences = {};

            userSettingService.getUserData()
                .success(function (data) {
                    $scope.cred.username = data.accountname;
                    $scope.cred.email = data.email;
                    $scope.preferences.alerts = data.alerts == 1;
                    $scope.preferences.publicfollow = data.publicfollow == 1;


                })
                .error(function(error) {
                    flash('danger', error.flash);
                });

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
            };

            $scope.saveCredentials = function() {
                userSettingService.saveCredentials($scope.cred.username, $scope.cred.email, $scope.cred.password)
                    .success(function (msg) {
                        $scope.cred = msg;
                        // Update name in the rest of the app
                        $rootScope.credentials.username = msg.username;
                        flash('success', msg.flash);
                    })
                    .error(function (error) {
                        $scope.cred = error;
                        flash('warning', error.flash);
                    });
            };

            $scope.savePreferences = function() {
                userSettingService.savePreferences($scope.preferences.publicfollow, $scope.preferences.alerts)
                    .success(function (msg) {
                        $scope.preferences = msg;
                        flash('success', msg.flash);
                    })
                    .error(function (error) {
                        $scope.preferences = error;
                        flash('warning', error.flash);
                    });
            };
        }
    );
})();