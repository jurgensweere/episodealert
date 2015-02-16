module.exports = function (grunt) {

    // 1. All configuration goes here
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // Configuration for the Sass task
        sass: {
            local: {
                options: {
                    style: 'uncompressed',
                    precision: 8,
                },

                //TODO These files should be combined and minified etc.
                files: {
                    'css/global.css': 'scss/global.scss'
                }
            },
            production: {
                options: {
                    style: 'uncompressed',
                    precision: 8,
                },

                //TODO These files should be combined and minified etc.
                files: {
                    'css/global.css': 'scss/global.scss'
                }
            },
        },

        concat: {
            options: {
                separator: ';',
            },
            local: {
                src: ['js/app.js', 'js/controllers/*.js', 'js/factories/*.js', 'js/services/*.js', 'js/directives/*.js', 'js/modules/*.js', 'js/modules/*.js'],
                dest: 'dist/production/js/ea.js',
            },
            production: {
                src: ['js/app.js', 'js/controllers/*.js', 'js/factories/*.js', 'js/services/*.js', 'js/directives/*.js', 'js/modules/*.js', 'js/modules/*.js'],
                dest: 'dist/production/js/ea.js',
            },
        },

        uglify: {
            options: {
                banner: ''
            },
            local: {
                src: ['dist/js/ea.js'],
                dest: 'dist/js/ea.min.js'
            },
            production: {
                src: ['dist/js/ea.js'],
                dest: 'dist/production/js/ea.min.js'
            }
        },

        jshint: {
            options: {
                globals: {
                    jQuery: true,
                    console: true,
                    module: true
                }
            },
            local: ['js/app.js', 'js/controllers/*.js', 'js/factories/*.js', 'js/services/*.js', 'js/directives/*.js', 'js/modules/*.js', 'js/modules/*.js']
        },

        cssmin: {
            local: {
                files: [{
                  expand: true,
                  cwd: 'css',
                  src: ['*.css', '!*.min.css'],
                  dest: 'dist/local/css',
                  ext: '.min.css'
                }]
            },
            production: {
                files: [{
                  expand: true,
                  cwd: 'css',
                  src: ['*.css', '!*.min.css'],
                  dest: 'dist/production/css',
                  ext: '.min.css'
                }]
            }
        },

        bower_concat: {
            local: {
                dest: 'js/vendor/_bower.js',
                cssDest: 'css/vendor/_bower.css',
                exclude: [],
                dependencies: {

                },
                bowerOptions: {
                    relative: false
                }
            },
            production: {
                dest: 'dist/production/js/vendor/_bower.js',
                cssDest: 'dist/production/css/vendor/_bower.css',
                exclude: [],
                dependencies: {

                },
                bowerOptions: {
                    relative: false
                }
            }
        },

        copy: {
            local: {
                files: [{
                        expand: true,
                        cwd: 'bower_components/bootstrap-sass/assets/fonts',
                        src: ['**'],
                        dest: 'fonts/'
                    },
                ],
            },
            production: {
                files: [{
                        expand: true,
                        cwd: 'bower_components/bootstrap-sass/assets/fonts',
                        src: ['**'],
                        dest: 'dist/production/fonts/'
                    },
                    {
                        expand: true,
                        cwd: 'templates',
                        src: ['**'],
                        dest: 'dist/production/templates/'
                    },
                    {
                        expand: true,
                        cwd: 'js/vendor/',
                        src: ['ui-bootstrap*.js'],
                        dest: 'dist/production/js/vendor/'
                    }                    
                ]
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
            'js/modules/*.js',
            'templates/*.html',
            'templates/partial/*.html'
            ]
            },
            jshint: {
                // add all the mega files when we have them
                files: ['js/*.js', 'js/controllers/*.js', 'js/factories/*.js', 'js/modules/*.js'],
                tasks: ['jshint'],
            }
        }

    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-bower-concat');

    var target = grunt.option('target') || 'local';
    //Default tasks to run when you type 'grunt'
    grunt.registerTask('default', ['sass', 'jshint']);
    //building for local
    //grunt.registerTask('build', ['sass', 'cssmin', 'jshint', 'concat', 'uglify', 'bower_concat', 'copy'])
    //building for production
    //example : 'grunt build --target=production' || 'grunt build' (default local)
    grunt.registerTask('build', ['jshint', 'sass:' + target, 'cssmin:' + target, 'concat:' + target,
                                 'uglify:' + target, 'bower_concat:' + target, 'copy:' + target]);
};