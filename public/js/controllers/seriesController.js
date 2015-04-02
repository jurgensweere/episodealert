	(function () {

    angular.module('eaApp').controller('SeriesCtrl',
        function($scope, $routeParams, $filter, seriesFactory, AuthenticationService, Page) {

			/* declaration */
			var unique_name = $routeParams.seriesname;

			/* Execute on load */
            var authorized = AuthenticationService.isLoggedIn();
            var series = seriesFactory.getSeriesDetail(unique_name);

            series.then(function(series) {

                Page.setTitle(series.name + ' | Episode Alert');
        		Page.setMetaDescription('Find the latest on ' + series.name + ', including season and episode information.');
                Page.setImage(window.location.origin + "/" + series.poster_image);

                $scope.series = series;
            });

			//watcher to check if the initial episodes have been loaded
			$scope.$watch('episodesDoneLoading',function() {
			    if($scope.series && authorized){

                    if($scope.series.has_specials){
                        $scope.series.season_amount = $scope.series.season_amount - 1;
                    }
					var loadUnseen = getUnseenAmountBySeries($scope.series.id, $scope.series.season_amount);
	   				loadUnseen.success(function(unseen){
	   					for( var i = 0; i < unseen.length; i++){
	   						var index = i + 1;
	   						//$scope.series.has_specials ? i + 1 : i;
	   						$scope.series.season_object[index].unseen = unseen[i];
	   					}
	   				});

			    }
			});

			/* scope */
			$scope.loadSeason = function(series_id, seasonNumber){
                var episodes = getEpisodesBySeason(series_id, seasonNumber);
                console.log('loadSeason');
                
                episodes.then(function(data){
                    console.log('then wot mate');    
                })
                 
                episodes.error(function(){
                    console.log('error');
                })
                
  				episodes.success(function(episodes){
                    
                    console.log('success!!!!');
					$scope.series.season_object[seasonNumber].content = episodes;
					$scope.episodesDoneLoading = true;
				});
                
			};

	    	/* service calls */
	    	function getUnseenAmountBySeries(series_id, seasonsAmount){
	    		var unseenBySeries = seriesFactory.getUnseenSeasonsBySeries(series_id, seasonsAmount);
	    		return unseenBySeries;
	    	}

	    	function getEpisodesBySeason(series_id, seasonNumber){
	    		var episodesBySeason = seriesFactory.getEpisodesBySeason(series_id, seasonNumber);
	    		return episodesBySeason;
	    	}

      }
    );
})();