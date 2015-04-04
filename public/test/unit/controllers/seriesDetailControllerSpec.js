describe('Series Controller', function () {
    var scope, ctrl;

    beforeEach(module('eaApp'));

    beforeEach(function () {


        // Inject the angular services
        inject(function ($controller, $httpBackend, $rootScope, $q) {

            // Fake login
            $httpBackend.expect('GET', 'api/auth/check')
                .respond(200, '[{"id":2,"accountname":"arnobats@gmail.com","thirdparty":false}]')

            scope = $rootScope.$new();

            var mockedAuthService = {
                isLoggedIn : function(){
                    return true;
                }
            }

            //Mocked series factory
            var mockedSeriesFactory = {

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
                }

            };

            $controller('SeriesCtrl', { $scope : scope, seriesFactory : mockedSeriesFactory, AuthenticationService : mockedAuthService });

        });
    });

    it('Should load the series Lost', function () {

        scope.$digest();

        expect(scope.series.season_object[6].active).toEqual(true);
        expect(scope.series.name).toEqual('Lost');

    });


    it('Should load the episode list for season 6', function () {

        scope.loadSeason(73739, 6);

        scope.$digest();

        expect(scope.series.season_object[0].content).toBeUndefined();
        expect(scope.series.season_object[1].content).toBeUndefined();
        expect(scope.series.season_object[2].content).toBeUndefined();
        expect(scope.series.season_object[3].content).toBeUndefined();
        expect(scope.series.season_object[4].content).toBeUndefined();
        expect(scope.series.season_object[5].content).toBeUndefined();
        expect(scope.series.season_object[6].content.length).toEqual(18);

    });


    it('Should have 0 unseen episodes', function () {
        // baby jeebus why is this randomly failing

        scope.$apply();
        scope.$digest();

        expect(scope.series.season_object[1].unseen).toEqual('0');
        expect(scope.series.season_object[2].unseen).toEqual('0');
        expect(scope.series.season_object[3].unseen).toEqual('0');
        expect(scope.series.season_object[4].unseen).toEqual('0');
        expect(scope.series.season_object[5].unseen).toEqual('0');
        expect(scope.series.season_object[6].unseen).toEqual('0');

    });


});