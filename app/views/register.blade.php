@extends('layouts.login')

@section('content')
<div class="register">
	<h2>Create a New Account</h2>
	<p>Please check the form to complete the registration process.</p>

	{{ Form::model(new EA\models\User, array('url' => 'login/register')) }}
		<dl class="zend_form">
			<dt id="username-label">
				{{ Form::label('username', 'Account name:', array('class' => 'required')) }}
			</dt>
			<dd id="username-element">
				{{ Form::text('username') }}
				@if ($errors->has('username'))
					{{ $errors->first('username') }}
				@endif
			</dd>

			<dt id="email-label">
				{{ Form::label('email', 'E-mail:', array('class' => 'required')) }}
			</dt>
			<dd id="email-element">
				{{ Form::email('email') }}
				@if ($errors->has('email'))
					{{ $errors->first('email') }}
				@endif
			</dd>

			<dt id="password-label">
				{{ Form::label('password', 'Password:', array('class' => 'required')) }}
			</dt>
			<dd id="password-element">
				{{ Form::password('password') }}
				@if ($errors->has('password'))
					{{ $errors->first('password') }}
				@endif
			</dd>

			<dt id="password2-label">
				{{ Form::label('password_confirmation', 'Re-type password:', array('class' => 'required')) }}
			</dt>
			<dd id="password2-element">
				{{ Form::password('password_confirmation') }}
				@if ($errors->has('password_confirmation'))
					{{ $errors->first('password_confirmation') }}
				@endif
			</dd>

			<dt id="register-label">&nbsp;</dt>
			<dd id="register-element">{{ Form::submit('Register') }}</dd>
		</dl>
	{{ Form::close() }}
</div>

@stop
