function loadMockedSeriesFactory($q){
    return{
        getEpisodesBySeason : function(){
            var deferred = $q.defer();
            deferred.resolve(seriesDetailEpisodeList);
            return deferred.promise;
        },

        getUnseenSeasonsBySeries : function (){
            var deferred = $q.defer();
            deferred.resolve(seriesDetailTestUnseenAmount);
            return deferred.promise;
        },

        getSeriesDetail : function(unique_name) {
            var deferred = $q.defer();
            deferred.resolve(seriesDetailTestData);
            return deferred.promise;
        },

        getByGenre : function(genre, skip){
            var deffered = $q.defer();
            deffered.resolve(seriesBrowseSeriesList);
            return deffered.promise;
        }
    }
}

function loadMockedAuthService(){
    return{
        isLoggedIn : function(){
            return true;
        }
    }
}
