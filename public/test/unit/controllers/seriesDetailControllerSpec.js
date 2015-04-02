describe('MyCtrl', function () {

    var scope, ctrl;

    beforeEach(module('eaApp'));

    beforeEach(inject(function ($controller, $rootScope, $httpBackend, $q) {
        q = $q;
        rootScope = $rootScope;
        httpBackend = $httpBackend;
        scope = $rootScope.$new();
        ctrl = $controller('SeriesCtrl', {
            $scope: scope,
            $routeParams: {seriesname: 'lost'}
        });
        
        // Fake login
        $httpBackend.expect('GET', 'api/auth/check')
                .respond(200, '[{"id":2,"accountname":"arnobats@gmail.com","thirdparty":false}]')        
        

    }));

    it('test things in series controller', function () {
        httpBackend.expect('GET', '/api/series/lost').respond(200, seriesDetailTestData);        
    
        httpBackend.flush();        
        //console.log(scope.series);
        
        httpBackend.expect('GET', '/api/series/episodesbyseason/73739/1').respond(200, seriesDetailEpisodeList);
        var deferred = q.defer();
        spyOn(scope, "loadSeason").and.returnValue(deferred.promise);
        
        scope.loadSeason(73739, 1);
        deferred.reject({});        
        //var deferredSuccess = q.defer();
        //spyOn(scope, 'loadSeason').andReturn(deferredSuccess.promise);   
        
        expect(scope.loadSeason).toHaveBeenCalled();        
        expect(scope.episodesDoneLoading).toBe(1);
         
        scope.$digest();
        //scope.$apply();
        //rootScope.$digest();
        //rootScope.$apply();
    });

});