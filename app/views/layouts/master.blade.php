<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
    <head>
        <title>@yield('title', 'Episode Alert')</title>
        <meta name="keywords" content="tv, series, episode, alert, Reality TV Shows, Comedy TV Shows, Old Television Shows, Reality TV, Comedy TV, TV Shows, Television Shows, Old TV Shows, Action/Adventure, Animation, Children, Comedy, Drama, Science-Fiction, Soap, Talk Shows, Popular Shows, TV Listings, CBS, NBC, Fox, HBO, ABC, CW" />
        <meta name="description" content="The best source for show and episode info. Keeping you up to date on the latest broadcasts" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Content-Language" content="en-US" />
        <meta name="ROBOTS" content="INDEX,FOLLOW" />
        <meta name="revisit-after" content="1 days" />
        <meta name="google-site-verification" content="5GvWEdt15VhVSobeHoj2s3uHlSfXmXAHSR2QaBdT9-Q" />
        <meta name="google-site-verification" content="MPe2KTLD52OxwqkQlv-WcEzxT9MhjsvApFR9kAhqYVw" />
        {{ HTML::style(asset('css/reset-fonts-grids.css')) }}
        {{ HTML::style(asset('css/global.css')) }}
        {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js') }}
        {{ HTML::style('//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/smoothness/jquery-ui.css')}}
        {{ HTML::script('//ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js') }}
        {{ HTML::script(asset('js/jquery.qtip-1.0.0-rc3.min.js')) }}
        {{ HTML::script(asset('js/global.js')) }}
        {{ HTML::script(asset('js/facebox.js')) }}
        {{ HTML::style('css/facebox.css') }}
    </head>
    <body>
        <div id="hd">
            <div id="hd-center">
                <a href="/">{{ HTML::image(asset('images/hd-logo.png'), 'Episode Alert!', array('title', 'Episode Alert!')) }}</a>
                <div class="navigation">
                    @section('navigation')
                    <ul class="navigation">
                        <li>
                            {{ HTML::link("series/browse", "Series", array('id' => 'menu-series')) }}
                        </li>
                        <li>
                            {{ HTML::link("about", "About", array('id' => 'menu-about')) }}
                        </li>
                    </ul>
                    {{-- echo $this->navigation()->menu()->renderMenu( null, array( 'minDepth' => 0, 'maxDepth' => 0 )); --}}
                    @show
                    <div class="searchform"> {{-- echo $this->seriesSearchForm --}}</div>
                </div>
                <div class="subnavigation">
                    @section('subnavigation')
                    {{-- echo $this->navigation()->menu()->renderMenu( null, array( 'minDepth' => 1, 'maxDepth' => null,'renderParents' => false, 'onlyActiveBranch' => true ) ); --}}
                    @show
                    <div id="loading">Loading...</div>
                </div>
                <div id="hd-login">
                    {{-- echo $this->profileLink() --}}
                </div>
            </div>
        </div>
        <div id="bd">
            <div id="bd-center">
                @yield('content')
            </div>
            
            <div id="ft">
                <div id="ft-copyright">
                    &copy; 2009 - {{ date("Y") }}
                </div>
                <div id="ft-navigation">
                    <a href="/contact">Contact</a> ::
                    <a href="/privacy">Privacy</a>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        //<![CDATA[ 
        var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
        document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
        //]]> </script>
        <script type="text/javascript">
        //<![CDATA[ 
        try {
        var pageTracker = _gat._getTracker("UA-12386450-1");
        pageTracker._trackPageview();
        } catch(err) {}
        //]]> </script>
        {{-- <script type="text/javascript">
        $(function(){
            $("#query").autocomplete({
                minLength: 0,
                delay:5,
                source: "/series/autocompletesearch",
                focus: function( event, ui ) {
                    $(this).val( ui.item.title );
                    return false;
                },
                select: function( event, ui ) {
                    $(this).val( ui.item.title );
                    return false;
                }
            }).data("autocomplete")._renderItem = function( ul, item ) {
                return $("<li></li>")
                    .data( "item.autocomplete", item )
                    .append( "<a>" + (item.img?"<img class='image' src='"+item.img+"' />":"") + "<span class='title'>" + item.title + "</span>" + "<div class='clear'></div></a>" )
                    .appendTo( ul );
            };
        });
        </script> --}}
        <div id="login-frame" style="display:none;"><iframe src="/login"></iframe></div>
    </body>
</html>

