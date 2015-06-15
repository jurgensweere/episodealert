angular.module('eaAdminApp').config(function($stateProvider, $urlRouterProvider, $locationProvider) {
    
  $locationProvider.html5Mode(true);
  $urlRouterProvider.otherwise("/index");
  
  $stateProvider

    .state('home', {
        url : '/index',
        templateUrl : '/templates/admin/welcome.html'
    })
    .state('users', {
        url : '/users',
        templateUrl : '/templates/admin/user-list.html',
        controller : 'AdminUserListCtrl'
    })
    .state('useredit', {
        url : '/users/:userId',
        templateUrl : '/templates/admin/user-edit.html',
        controller : 'AdminUserEditCtrl'
    })
    .state('series', {
        url : '/series',
        templateUrl : '/templates/admin/series-list.html',
        controller : 'AdminSeriesListCtrl'
    });


});
