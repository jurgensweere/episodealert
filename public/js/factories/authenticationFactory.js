angular.module('eaApp').factory("AuthenticationService", function($rootScope, $location, $http, SessionService, flash, $window) {

    var cacheSession = function(response){
        SessionService.set('authenticated', true);
    };

    var setUserInfo = function(response){
        $rootScope.credentials.auth = true;
        $rootScope.credentials.username = response.username;
        $rootScope.credentials.id = response.id;
    };

    var unSetUserInfo = function(){
        $rootScope.credentials.auth = null;
        $rootScope.credentials.username = null;
        $rootScope.credentials.id = null;
    };

    var uncacheSession = function(){
        SessionService.unset('authenticated');
    };

    var loginError = function(response) {
        flash('danger', 'Login error');
    };

    var loginMessage = function(response){   
        //flash('success', 'Login success');
    };

    var registerMessage = function(response){
        flash('success', response.flash);
    };

    var registerError = function(response){
        flash('danger', response.flash);
    };

    var checkError = function(response){
        //flash('danger', response.flash);
    };

    return {
        register: function(credentials) {
            var register = $http.post('api/auth/register', credentials);
            register.success(registerMessage);
            register.error(registerError);
            return register;
        },
        login: function(credentials) {
            var login = $http.post('api/auth/login', credentials);
            login.success(cacheSession);
            login.success(loginMessage);
            login.success(setUserInfo);
            login.error(loginError);
            return login;

        },
        logout: function() {
            var logout =  $http.get('api/auth/logout');
            logout.success(uncacheSession);
            logout.success(unSetUserInfo);
            return logout;
        },
        isLoggedIn: function() {
            return SessionService.get('authenticated');
        },
        check: function() {
            var check = $http.get('api/auth/check');
            check.success(cacheSession);
            check.success(setUserInfo);
            check.error(checkError);
            return check;
        },
        googleSignIn: function (authResult) {
            var googleSignIn = $http.post('api/auth/oauth/google', {state: $window.state, authResult: authResult});
            googleSignIn.success(registerMessage);
            googleSignIn.success(cacheSession);
            googleSignIn.success(setUserInfo);
            googleSignIn.error(registerError);
            return googleSignIn;
        },
        facebookSignIn: function (authResult) {
            var facebookSignIn = $http.post('api/auth/oauth/facebook', {state: $window.state, authResult: authResult});
            facebookSignIn.success(registerMessage);
            facebookSignIn.success(cacheSession);
            facebookSignIn.success(setUserInfo);
            facebookSignIn.error(registerError);
            return facebookSignIn;
        }
    };
});