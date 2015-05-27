angular.module('eaApp').config(function($stateProvider, $urlRouterProvider, $locationProvider) {
    
  $locationProvider.html5Mode(true);
  $urlRouterProvider.otherwise("/trending");
  
  $stateProvider

    .state('browse', {
        url : '/series/genre/:genre',
        params : {
            genre : 'action'
        },
        templateUrl : 'templates/series-browse.html',
        controller : 'SeriesListCtrl'
    })

    /*
     *  Profile
     */
    .state('profile', {
        url : '/profile',
        templateUrl : 'templates/profile/profile.html',
     })

    .state('profile.series',{
        url : '/series',
        templateUrl : 'templates/profile/profile.series.html',
        controller : 'ProfileCtrl'
    })

    .state('profile.guide', {
        url : '/guide',
        templateUrl : 'templates/profile/profile.guide.html',
        controller : 'GuideCtrl'
    })

    .state('profile.settings',{
        url : '/settings',
        templateUrl : 'templates/profile/profile.settings.html',
        controller : 'ProfileSettingsCtrl'
    })

    .state('trending', {
        url : '/trending',
        templateUrl : 'templates/trending.html',
        controller : 'TrendingCtrl'
    })

    .state('series-detail', {
        url : '/series/:seriesname',
        templateUrl : 'templates/series-detail.html',
        controller : 'SeriesCtrl'
    })

    .state('search', {
        url : '/search?query=',
        templateUrl : 'templates/series-search.html',
        controller : 'SeriesSearchCtrl',
        reloadOnSearch : false
    })

    .state('login', {
        url : '/login',
        templateUrl : 'templates/auth/login.html',
        controller : 'LoginCtrl'
    })

    .state('register', {
        url : '/register',
        templateUrl : 'templates/auth/register.html',
        controller : 'RegisterCtrl'
    })

    .state('passwordreset', {
        url : '/passwordreset',
        templateUrl : 'templates/auth/passwordreset.html',
    })

    .state('passwordreset-confirm', {
        url : '/password/reset/:token',
        templateUrl : 'templates/auth/passwordresetconfirm.html',
        controller : 'PasswordResetCtrl'
    })

    .state('contact', {
        url : '/contact',
        controller : 'ContactCtrl',
        templateUrl : 'templates/contact.html'
    })

    .state('privacy', {
        url : '/privacy',
        templateUrl : 'templates/privacy.html'
    })

    .state('testing', {
        url : '/testing',
        templateUrl : 'templates/testpage.html'
    });

});
