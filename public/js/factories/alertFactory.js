angular.module('eaApp').factory('alertService', ['$timeout', function($timeout) {

  var alerts = [];
  var alertFactory = {};

  alertFactory.add = function(msg, options) {

      var type = options.type || 'warning';
      var location = options.location || 'toast';
      var time = options.time || 5000;

      $timeout(function(){
        alerts.splice(alerts.indexOf(alert), 1);
      }, time);

      return alerts.push({
          type: type,
          location : location,
          msg: msg,
          close: function() {
              return alertFactory.closeAlert(this);
          }
      });
  };

  alertFactory.closeAlert = function(alert) {
    return alertFactory.closeAlertIdx(alerts.indexOf(alert));
  };

  alertFactory.closeAlertIdx = function(index) {
      return alerts.splice(index, 1);
  };

  alertFactory.clear = function(){
      alerts = [];
  };

  alertFactory.get = function() {
      return alerts;
  };

  return alertFactory;

}]);