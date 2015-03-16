angular.module('eaApp').factory("AuthenticationService", function ($rootScope, $location, $http, SessionService, $window, ActionCache, FollowingQueue, alertService) {

    var cacheSession = function (response) {
        SessionService.set('authenticated', true);
    };

    var setUserInfo = function (response) {
        $rootScope.credentials.auth = true;
        $rootScope.credentials.accountname = response.accountname;
        $rootScope.credentials.id = response.id;
        $rootScope.credentials.thirdparty = response.thirdparty;
    };

    var executeCachedActions = function () {
        //Execute any cache actions that
        FollowingQueue.executeActions();
    };

    var unSetUserInfo = function () {
        $rootScope.credentials.auth = null;
        $rootScope.credentials.accountname = null;
        $rootScope.credentials.id = null;
        $rootScope.credentials.thirdparty = null;
    };

    var uncacheSession = function () {
        SessionService.unset('authenticated');
    };

    var loginError = function (response) {
        alertService.add(response.flash, { type : 'warning', location: 'top', time : 10000 });
    };

    var loginMessage = function (response) {
        alertService.add('Login success', { type : 'success', location: 'top', time : 10000 });
        //flash('success', 'Login success');
    };

    var registerMessage = function (response) {
        alertService.add(response.flash, { type : 'success', location: 'top', time : 10000 });
        //flash('success', response.flash);
    };

    var registerError = function (response) {
        alertService.add(response.flash, { type : 'warning', location: 'top', time : 10000 });
        //flash('danger', response.flash);
    };

    var checkError = function (response) {
        //flash('danger', response.flash);
    };

    return {
        register: function (credentials) {
            var self = this;
            var register = $http.post('api/auth/register', credentials);
            register.success(registerMessage);
            register.success(function() {
                self.check().success(function() {
                    $location.path('/profile');
                });
            });
            register.error(registerError);
            return register;
        },
        login: function (credentials) {
            var login = $http.post('api/auth/login', credentials);
            login.success(executeCachedActions);
            login.success(cacheSession);
            login.success(loginMessage);
            login.success(setUserInfo);
            login.error(loginError);
            return login;

        },
        logout: function () {
            var logout = $http.get('api/auth/logout');
            logout.success(uncacheSession);
            logout.success(unSetUserInfo);
            return logout;
        },
        isLoggedIn: function () {
            return SessionService.get('authenticated');
        },
        check: function () {
            var check = $http.get('api/auth/check');
            check.success(cacheSession);
            check.success(setUserInfo);
            check.success(executeCachedActions);
            check.error(checkError);
            check.error(unSetUserInfo);
            check.error(uncacheSession);
            return check;
        },
        pageLoadInit: function ()
        {
            if ($window.user && $window.user.id) {
                executeCachedActions();
                cacheSession($window.user);
                setUserInfo($window.user);
                delete window.user;
            }
        },
        facebookSignIn: function (authResult) {
            var facebookSignIn = $http.post('api/auth/oauth/facebook', {
                state: $window.state,
                authResult: authResult
            });
            facebookSignIn.success(registerMessage);
            facebookSignIn.success(cacheSession);
            facebookSignIn.success(setUserInfo);
            facebookSignIn.success(executeCachedActions);
            facebookSignIn.error(registerError);
            return facebookSignIn;
        },
        remindPassword: function (email) {
            return $http.post('/api/password/reminder', {email: email});
        },
        newPassword: function(email, pw, pw_confirm, token) {
            return $http.post('/api/password/reset', {email: email, password: pw, password_confirmation: pw_confirm, token: token});
        }
    };
});