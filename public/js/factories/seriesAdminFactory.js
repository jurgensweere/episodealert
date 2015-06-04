angular.module('eaAdminApp').factory('seriesAdminFactory', ['$http', function($http) {

    var urlBase = '/api/admin/series/';
    var seriesAdminFactory = {};

    /**
     * Get series
     *
     * @return {array} List of series
     */
    seriesAdminFactory.getSeries = function (page) {
        return $http.get(urlBase, { params: {page: page}, cache : true} );
    };

    return seriesAdminFactory;
}]);