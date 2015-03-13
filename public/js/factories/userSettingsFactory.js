angular.module('eaApp').factory('userSettingService', ['$rootScope', '$http', function ($rootScope, $http) {

    var service = {

        model : {
            userProfileSettings : {
                archive : true,
                seen : false,
                ended : true,
            },

            userGuideSettings : {
                seen: true,
                upcoming: true
            },
        },

        init : function () {
            service.restoreState();
        },

        getProfileArchive : function () {
            return service.model.userProfileSettings.archive;
        },

        setProfileArchive : function ( archive ) {
            service.model.userProfileSettings.archive = archive;
            service.saveState();
        },

        getProfileSeen : function () {
            return service.model.userProfileSettings.seen;
        },

        setProfileSeen : function ( seen ) {
            service.model.userProfileSettings.seen = seen;
            service.saveState();
        },

        getProfileEnded: function () {
            return service.model.userProfileSettings.ended;
        },

        setProfileEnded: function ( ended ) {
            service.model.userProfileSettings.ended = ended;
            service.saveState();
        },

        getGuideIncludeUnseen: function () {
            return service.model.userGuideSettings.seen;
        },

        setGuideIncludeUnseen: function ( includeUnseen ) {
            service.model.userGuideSettings.seen = includeUnseen;
            service.saveState();
        },

        getGuideIncludeUpcoming: function () {
            return service.model.userGuideSettings.upcoming;
        },

        setGuideIncludeUpcoming: function ( includeUpcoming ) {
            service.model.userGuideSettings.upcoming = includeUpcoming;
            service.saveState();
        },

        saveState: function () {
            localStorage.userSettings = angular.toJson(service.model);
        },

        restoreState: function () {
            //check if the userSettings is available in the users local storage
            if(localStorage.userSettings){
                //collect the data and set it to local model
                service.model = angular.fromJson(localStorage.userSettings);
            }else{
                //save the default values
                service.saveState();
            }
        },

        savePassword: function (currentPassword, password, password_confirmation) {
            return $http.post(
                '/api/profile/password',
                data = {
                    oldpassword: currentPassword,
                    password: password,
                    password_confirmation: password_confirmation
                }
            );
        },

        saveCredentials: function (accountname, email, password) {
            return $http.post(
                '/api/profile/credentials',
                data = {
                    accountname: accountname,
                    email: email,
                    password: password
                }
            );
        },

        savePreferences: function (publicfollow, alerts) {
            return $http.post(
                '/api/profile/preferences',
                data = {
                    publicfollow: publicfollow,
                    alerts: alerts
                }
            );
        },

        getUserData: function () {
            return $http.get('/api/profile');
        },

        getProfileStats: function () {
            return $http.get('/api/profile/stats');
        }

    };

    service.init();

    return service;
}]);
