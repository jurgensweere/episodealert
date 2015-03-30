[![Build Status](https://api.travis-ci.org/castor385/episodealert.svg)]


## Episode Alert source

The website: [Episode-Alert](http://www.episode-alert.com).

## Installation

### Prerequisites fronttend
* [Node](http://nodejs.org/)
* [Git](http://git-scm.com/downloads)
* [Bower](http://bower.io/)
* [Ruby](https://www.ruby-lang.org/en/)
* [Grunt](http://gruntjs.com/)
* [Compass](http://compass-style.org/)

### Prerequisites backend:
* [PHP]
* [MySQL] and create a database and configure it in laravel
* [Composer](https://getcomposer.org/)

### Installation for backend laravel ( execute in / )
```
  config /app/config/local/app.php
  composer update
  php artisan migrate
```
### Installation for frontend ( execute in /public )

```
  npm install -g grunt-cli
  gem install sass compass
  bower install
  nmp install (Or 'npm install --no-bin-links' if it doenst work on vagrant)
  grunt build or gulp build
```

### Running the test

```
  npm install karma-cli -g
  to run e2e tests configure karma.e2e.conf.js to use the proper url of application
  karma start test/karma.e2e.conf.js
  karma start test/karma.unit.conf.js
```

### Work

```

  'grunt watch' to watch for changes -or-
  'gulp watch' to watch for changes
  'php artisan serve' to start a webserver in root of the project (or you can install apache)
  'php artisan series:update'  to start fetching series
  'php artisan sitemap:generate' generate a sitemap
  'php artisan mailer:batch' to send alert emails
```

