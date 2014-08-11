<!doctype html>
<html lang="en" ng-app="episodeAlert">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Episode Alert</title>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/global.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>



</head>
<!-- declare our angular app and controller -->
<body>
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
        <div class="splash-brand">
                <p>episode alert <img src="img/logo-71x50.png" alt="Episode Alert" /></p>
        </div>
        <div class="splash-fanart">
            <span class="splash-fanart-fade"></span>
                
            <div class="row marketing">
                <div class="col-lg-4">
                    <h1>Follow</h1>
                    <p>Find your favorite<br/>TV Series</p>
                </div>
                <div class="col-lg-4">
                    <h1>Get Notified</h1>
                    <p>Receive email<br/>notifications</p>
                </div>
                <div class="col-lg-4">
                    <h1>Keep Track</h1>
                    <p>Remember episodes<br/>you've seen</p>
                </div>
            </div>

            <div class="splash-posters">
                <div class="series">
                    <img class="poster" src="img/poster/70327.jpg" alt="Buffy the Vampire Slayer"/>
                    <span class="inactive"></span>
                </div><div class="series">
                    <img class="poster" src="img/poster/73739.jpg" alt="Lost"/>
                    <span class="inactive"></span>
                </div><div class="series">
                    <img class="poster" src="img/poster/76290.jpg" alt="24"/>
                    <span class="inactive"></span>
                </div><div class="series">
                    <img class="poster" src="img/poster/108611.jpg" alt="White Collar"/>
                    <span class="active"></span>
                </div><div class="series">
                    <img class="poster" src="img/poster/153021.jpg" alt="The Walking Dead"/>
                    <span class="inactive"></span>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>