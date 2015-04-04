describe("E2E: Testing Pages", function(seriesFactory) {
    
    beforeEach(module('eaApp'));

    it("Should check if the seriesFactory returns a proper series",
      inject(function(seriesFactory, $httpBackend) {
        
        // Fake login
        $httpBackend.expect('GET', 'api/auth/check')
                .respond(200, '[{"id":2,"accountname":"arnobats@gmail.com","thirdparty":false}]')        

        $httpBackend.flush();
    
        $httpBackend.expect('GET', '/api/series/lost')
            .respond(200, factorySeriesDetailTestData);

        // Call the service 
     
        var series = seriesFactory.getSeriesDetail('lost');
        
        // Check all the values of the series returned
        series.then(function(series){

            expect(series.id).toBe(73739);
            expect(series.unique_name).toBe('lost');
            expect(series.name).toBe('Lost');  
            expect(series.description).toBe('After their plane, Oceanic Air flight 815, tore apart whilst thousands of miles off course, the survivors find themselves on a mysterious deserted island where they soon find out they are not alone.');
            expect(series.firstaired).toBe('2004-09-22');
            expect(series.rating).toBe('9.1');
            expect(series.rating_updated).toBe('0000-00-00 00:00:00');
            expect(series.imdb_id).toBe('tt0411008');
            expect(series.poster_image).toBe('img/poster/lo/lost_large.jpg');               
            expect(series.poster_image_converted).toBe(true);
            expect(series.fanart_image).toBe('lost.jpg');
            expect(series.fanart_image_converted).toBe(true);
            expect(series.banner_image).toBe('img/banner/lo/lost.jpg');              
            expect(series.banner_image_converted).toBe(true);
            expect(series.category).toBe('|Action|Adventure|Drama|Science-Fiction|');
            expect(series.status).toBe('Ended');
            expect(series.popular).toBe(false);
            expect(series.trend).toBe(1);
            expect(series.season_amount).toBe(7);
            expect(series.episode_amount).toBe(120);
            expect(series.has_specials).toBe(true);
            expect(series.specials_amount).toBe(29);
            expect(series.created_at).toBe('2015-04-02 12:59:18');
            expect(series.updated_at).toBe('2015-04-02 12:59:44');
            expect(series.last_seen_season).toBe(6);
            expect(series.following).toBe(1);
            
        });
        
        $httpBackend.flush();
    }));
    
});

