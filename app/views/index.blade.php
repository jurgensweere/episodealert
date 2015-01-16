<!doctype html>
<html lang="en" ng-app="eaApp">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Episode Alert</title>
    <base href="/"/>

    <% HTML::style('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css') %>
    <% HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css') %>
    <% HTML::style(asset('css/global.css')) %>

    <% HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') %>
    <% HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.3.0/angular.min.js') %>
    <% HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.3.0/angular-route.min.js') %>
    <% HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.3.0/angular-animate.min.js') %>
    <% HTML::script('/js/vendor/ui-bootstrap-0.11.2.js') %>
    <% HTML::script('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js') %>
    <% HTML::script('/js/vendor/_bower.js') %>

</head>
<body>

@if (App::environment() == 'local')
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
@endif
<!-- <div class="background-container"></div> -->
<div id="masterUI" ui-view="master" ng-controller="SeriesSearchCtrl">
    <!-- loaded by templates-->
    <div id="topbarUI" ui-view="topbar">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container container--navbar">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/home">
                        <!-- <img src="img/logo-56x41.png" alt="Episode Alert" /> -->
                        Episode Alert
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-search" placeholder="Search" ng-model="mainPageQuery" ng-model-options="{ debounce: 300 }">
                        </div><button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                    </form>
                    <ul class="nav navbar-nav" ng-controller="HeaderCtrl">
                        <li ng-class="{ active: isActive('/series')}"><a href="/series/genre/action">Browse</a></li>
                        <li ng-class="{ active: isActive('/home')}"><a href="/home">Trending</a></li>
                        <li ng-class="{ active: isActive('/profile')}"><a href="/profile">Profile</a></li>
                        <li ng-show="credentials.auth">
                            <a href="#" ng-controller="LoginCtrl" ng-click="logout()">Logout</a>
                        </li>
                        <li ng-show="!credentials.auth">
                            <a ng-show="!credentials.auth" href="/login">Login</a>
                        </li>                                        
                    </ul>

                    <p class="navbar-text navbar-right" ng-show="credentials.auth">Welcome back, <a href="#" class="navbar-link">{{ credentials.username }}</a></p>
                </div>
            </div>
        </nav>
    </div>
    <div class="container">
        <div class="row flash-container">
            <div class="col-md-12 col-lg-12">    
                <flash:messages class="animation" />
            </div>
        </div>
    </div>
    <div id="contentUI" ui-view="content" class="container ea-content fade" ng-view>
    </div>
</div>

<% HTML::script(asset('js/app.js')) %>

<% HTML::script(asset('js/controllers/carouselController.js')) %>
<% HTML::script(asset('js/controllers/seriesDetailController.js')) %>
<% HTML::script(asset('js/controllers/seriesListController.js')) %>
<% HTML::script(asset('js/controllers/seriesController.js')) %>
<% HTML::script(asset('js/controllers/seriesSearchController.js')) %>
<% HTML::script(asset('js/controllers/profileController.js')) %>
<% HTML::script(asset('js/controllers/followingController.js')) %>
<% HTML::script(asset('js/controllers/seenController.js')) %>

<% HTML::script(asset('js/factories/seriesFactory.js')) %>

<% HTML::script(asset('js/modules/angular-flash.js')) %>

</body>
</html>