var gulp = require('gulp');
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var jshint = require('gulp-jshint');
var stylish = require('jshint-stylish');
var rename = require('gulp-rename');
var minifyCSS = require('gulp-minify-css');
var livereload = require('gulp-livereload');
var mainBowerFiles = require('main-bower-files');
var gulpFilter = require('gulp-filter');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var htmlreplace = require('gulp-html-replace');

var paths = {
  js: ['./js/**/*.js', '!./js/vendor/**/*.js', '!./js/**/*.min.js'],
  scss: './scss/global.scss',
  css: ['./css/*.css', '!./css/*.min.css'],
  html: ['../app/views/index.blade.php']
};

var environments = ['dev', 'beta', 'live'];

//Define runnable tasks
environments.forEach(function (environment) {
    gulp.task('default:' + environment, 
        ['watch:' + environment,
         'sass:' + environment,
         'jshint:' + environment]
    );

    gulp.task('sass:' + environment, function() {
        sassTask(environment);
    });

    gulp.task('jshint:' + environment, function() {
        jshintTask(environment);
    });

    gulp.task('watch:' + environment, function() {
        watchTask(environment);
    });

    gulp.task('build:' + environment,
        ['sass:' + environment,
         'jshint:' + environment]
        , function () {
            buildCssTask(environment);
            bowerConcatTask(environment);
            buildJsTask(environment);
            buildHtmlTask(environment);
        }
    );
});
// Define default fallback
gulp.task('default', ['default:dev']);
gulp.task('sass', ['sass:dev']);
gulp.task('jshint', ['jshint:dev']);
gulp.task('build', ['build:dev']);
gulp.task('watch', ['watch:dev']);

// Helper functions
var watchTask = function (env) {
    livereload.listen();
    gulp.watch(paths.js, ['jshint:' + env]);
    gulp.watch(paths.scss, ['sass:' + env]);
}

var sassTask = function (env) {
    gulp.src(paths.scss)
        .pipe(sass())
        .pipe(gulp.dest('./css'))
        .pipe(livereload());
};

var jshintTask = function(env) {
    gulp.src(paths.js)
        .pipe(jshint())
        .pipe(jshint.reporter('jshint-stylish'))
        .pipe(livereload());
};

var bowerConcatTask = function(env) {
    var jsFilter = gulpFilter('*.js');
    var cssFilter = gulpFilter('*.css');
    var fontFilter = gulpFilter(['*.eot', '*.woff', '*.woff2', '*.svg', '*.ttf']);

    var basepath = {
        'dev': '.',
        'beta': './dist/beta',
        'live': './dist/production',
    }
    
    gulp.src('./js/vendor/ui-bootstrap*.js')
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(basepath[env] + '/js/vendor'))

    gulp.src(mainBowerFiles())
        // Concat all js files
        .pipe(jsFilter)
        .pipe(concat('_bower.js'))
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(basepath[env] + '/js/vendor'))
        .pipe(jsFilter.restore())

        // Concat all css files
        .pipe(cssFilter)
        .pipe(concat('_bower.css'))
        .pipe(gulp.dest(basepath[env] + '/css/vendor'))
        .pipe(cssFilter.restore())

        // Copy fonts
        .pipe(fontFilter)
        .pipe(gulp.dest(basepath[env] + '/fonts/bootstrap'));

        if (env == 'live') {
            gulp.src('./templates/**')
                .pipe(gulp.dest(basepath[env] + '/templates'));
        }
};

var buildHtmlTask = function (env) {
    var path = {
        'dev': './dist/local/',
        'beta': './dist/beta/',
        'live': './dist/production/',
    }
    
    gulp.src(paths.html)
        .pipe(htmlreplace({
            'js' : '/dist/' + env + '/js/ea.min.js',
            'libs' : ['/dist/' + env + '/js/vendor/_bower.min.js',
                     '/dist/' + env + '/js/vendor/ui-bootstrap-0.12.0.min.js']
        }))
        .pipe(gulp.dest(path[env]));
    
};

var buildCssTask = function (env) {
    var path = {
        'dev': './dist/local/css',
        'beta': './dist/beta/css',
        'live': './dist/production/css',
    }

    gulp.src(paths.css)
        .pipe(minifyCSS({ keepBreaks: true }))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(path[env]));
};

var buildJsTask = function (env) {
    var path = {
        'dev': './dist/js',
        'beta': './dist/beta/js',
        'live': './dist/production/js',
    }

    gulp.src(paths.js)
        .pipe(concat('ea.js'))
        .pipe(uglify({mangle: false}))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(path[env]));
};
