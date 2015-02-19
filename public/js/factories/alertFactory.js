angular.module('eaApp').factory('alertService', ['$timeout', function($timeout) {
 
  var alerts = [];
  var alertFactory = {};
 
  alertFactory.add = function(type, msg) {
      $timeout(function(){
        alerts.splice(alerts.indexOf(alert), 1);
      }, 8000); 

      return alerts.push({
          type: type,
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