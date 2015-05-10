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

            // Render controller with mocked data
            $controller('SeriesCtrl', { $scope : scope, seriesFactory : loadMockedSeriesFactory($q), AuthenticationService : loadMockedAuthService() });

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

        scope.$digest();

        expect(scope.series.season_object[1].unseen).toEqual('0');
        expect(scope.series.season_object[2].unseen).toEqual('0');
        expect(scope.series.season_object[3].unseen).toEqual('0');
        expect(scope.series.season_object[4].unseen).toEqual('0');
        expect(scope.series.season_object[5].unseen).toEqual('0');
        expect(scope.series.season_object[6].unseen).toEqual('0');

    });


});