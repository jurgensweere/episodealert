var gulp = require('gulp');
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var jshint = require('gulp-jshint');
var stylish = require('jshint-stylish');
var rename = require('gulp-rename');
var minifyCSS = require('gulp-minify-css');
var livereload = require('gulp-livereload');

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

gulp.task('build', ['jshint', 'sass'], function () {
    gulp.src(paths.css)
        .pipe(minifyCSS({ keepBreaks: true }))
        .pipe(rename({
            suffix: '.min'
        }))
        .pipe(gulp.dest('./dist/local/css'));

    // concat bower components
    // copy bootstrap fonts from bower 
    // concat js into ea.js and uglify it

//'cssmin:local', 'bower_concat:local', 'copy:local', 'concat:local', 'uglify:local'


});

gulp.task('watch', function() {
    livereload.listen();
    gulp.watch(paths.js, ['jshint']);
    gulp.watch(paths.scss, ['sass']);
});

