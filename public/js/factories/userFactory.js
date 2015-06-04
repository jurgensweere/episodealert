angular.module('eaAdminApp').factory('userFactory', ['$http', function($http) {

    var urlBase = '/api/user/';
    var userFactory = {};

    /**
     * Get users
     *
     * @return {array} List of users
     */
    userFactory.getUsers = function (page) {
        return $http.get(urlBase, { params: {page: page}, cache : true} );
    };

    return userFactory;
}]);