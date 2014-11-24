//service example, unused -- Use factory instead

angular.module('eaApp').service('seriesService', function($http) {
   return {
     getTopSeries: function(callback) {
       $http.get('/api/series/top').success(callback);
     },

     seriesSearch: function(query, callback) {
       $http.get('/api/series/search/' + query).success(callback);
     }
   }
});
