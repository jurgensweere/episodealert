(function(){

    angular.module('eaApp').controller('PasswordResetCtrl',
        function($scope) {

        	$scope.passwordReset = function () {
        		console.log('reset password');
        	};

        }
    );
})();