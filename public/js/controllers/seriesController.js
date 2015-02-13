	(function () {
    
    angular.module('eaApp').controller('SeriesCtrl',
        function($scope, $routeParams, seriesFactory, Page) {

			/* declaration */
			var unique_name = $routeParams.seriesname;

			/* Execute on load */
			var loadProfileSeries = getSeries(unique_name);

			loadProfileSeries.success(function(series){

        		Page.setTitle(series.name + ' | Episode Alert');
        		Page.setMetaDescription('Find the latest on ' + series.name + ', including season and episode information.');

   				$scope.series = series;
   				$scope.seasons = buildSeasonObject(series.season_amount, series.has_specials);

			});

			//watcher to check if the initial episodes have been loaded
			$scope.$watch('episodesDoneLoading',function() {
			    if($scope.series){

					var loadUnseen = getUnseenAmountBySeries($scope.series.id, $scope.series.season_amount);
	   				loadUnseen.success(function(unseen){
	   					for( var i = 0; i < unseen.length; i++){
	   						var index = i + 1; 
	   						//$scope.series.has_specials ? i + 1 : i;
	   						$scope.seasons[index].unseen = unseen[i];
	   					}
	   				});			    	

			    }
			});

			/* scope */
			$scope.loadSeason = function(series_id, seasonNumber){
        		var episodes = getEpisodesBySeason(series_id, seasonNumber);

  				episodes.success(function(episodes){
					$scope.seasons[seasonNumber].content = episodes;
					$scope.episodesDoneLoading = true;
				});
			};

	    	/* service calls */
		  	function getSeries(unique_name) {
	        	var series = seriesFactory.getSeries(unique_name);
	        	return series;
	    	}

	    	function getUnseenAmountBySeason(series_id, seasonNumber){
	    		var unseenBySeries = seriesFactory.getUnseenAmountBySeason(series_id, seasonNumber);
	    		return unseenBySeries;
	    	}

	    	function getUnseenAmountBySeries(series_id, seasonsAmount){
	    		var unseenBySeries = seriesFactory.getUnseenSeasonsBySeries(series_id, seasonsAmount);
	    		return unseenBySeries;
	    	}	    	

	    	function getEpisodesBySeason(series_id, seasonNumber){
	    		var episodesBySeason = seriesFactory.getEpisodesBySeason(series_id, seasonNumber);

	    		return episodesBySeason;
	    	}

			function getEpisodes(id){
				seriesFactory.getEpisodes(id)
					.success(function (episodes){
						$scope.episodes = episodes;
					})
					.error(function (error){
						//stuff
					}
				);
			}

			/* functions */
			function buildSeasonObject(numberOfSeasons, hasSpecials){
        
				var seasons = [];

				if(hasSpecials){
					seasons.push({ number : 0, title : 'Specials', active : false, unseen : 999 });
				}else{
					seasons.push({ number : 0, title : 'Specials', active : false, unseen : 999, disabled: true });
				}

				for (var i = 1; i <= numberOfSeasons; i++) {
					seasons.push( { number : i, title : i, active : false, unseen : 999 } );
				}

        		seasons[seasons.length-1].active = true;

				return seasons;
			 }

      }
    );
})();