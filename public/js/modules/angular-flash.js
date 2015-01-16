angular.module('flash', [])
    .factory('flash', ['$rootScope', '$timeout', function($rootScope, $timeout) {
        var messages = [];

        var reset;
        /** Stop timers */
        var cleanup = function() {
            $timeout.cancel(reset);
            reset = $timeout(function() { messages = []; });
        };

        /** Notify Listeners */
        var emit = function() {
            $rootScope.$emit('flash:message', messages, cleanup);
        };

        $rootScope.$on('$locationChangeSuccess', emit);

        /** Convert to message */
        var asMessage = function(level, text) {
            if (!text) {
                text = level;
                level = 'success';
            }
            return { level: level, text: text };
        };

        /** Convert to array of messages (if needed) */
        var asArrayOfMessages = function(level, text) {
            if (level instanceof Array) {
                return level.map(function(message) {
                    return message.text ? message : asMessage(message);
                });
            }
            return text ? [{ level: level, text: text }] : [asMessage(level)];
        };

        /** Show message or messages */
        var flash = function(level, text) {
            emit(messages = asArrayOfMessages(level, text));
        };

        ['danger', 'warning', 'info', 'success'].forEach(function (level) {
            flash[level] = function (text) { flash(level, text); };
        });

        return flash;
    }])
    .directive('flashMessages', [function() {
        var directive = { restrict: 'EA', replace: true };
        directive.template =
            '<ol id="flash-messages">' +
            '<li ng-repeat="m in messages" class="alert alert-{{m.level}}">{{m.text}}</li>' +
            '</ol>';

        directive.controller = ['$scope', '$rootScope', function($scope, $rootScope) {
            // Listen to flash:message
            $rootScope.$on('flash:message', function(_, messages, done) {
                $scope.messages = messages;
                done();
            });
        }];
        
        return directive;
    }]);