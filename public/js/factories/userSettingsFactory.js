angular.module('eaApp').factory('userSettingService', ['$rootScope', function ($rootScope) {

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
        }

    };

    service.init();

    return service;
}]);