(function(){

    angular.module('eaApp').controller('PasswordResetCtrl',
        function ($scope, $rootScope, $routeParams, $location, AuthenticationService, alertService) {

            $scope.password = '';
            $scope.password_confirmation = '';

            var reminderSent = function (response) {
                alertService.add(response.flash, {type: 'success', location: 'top', time: 10000});
            };

            var reminderSendError = function (response) {
                alertService.add(response.flash, {type: 'warning', location: 'top', time: 10000});
            };

            var resetSuccess = function (response) {
                alertService.add(response.flash, {type: 'success', location: 'top', time: 10000});
                $location.path('/login');
            };

            var resetError = function (response) {
                alertService.add(response.flash, {type: 'warning', location: 'top', time: 10000});
            };

            $scope.passwordRequest = function () {
                reminder = AuthenticationService.remindPassword($rootScope.credentials.email);

                reminder.success(reminderSent);
                reminder.error(reminderSendError);
            };

            $scope.passwordReset = function () {
                newPassword = AuthenticationService.newPassword(
                    $rootScope.credentials.email,
                    $scope.password,
                    $scope.password_confirmation,
                    $routeParams.token
                );
                newPassword.error(resetError);
                newPassword.success(resetSuccess);
            };

        }
    );
})();