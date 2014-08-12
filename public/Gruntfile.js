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
            'css/admin_global.css': 'scss/admin_global.scss',
            'css/facebox.css': 'scss/facebox.scss',
            'css/global-mobile.css': 'scss/global-mobile.scss',
            'css/jquery.autocomplete.css': 'scss/jquery.autocomplete.scss',
            'css/reset-fonts-grids.css': 'scss/reset-fonts-grids.scss',
            }
        }
    },

    uglify: {
        options: {
            banner: ''
        },
        target_1: {
                    // Add files here when we implemented angular
                    src: ['js/global.js'],
                    dest: 'js/global.min.js'
                }
            },

        jshint: {
          // add all the mega files when we have them
          files: ['js/mobile.js'],
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
            // Can add this to some amazing build script for production
            // uglify: {
            //  files: ['js/*.js'],
            //  tasks: ['uglify']
            // },
            livereload: {
                options: {
                    livereload: true
                },
                files: [
                '../app/views/*.php',
                'css/*.css',
                'js/*.js'
                ]
            },
            jshint: {
                // add all the mega files when we have them
                files: ['js/mobile.js'],
                tasks: ['jshint'],
            }
        }

    });

grunt.loadNpmTasks('grunt-contrib-sass');
grunt.loadNpmTasks('grunt-contrib-jshint');
grunt.loadNpmTasks('grunt-contrib-uglify');
grunt.loadNpmTasks('grunt-contrib-watch');

    //Default tasks to run when you type 'grunt'
    grunt.registerTask('default', ['sass', 'uglify', 'jshint']);

};