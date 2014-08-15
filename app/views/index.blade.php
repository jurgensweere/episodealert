<!doctype html>
<html lang="en" ng-app="eaApp">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Episode Alert</title>

    {{ HTML::style('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css') }}
    {{ HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css') }}
    {{ HTML::style(asset('css/global.css')) }}

    {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js') }}
    {{ HTML::script('//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js') }}
    {{ HTML::script('//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js') }}
    {{ HTML::script(asset('js/app.js')) }}

</head>
<body>

@if (App::environment() == 'local')
<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
@endif

<div id="masterUI" ui-view="master">
    <!-- loaded by templates-->
    <div id="topbarUI" ui-view="topbar">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><img src="img/logo-56x41.png" alt="Episode Alert" /></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div><button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                    </form>
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Browse</a></li>
                        <li><a href="#">Trending</a></li>
                    </ul>
                    <p class="navbar-text navbar-right">Welcome back, <a href="#" class="navbar-link">Jurgen</a></p>
                </div>
            </div>
        </nav>
    </div>
    <div id="contentUI" ui-view="content" class="container">
        <carousel></carousel>
    </div>
</div>

</body>
</html>