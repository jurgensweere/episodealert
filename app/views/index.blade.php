<!doctype html>
<html lang="en" ng-app="eaApp" ng-controller="MainPageCtrl">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="robots" content="index,follow">
    <meta name="keywords" content="tv, series, episode, alert, Reality TV Shows, Comedy TV Shows, Old Television Shows, Reality TV, Comedy TV, TV Shows, Television Shows, Old TV Shows, Action/Adventure, Animation, Children, Comedy, Drama, Science-Fiction, Soap, Talk Shows, Popular Shows, TV Listings, CBS, NBC, Fox, HBO, ABC, CW" />
    <meta name="description" content="{{ Page.getMetaDescription() ? Page.getMetaDescription() : 'The best source for show and episode info. Keeping you up to date on the latest broadcasts' }}" />

    <meta property="og:title" content="{{ Page.getTitle() ? Page.getTitle() : 'Episode-Alert' }}" />
    <meta property="og:image" content="{{ Page.getImage() }}" />
    <meta property="og:description" content="{{ Page.getMetaDescription() ? Page.getMetaDescription() : 'The best source for show and episode info. Keeping you up to date on the latest broadcasts' }}" />

    <title ng-bind="Page.getTitle()">Episode-Alert</title>
    <base href="/"/>

    <% HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css') %>
    <% HTML::style(asset('css/global.css')) %>

    <% HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') %>
    <% HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular.min.js') %>
    <% HTML::script('//cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.14/angular-ui-router.min.js') %>
    <% HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular-animate.min.js') %>
    <% HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular-touch.js') %>
    <% HTML::script('//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js') %>

    
    <!-- build:libs -->
    <% HTML::script('/js/vendor/_bower.min.js') %>
    <% HTML::script('/js/vendor/ui-bootstrap-0.12.0.js') %>
    <% HTML::script('/js/vendor/ng-sortable.js') %>
    <!-- endbuild -->

</head>
<body>
@if (App::environment() == 'local')
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
@endif
<!-- <div class="background-container"></div> -->
<div id="masterUI">
    <!-- loaded by templates-->
    <div id="topbarUI">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container container--navbar">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">
                        <!-- <img src="img/logo-56x41.png" alt="Episode Alert" /> -->
                        Episode Alert
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form navbar-left" role="search">
                        <div class="input-group" ng-controller="SearchBoxCtrl" >
                            <input type="text" class="form-control form-control-search" placeholder="Search" ng-model="mainPageQuery" ng-model-options="{ debounce: 300 }" />
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default" ng-click="clickSearchButton()" ><span class="fa fa-search"></span></button>
                            </span>
                        </div>
                    </form>
                    <ul class="nav navbar-nav">

                        <li ui-sref-active="active"><a ui-sref="trending">Series</a></li>
                        <li ui-sref-active="active"><a ui-sref="profile.guide">Guide</a></li>
                        <li ng-show="credentials.auth" ui-sref-active="active"><a ui-sref="profile.series">Profile</a></li>
                        <li ng-show="!credentials.auth" ui-sref-active="active">
                            <a ng-show="!credentials.auth" ui-sref="login">Login</a>
                        </li>
                        <li ng-show="!credentials.auth" ui-sref-active="active">
                            <a ng-show="!credentials.auth" ui-sref="register">Register</a>
                        </li>
                        <li ng-show="credentials.auth" ui-sref-active="active" class="hidden-sm hidden-md hidden-lg">
                            <a ng-show="credentials.auth" ui-sref="profile-settings">Settings</a>
                        </li>
                        <li ng-show="credentials.auth">
                            <a href="#" ng-controller="LoginCtrl" ng-click="logout()">Logout</a>
                        </li>
                    </ul>

                    <p class="navbar-text navbar-right hidden-xs hidden-sm" ng-show="credentials.auth">Welcome back, <a href="/profile/settings" class="navbar-link">{{ credentials.accountname }} <i class="fa fa-cog"></i></a> </p>
            <!--         <div class="extra-menu">
                        <i class="fa fa-list" ></i>
                    </div> -->
                </div>
            </div>
        </nav>
    </div>

    <div class="container">
        <div class="ea-alert-top row">
            <alert class="fade-slow" ng-repeat="alert in alerts | filter: { location: 'top' }" location="{{alert.location}}" type="{{alert.type}}" close="alert.close()">               {{alert.msg}}
            </alert>
        </div>
    </div>

    <div class="ea-alert">
        <alert class="fade-slow" ng-repeat="alert in alerts | filter: { location: 'toast' }" location="{{alert.location}}" type="{{alert.type}}" close="alert.close()">{{alert.msg}}</alert>
    </div>
    <!--
    <div class="container">
        <div class="row flash-container">
            <div class="col-md-12 col-lg-12">
                <flash:messages class="animation" />
            </div>
        </div>
    </div> -->
    <div id="fb-root"></div>
    <div id="contentUI" ui-view class="container ea-content fade">
    </div>
    <div class="container" id="footer">
        <div class="footer row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                Copyright 2015
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="https://www.facebook.com/episodealert" target="_blank">Facebook</a> :: <a ui-sref="contact">Contact</a> :: <a ui-sref="privacy">Privacy</a>
            </div>
        </div>
    </div>
    <div id="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>

