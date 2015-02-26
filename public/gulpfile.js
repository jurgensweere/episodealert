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
  js: ['./js/**/*.js', '!./js/vendor/**/*.js'],
  scss: './scss/global.scss',
  css: ['./css/*.css', '!./css/*.min.css']
};

gulp.task('default', ['watch', 'sass', 'jshint']);

gulp.task('sass', function() {
    gulp.src(paths.scss)
        .pipe(sass())
        .pipe(gulp.dest('./css'))
        .pipe(livereload());
});

gulp.task('jshint', function() {
    gulp.src(paths.js)
        .pipe(jshint())
        .pipe(jshint.reporter('jshint-stylish'))
        .pipe(livereload());
});

function bowerConcat() {
    var jsFilter = gulpFilter('*.js');
    var cssFilter = gulpFilter('*.css');
    var fontFilter = gulpFilter(['*.eot', '*.woff', '*.woff2', '*.svg', '*.ttf']);

    gulp.src(mainBowerFiles())
        // Concat all js files
        .pipe(jsFilter)
        .pipe(concat('_bower.js'))
        .pipe(gulp.dest('./js/vendor'))
        .pipe(jsFilter.restore())

        // Concat all css files
        .pipe(cssFilter)
        .pipe(concat('_bower.css'))
        .pipe(gulp.dest('./css/vendor'))
        .pipe(cssFilter.restore())

        // Copy fonts
        .pipe(fontFilter)
        .pipe(gulp.dest('./fonts/bootstrap')); // <-- check the path, or change it?

};

gulp.task('build', ['jshint', 'sass'], function () {
    gulp.src(paths.css)
        .pipe(minifyCSS({ keepBreaks: true }))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./dist/local/css'));

    bowerConcat();

    gulp.src(paths.js)
        .pipe(concat('ea.js'))
        .pipe(uglify())
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./dist/js'));
});

gulp.task('watch', function() {
    livereload.listen();
    gulp.watch(paths.js, ['jshint']);
    gulp.watch(paths.scss, ['sass']);
});

