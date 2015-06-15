(function(){
    angular.module('eaAdminApp').controller('AdminUserListCtrl',
        function($scope, userFactory) {
            
            $scope.users = [];
            $scope.totalItems = 0;
            $scope.currentPage = 1;
            $scope.itemsPerPage = 15;
            $scope.maxSize = 5;
            $scope.query = '';

            $scope.setPage = function (pageNo) {
                $scope.currentPage = pageNo;
            };

            $scope.pageChanged = function() {
                getUsers($scope.currentPage);
            };

            $scope.$watch('query', function (newValue, oldValue)
            {
                if (newValue !== oldValue) {
                    getUsers(1);
                }
            });

            /** init **/
            getUsers($scope.currentPage);

            function getUsers(page) {
                userFactory.getUsers(page, $scope.query)
                    .success(function (response) {
                        $scope.users = response.data;
                        $scope.totalItems = response.total;
                        //$scope.currentPage = response.current_page;
                        $scope.itemsPerPage = response.per_page;
                    })
                    .error(function (response) {
                        //flash(response.flash);
                    });
            }
        }
    );
})();