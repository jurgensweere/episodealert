<!doctype html>
<html lang="en" ng-app="eaAdminApp" ng-controller="MainPageCtrl">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Episode-Alert ADMIN</title>
    <base href="/admin/"/>

    <% HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css') %>
    <% HTML::style(asset('css/global.css')) %>

    <% HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') %>
    <% HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular.js') %>
    <% HTML::script('//cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.14/angular-ui-router.min.js') %>
    <% HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular-animate.min.js') %>
    <% HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular-touch.js') %>
    <% HTML::script('//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js') %>

    <% HTML::script('/js/vendor/ui-bootstrap-0.12.0.js') %>

    <% HTML::script(asset('js/admin-app.js')) %>
    <% HTML::script(asset('js/admin-app.routes.js')) %>


    <% HTML::script(asset('js/controllers/admin/mainPageController.js')) %>
    <% HTML::script(asset('js/controllers/admin/userListController.js')) %>
</head>
<body>
<div id="masterUI">
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
                    <a class="navbar-brand" href="/admin/index">
                        <!-- <img src="img/logo-56x41.png" alt="Episode Alert" /> -->
                        Episode Alert - ADMIN
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">

                        <li ui-sref-active="active"><a ui-sref="users">Users</a></li>
                        <li ui-sref-active="active"><a ui-sref="series">Series</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div id="contentUI" ui-view class="container ea-content fade"></div>
</div>


</body>
</html>