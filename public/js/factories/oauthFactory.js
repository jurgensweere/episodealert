angular.module('eaApp').factory('oauthFactory', ['AuthenticationService', function(AuthenticationService, $location) {
    var oauthFactory = {};

    oauthFactory.onFacebookStatusChange = function(response) {
        switch(response.status) {
            case 'connected':
                AuthenticationService.facebookSignIn(response.authResponse).success(function(){
                    //$location.path('/profile');
                });
                break;
            default:
                break;
        }
    };

    return oauthFactory;
}])
.directive('facebookLogin', ['$rootScope', function() {
    var directive = { restrict: 'E', replace: true, transclude: true };
    directive.template =
        '<fb:login-button scope="email" data-size="xlarge" data-show-faces="false">' +
        '</fb:login-button>';

    directive.link = function (scope, iElement, iAttrs) {
        if (FB) {
            // tell facebook to render the login button
            FB.XFBML.parse(iElement[0].parent);
        }
    };
        
    return directive;
}])
.run(function (oauthFactory) {
    window.fbAsyncInit = function () {
        FB.init({
            appId: window.fbAppId,
            status:true,
            cookie:true,
            xfbml:true,
            version: 'v2.2'
        });
        
        FB.Event.subscribe('auth.statusChange', function(response) {
            oauthFactory.onFacebookStatusChange(response);
        });
    };

    (function (d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = '//connect.facebook.net/en_US/sdk.js';
       fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
});
        