<script>
    user = <% json_encode($user) %>;
    var clientId = '<% $clientId %>';
    var state = '<% $state %>';
    var fbAppId = '<% $fbAppId %>';
    var googleRedirectURI = '<% Config::get('app.url') . '/login' %>';

    /**
      * dirty hack because twitter bootstrap mobile first responsive
      * framework does not support closing the mobile menu on click for SPA's
    */
    $(document).on('click','.navbar-collapse.in',function(e) {
        if( $(e.target).is('a') ) {
            $(this).collapse('hide');
        }
    });

</script>

<!-- build:js -->
<% HTML::script(asset('js/app.js')) %>
<% HTML::script(asset('js/app.routes.js')) %>

<% HTML::script(asset('js/controllers/carouselController.js')) %>
<% HTML::script(asset('js/controllers/seriesListController.js')) %>
<% HTML::script(asset('js/controllers/seriesController.js')) %>
<% HTML::script(asset('js/controllers/seriesSearchController.js')) %>
<% HTML::script(asset('js/controllers/profileController.js')) %>
<% HTML::script(asset('js/controllers/followingController.js')) %>
<% HTML::script(asset('js/controllers/guideController.js')) %>
<% HTML::script(asset('js/controllers/calendarController.js')) %>
<% HTML::script(asset('js/controllers/profileHeaderController.js')) %>
<% HTML::script(asset('js/controllers/profileSettingsController.js')) %>
<% HTML::script(asset('js/controllers/searchBoxController.js')) %>
<% HTML::script(asset('js/controllers/mainPageController.js')) %>
<% HTML::script(asset('js/controllers/contactController.js')) %>
<% HTML::script(asset('js/controllers/passwordResetController.js')) %>

<% HTML::script(asset('js/factories/authenticationFactory.js')) %>
<% HTML::script(asset('js/factories/seriesFactory.js')) %>
<% HTML::script(asset('js/factories/oauthFactory.js')) %>
<% HTML::script(asset('js/factories/userSettingsFactory.js')) %>
<% HTML::script(asset('js/factories/alertFactory.js')) %>

<% HTML::script(asset('js/directives/eaTab.js')) %>
<% HTML::script(asset('js/directives/eaButtons.js')) %>
<% HTML::script(asset('js/directives/calendarCarousel/calendarCarousel.js')) %>
<% HTML::script(asset('js/directives/episodeGuide/episodeGuide.js')) %>
<!-- endbuild -->

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', '<% $gaTrackingID %>', 'auto');
      ga('send', 'pageview');

    </script>


</body>
</html>


