angular.module('eaApp').factory('oauthFactory', ['AuthenticationService', '$location', function(AuthenticationService, $location) {
    var oauthFactory = {};

    oauthFactory.onFacebookStatusChange = function(response) {
        switch(response.status) {
            case 'connected':
                AuthenticationService.facebookSignIn(response.authResponse).success(function(){
                    $location.path('/profile');
                });
                break;
            default:
                break;
        }
    };

    return oauthFactory;
}])
.directive('facebookLogin', ['$timeout', function($timeout) {
    var directive = { restrict: 'E', replace: true, transclude: true };
    directive.template =
        '<fb:login-button scope="email" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false">' +
        '</fb:login-button>';

    directive.link = function (scope, iElement, iAttrs) {

        // We need to wait for FB to be available, before we can call it.
        function renderWithFacebook(tries) {
            if (isNaN(+tries)) {
              tries = 10;
            }

            if (tries > 0) {
                $timeout(function() {
                    if (FB) {
                        // tell facebook to render the login button
                        FB.XFBML.parse(iElement[0].parent);
                    } else {
                        renderWithFacebook(--tries);
                    }
                }, 100);
            }
        }
        renderWithFacebook(10);
    };
        
    return directive;
}])
.directive('googleLogin', ['$window', '$timeout', function ($window, $timeout) {
    var ending = /\.apps\.googleusercontent\.com$/;

    var directive = {
      restrict: 'E',
      transclude: true,
      replace: true };

    directive.template = 
      '<a class="btn btn-block btn-social btn-google-plus" '+
      'href="https://accounts.google.com/o/oauth2/auth' +
      '?scope=email' +
      '&state=' + $window.state + 
      '&redirect_uri=' + $window.googleRedirectURI + 
      '&response_type=code&' +
      '&client_id=' + $window.clientId + 
      '&access_type=offline'+
      '&openid.realm=' + $window.googleRedirectURI +
      '"><i class="fa fa-google-plus"></i> Sign in with Google</a>';

    return directive;
}])
.run(['$window', 'oauthFactory', function ($window, oauthFactory) {
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
}]);
        