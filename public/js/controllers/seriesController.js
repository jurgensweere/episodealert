(function(){

    angular.module('eaApp').controller('SeriesCtrl',
        function($scope, $routeParams, seriesFactory) {

			/* declaration */
			var unique_name = $routeParams.seriesname;

			/* Execute on load */
			var loadProfileSeries = getSeries(unique_name);

			loadProfileSeries.success(function(series){

   				$scope.series = series;
   				$scope.seasons = buildSeasonObject(series.season_amount, series.has_specials);

			});

			//watcher to check if the initial episodes have been loaded
			$scope.$watch('episodesDoneLoading',function() {
			    if($scope.series){

					var loadUnseen = getUnseenAmountBySeries($scope.series.id, $scope.series.season_amount);
	   				loadUnseen.success(function(unseen){
	   					for( var i = 0; i < unseen.length; i++){
	   						$scope.seasons[i].unseen = unseen[i];
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
	    		console.log('getUnseenAmountBySeries');
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

				console.log(' build season object ');
        
				var seasons = [];

				if(hasSpecials){
					seasons.push({ number : 0, title : 'Specials', active : false, unseen : null });
				}else{
					seasons.push({ number : 0, title : 'Specials', active : false, unseen : null, disabled: true });
				}

				for (var i = 1; i <= numberOfSeasons; i++) {
					seasons.push( { number : i, title : i, active : false, unseen : null } );
				}

        		seasons[seasons.length-1].active = true;

				return seasons;
			 }

      }
    );
})();