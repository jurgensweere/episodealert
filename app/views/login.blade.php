@extends('layouts.login')

@section('content')
<h1>Login</h1>

<div class="local">
	<h2>Login with your Episode-Alert account</h2>
	{{--  echo $this->form --}}
	<p>{{ HTML::link("login/register", "Register") }} for an Episode-Alert.com account.</p>
</div>

<div class="federated">
	<h2>Login using third-party accounts</h2>
	<!-- Federated logins -->
	<a href="/login/google"><span class="federated-button google">Google</span></a>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('div.federated a').each(
	function(){ 
		var href = $(this).attr('href'); 
		$(this).removeAttr('href');
		$(this).click(function(){parent.window.location.href=href})
	});
});
</script>

@stop