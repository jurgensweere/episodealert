<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" style="background: #fff;">
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
    </head>
    <body>
		<div id="login">
			@yield('content')
		</div>
    </body>
</html>
