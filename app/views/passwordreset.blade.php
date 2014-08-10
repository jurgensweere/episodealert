@extends('layouts.login')

@section('content')
<div>
	{{ Form::open(array('url' => 'login/passwordreset')) }}
		<dl>
			<dt id="email-label">
				{{ Form::label('email', 'Email:', array('class' => 'required')) }}
			</dt>
			<dd id="email-element">
				{{ Form::email('email') }}
			</dd>
			<dt id="passwordreset-label">&nbsp;</dt>
			<dd id="passwordreset-element">
				{{ Form::submit('Reset Password') }}
			</dd>
		</dl>
	{{ Form::close() }}

	@if (isset($message))
	    <div class="message {{ $message['type'] }}">
	       <span></span>
	       {{ $message['text'] }}
	    </div>
	@endif
</div>

@stop
