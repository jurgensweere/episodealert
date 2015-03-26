describe("Unit: Testing Filters", function () {

    beforeEach(module('eaApp'));

    /*
     * Filter we use for adding leading zeros to create such things as 'S02E07'
     */
    it('should place leading zeros depending on the amount requested', inject(function ($filter) {

        var number = $filter('numberFixedLen')('3', '2');
        var numberTwoDigits = $filter('numberFixedLen')('11', '2');
        var numberThreeDigits = $filter('numberFixedLen')('333', '5');
        
        expect(number.length).toEqual(2);
        expect(number).toEqual('03');
        
        expect(numberTwoDigits.length).toEqual(2);
        expect(numberTwoDigits).toEqual('11');
        
        expect(numberThreeDigits.length).toEqual(5);
        expect(numberThreeDigits).toEqual('00333');         
       
    }));
    
    /*
     * Filter we use to create the url tot he poster image
     */
    it('should return a correct url to a poster', inject(function ($filter) {
        
        var smallPosterUrl = $filter('createImageUrl')('archer_(2009).jpg', 'archer_(2009)', 'small');
        var mediumPosterUrl = $filter('createImageUrl')('archer_(2009).jpg', 'archer_(2009)', 'medium');
        var largePosterUrl = $filter('createImageUrl')('archer_(2009).jpg', 'archer_(2009)', 'large');
        
        expect(smallPosterUrl).toEqual('img/poster/ar/archer_(2009)_small.jpg');
        expect(mediumPosterUrl).toEqual('img/poster/ar/archer_(2009)_medium.jpg');
        expect(largePosterUrl).toEqual('img/poster/ar/archer_(2009)_large.jpg');
        
    }));
    
    /*
     * Filter we use to create the url tot he banner image
     */
    it('should return a correct url to a banner', inject(function ($filter) {

        var bannerUrl = $filter('createBannerUrl')('homeland.jpg', 'homeland');

        expect(bannerUrl).toEqual('img/banner/ho/homeland.jpg');     
       
    }));
    
    
    /*
     * Filter we use to create the url tot he fanart image
     */
    it('should return a correct url to a fanart', inject(function ($filter) {
       
        var fanartUrl = $filter('createFanartUrl')('the_big_bang_theory.jpg', 'the_big_bang_theory');
        
        expect(fanartUrl).toEqual('img/fanart/th/the_big_bang_theory.jpg');        
       
    }));
    
    /*
     * Filter we use to set a greeting for a user
     */
    
    it('should return a correct greeting based on time and name', inject(function($filter, dateFilter){
        var date = new Date();

        var morningGreeting = $filter('greet')(date.setHours(1), 'Arno');
        var afternoonGreeting = $filter('greet')(date.setHours(16), 'Arno');
        var eveningGreeting = $filter('greet')(date.setHours(21), 'Arno');
        
        expect(morningGreeting).toEqual('Good Morning, Arno');
        expect(afternoonGreeting).toEqual('Good Afternoon, Arno');
        expect(eveningGreeting).toEqual('Good Evening, Arno');
        
    }));

   
});