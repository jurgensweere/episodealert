(function(){
    angular.module('eaAdminApp').controller('AdminSeriesListCtrl',
        function($scope, seriesAdminFactory) {
            
            $scope.series = [];
            $scope.totalItems = 0;
            $scope.currentPage = 1;
            $scope.itemsPerPage = 15;
            $scope.maxSize = 5;

            $scope.setPage = function (pageNo) {
                $scope.currentPage = pageNo;
            };

            $scope.pageChanged = function() {
                getSeries($scope.currentPage);
            };

            /** init **/
            getSeries($scope.currentPage);

            function getSeries(page) {
                seriesAdminFactory.getSeries(page)
                    .success(function (response) {
                        $scope.series = response.data;
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