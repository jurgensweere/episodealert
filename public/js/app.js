(function(){
	var app = angular.module('eaApp', []);

	app.directive("carousel", function() {
		return {
			restrict: 'E',
			templateUrl: 'carousel.html',
			controller: ['$http', function($http) {
				var carousel = this;
				carousel.series = [];

				$http.get('/api/series/top').success(function(data) {
					carousel.series = data;
				});
			}],
			controllerAs: 'carousel'
		};
	});
})();