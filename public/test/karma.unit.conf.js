// Karma configuration
// Generated on Tue Mar 24 2015 15:23:19 GMT+0100 (West-Europa (standaardtijd))

module.exports = function(config) {
  config.set({

    // base path that will be used to resolve all patterns (eg. files, exclude)
    basePath: '',


    // frameworks to use
    // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
    frameworks: ['jasmine'],


    // list of files / patterns to load in the browser
    files: [
        //frameworks files / test tools
        'http://ajax.googleapis.com/ajax/libs/angularjs/1.3.0/angular.js',
        'http://ajax.googleapis.com/ajax/libs/angularjs/1.3.0/angular-animate.js',
        'http://ajax.googleapis.com/ajax/libs/angularjs/1.3.0/angular-touch.js',
        'http://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.14/angular-ui-router.min.js',


        'https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.0/angular-mocks.js',

        //project files
        '../js/*.js',
        '../js/**/*.js',

        //test data
        'unit/testdata/**/*.js',

        //tests
        'unit/**/*.js'
    ],


    // list of files to exclude
    exclude: [
    ],


    // preprocess matching files before serving them to the browser
    // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
    preprocessors: {
    },

    // Sometimes phantomJS is randomly super slow, to not have the test crash increase the timeout
    captureTimeout: 60000,
    browserNoActivityTimeout : 60000,

    // test results reporter to use
    // possible values: 'dots', 'progress'
    // available reporters: https://npmjs.org/browse/keyword/karma-reporter
    reporters: ['progress'],


    // web server port
    port: 9876,


    // enable / disable colors in the output (reporters and logs)
    colors: true,


    // level of logging
    // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
    logLevel: config.LOG_INFO,


    // enable / disable watching file and executing tests whenever any file changes
    autoWatch: true,

    // start these browsers
    // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
    browsers: ['PhantomJS'],
    //browsers: ['Chrome, Firefox'],

    // Continuous Integration mode
    // if true, Karma captures browsers, runs the tests and exits
    singleRun: false
  });
};
