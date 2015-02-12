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
            }            
        },

        init : function () {
            service.restoreState();
        },

        setProfileArchive : function ( archive ) {
            service.model.userProfileSettings.archive = archive;
            service.saveState();
        },

        setProfileSeen : function ( seen ) {
            service.model.userProfileSettings.seen = seen;
            service.saveState();
        },

        setProfileEnded: function ( ended ) {
            service.model.userProfileSettings.ended = ended;
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

        saveCredentials: function (username, email) {
            return $http.post(
                '/api/profile/credentials', 
                data = {
                    username: username,
                    email: email
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
        }

    };

    service.init();

    return service;
}]);