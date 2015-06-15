angular.module('eaAdminApp').factory('userFactory', ['$http', function($http) {

    var urlBase = '/api/user/';
    var userFactory = {};

    /**
     * Get user
     *
     * @return {object} User details
     */
    userFactory.getUser = function (userId) {
        return $http.get(urlBase + userId, {cache : true} );
    };

    /**
     * Get users
     *
     * @return {array} List of users
     */
    userFactory.getUsers = function (page, query) {
        return $http.get(urlBase, { params: {page: page, query: query}, cache : true} );
    };

    /**
     * Assume Direct Control
     *
     * $return {object} User Details
     */
    userFactory.assumeDirectControl = function (userId) {
        return $http.get(urlBase + userId + '/assumedirectcontrol', { cache : false } );
    };

    return userFactory;
}]);