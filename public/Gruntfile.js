module.exports = function(grunt) {

// 1. All configuration goes here
grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // Configuration for the Sass task
    sass: {
        dist: {
            options: {
                style: 'uncompressed'
            },

            //TODO These files should be combined and minified etc.
            files: {
            'css/global.css': 'scss/global.scss',
            'css/globalv2.css': 'scss/globalv2.scss'
            }
        }
    },

    concat: {
        options: {
            separator: ';',
        },
        dist: {
            src: ['js/*.js', 'js/controllers/*.js', 'js/factories/*.js'],
            dest: 'dist/js/ea.js',
        },
    },

    uglify: {
        options: {
            banner: ''
        },
        target_1: {
            src: ['dist/js/ea.js'],
            dest: 'dist/js/ea.min.js'
        }
    },

    jshint: {
      files: ['js/app.js', 'js/controllers/*.js', 'js/factories/*.js'],
          options: {
            globals: {
                jQuery: true,
                console: true,
                module: true
            }
        }
    },

    watch: {
        sass: {
            files: ['scss/*.scss'],
            tasks: ['sass'],
        },
        livereload: {
            options: {
                livereload: true
            },
            files: [
            '../app/views/*.php',
            'css/*.css',
            'js/*.js',
            'js/controllers/*.js',
            'js/factories/*.js',
            'templates/*.html'
            ]
        },
        jshint: {
            // add all the mega files when we have them
            files: ['js/*.js', 'js/controllers/*.js', 'js/factories/*.js'],
            tasks: ['jshint'],
        }
    },

    cssmin: {
      minify: {
        expand: true,
        src: ['css/global.css'],
        src: ['css/globalv2.css'],
        dest: 'dist/',
        ext: '.min.css'
      }
    }

    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    //Default tasks to run when you type 'grunt'
    grunt.registerTask('default', ['sass', 'jshint']);

    //building for production/testing
    grunt.registerTask('build', ['sass', 'cssmin', 'jshint', 'concat', 'uglify'])
};