@extends('layouts.master')

@section('content')
    <div id="frontpage">
    
    <div id="about">
        <div class="step">
            <h2>1.</h2><h3>Sign in with google</h3>
            <a rel="facebox" href="#login-frame" id="login-button"><img src="/images/step1.jpg" /></a>
            <ul>
                <li>Safe, using OpenID</li>
                <li>Fast, 10 seconds work</li>
            </ul>
        </div>            
        <div class="step">    
            <h2>2.</h2><h3>Follow your TV Shows</h3>
            <a rel="facebox" href="#login-frame" id="login-button"><img src="/images/step2.jpg" /></a>
            <ul>
                <li>Dashboard for all your shows!</li>
                <li>Receive new episode Alerts</li>
            </ul>        
        </div>        
        <div class="step">    
            <h2>3.</h2><h3>Download and mark as seen!</h3>
            <a rel="facebox" href="#login-frame" id="login-button"><img src="/images/step3.jpg" /></a>
            <ul>
                <li>Download the newest episodes</li>
                <li>Mark everything you have seen!</li>
            </ul>
        </div>
    </div>
    <a rel="facebox" href="#login-frame" class="btn">Start following your favorite TV Series now!</a>

    <div class="add" style="clear: both; text-align: center; padding:4px;">
        <script type="text/javascript"><!--
            google_ad_client = "ca-pub-1693483407702008";
            /* Episode Alert Banner */
            google_ad_slot = "9207581757";
            google_ad_width = 728;
            google_ad_height = 90;
            //-->
        </script>
        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
    </div>
    {{-- echo $this->partial('partials/RecommendationList.phtml', array('popular' => $this->popular)) --}}
</div>

@stop
