angular.module('eaApp').config(function($stateProvider, $urlRouterProvider, $locationProvider) {
    
  $locationProvider.html5Mode(true)
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

    .state('profile', {
        url : '/profile',
        templateUrl : 'templates/profile.html', 
        controller : 'ProfileCtrl' 

        // views: {
        //         '': { 
        //             templateUrl : 'templates/profile.html', 
        //             controller : 'ProfileCtrl' 
        //         },
        //         'wurst@profile' : {
        //             templateUrl : 'templates/wurst.html',
        //             controller : 'WurstCtrl' 
        //         },
             
        //     }

    })

    .state('trending', {
        url : '/trending',
        templateUrl : 'templates/carousel.html',
        controller : 'CarouselCtrl'
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

    .state('profile-settings', {
        url : '/profile/settings',
        templateUrl : 'templates/profile/settings.html',
        controller : 'ProfileSettingsCtrl'
    })

    .state('profile-guide', {
        url : '/profile/guide',
        templateUrl : 'templates/guide.html',
        controller : 'GuideCtrl'
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
    })

});
