(function(){
    angular.module('eaApp').controller('ProfileSettingsCtrl',  
        function($scope, userSettingService, Page) {

			Page.setTitle('Settings | Episode Alert');
            $scope.activePage = 'settings';
                
        }
    );
})();