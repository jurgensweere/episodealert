angular.module('eaAdminApp').config(function($stateProvider, $urlRouterProvider, $locationProvider) {
    
  $locationProvider.html5Mode(true);
  $urlRouterProvider.otherwise("");
  
  $stateProvider

    .state('admin', {
        url : '',
        templateUrl : '/templates/admin/welcome.html'
    })
    .state('admin.users', {
        url : '/users',
        templateUrl : '/templates/admin/user-list.html',
        controller : 'AdminUserListCtrl'
    })
    .state('admin.series', {
        url : '/series',
        templateUrl : '/templates/admin/series-list.html',
        controller : 'AdminSeriesListCtrl'
    });


});
