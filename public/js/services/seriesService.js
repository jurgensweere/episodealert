//service example, at the moment i like the factory way better

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
