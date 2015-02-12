(function(){

    angular.module('eaApp').controller('MainPageCtrl',
        function($scope, Page) {

            $scope.Page = Page;

        }
    );
})();