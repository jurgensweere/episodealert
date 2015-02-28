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

var paths = {
  js: ['./js/**/*.js', '!./js/vendor/**/*.js', '!./js/**/*.min.js'],
  scss: './scss/global.scss',
  css: ['./css/*.css', '!./css/*.min.css']
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

// TODO: simplify these paths, only change the base path.
    var path = {
        'js': {
            'dev': './js/vendor',
            'beta': './dist/beta/js/vendor',
            'live': './dist/production/js/vendor',
        },
        'css': {
            'dev': './css/vendor',
            'beta': './dist/beta/css/vendor',
            'live': './dist/production/css/vendor',
        },
        'font': {
            'dev': './fonts/bootstrap',
            'beta': './dist/beta/fonts/bootstrap',
            'live': './dist/production/fonts/bootstrap',
        },
    }

    // TODO: On live, we also want to copy these files, maybe this needs to be a seperate function?
    // cwd: 'templates',
    // src: ['**'],
    // dest: 'dist/production/templates/'

    // cwd: 'js/vendor/',
    // src: ['ui-bootstrap*.js'],
    // dest: 'dist/production/js/vendor/'

    gulp.src(mainBowerFiles())
        // Concat all js files
        .pipe(jsFilter)
        .pipe(concat('_bower.js'))
        .pipe(gulp.dest(path.js[env]))
        .pipe(jsFilter.restore())

        // Concat all css files
        .pipe(cssFilter)
        .pipe(concat('_bower.css'))
        .pipe(gulp.dest(path.css[env]))
        .pipe(cssFilter.restore())

        // Copy fonts
        .pipe(fontFilter)
        .pipe(gulp.dest(path.font[env])); // <-- check the path, or change it?
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

    //TODO: On live, we also want to uglify these:
    //'dist/production/js/vendor/_bower.min.js': 'dist/production/js/vendor/_bower.js',
    //'dist/production/js/vendor/ui-bootstrap-0.12.0.min.js': 'dist/production/js/vendor/ui-bootstrap-0.12.0.js',

    gulp.src(paths.js)
        .pipe(concat('ea.js'))
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest(path[env]));
};
