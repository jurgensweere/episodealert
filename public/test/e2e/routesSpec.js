describe("E2E: Testing Routes", function() {

  beforeEach(function() {
    browser().navigateTo('/');
  });

  it('should have a working /trending route', function() {
    browser().navigateTo('/trending');
    expect(browser().location().path()).toBe('/trending');
  }); 

  it('should have a working /browse route', function() {
    browser().navigateTo('/series/genre/action');
    expect(browser().location().path()).toBe('/series/genre/action');
  }); 

  it('should have a working /contact route', function() {
    browser().navigateTo('/contact');
    expect(browser().location().path()).toBe('/contact');
  });     
    
  it('should have a working /privacy route', function() {
    browser().navigateTo('/privacy');
    expect(browser().location().path()).toBe('/privacy');
  });         
    
  it('should have a working /login route', function() {
    browser().navigateTo('/login');
    expect(browser().location().path()).toBe('/login');
  });         
    
  it('should have a working /register route', function() {
    browser().navigateTo('/register');
    expect(browser().location().path()).toBe('/register');
  });        
    
  it('should have a working /passwordreset route', function() {
    browser().navigateTo('/passwordreset');
    expect(browser().location().path()).toBe('/passwordreset');
  });            
    
});