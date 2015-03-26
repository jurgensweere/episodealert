describe("E2E: Testing Pages", function() {

  beforeEach(function() {
    browser().navigateTo('/');
  });

  it('should have a working /trending page', function() {
    browser().navigateTo('/trending');
      
    expect(browser().location().path()).toBe("/trending");
      
    expect(element('#contentUI').html()).toContain('episode alert');
    expect(element('.marketing').html()).toContain('<p>Find your favorite<br>TV Series</p>');
    expect(element('.marketing').html()).toContain('<p>Receive email<br>notifications</p>');
    expect(element('.marketing').html()).toContain('<p>Remember episodes<br>you\'ve seen</p>');      
  });



});