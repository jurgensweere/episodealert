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
.directive('facebookLogin', ['$timeout', 'oauthFactory', function($timeout, oauthFactory) {
    var directive = { restrict: 'E' };
    directive.template =
        '<a class="btn btn-block btn-social btn-facebook" href="#" ng-click="facebookLogin()">'+
        '<i class="fa fa-facebook"></i> Sign in with Facebook</a>';

    directive.link = function (scope, iElement, iAttrs) {
        scope.facebookLogin = function () {
          FB.login(function(response) {
             oauthFactory.onFacebookStatusChange(response);
          }, {scope: 'email'});
        };
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
    };

    (function (d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = '//connect.facebook.net/en_US/sdk.js';
       fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
}]);
        