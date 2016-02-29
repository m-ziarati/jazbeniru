@extends('layouts.master')

@section('content')

{{ Form::open(['route' => 'seeker.step1.check']) }}
	<div class="field {{ $errors->has('name') ? 'has-error' : '' }}">
		<label class="control-label" for="name">name</label>
		{{ Form::text('name', null, ['class' => 'form-control require', 'id' => 'name']) }}
		<div class="error-message">{{ $errors->first('name') }}</div>
	</div>

	<div class="field {{ $errors->has('family') ? 'has-error' : '' }}">
		<label class="control-label" for="family">family</label>
		{{ Form::text('family', null, ['class' => 'form-control require', 'id' => 'family']) }}
		<div class="error-message">{{ $errors->first('family') }}</div>
	</div>

	<div class="field {{ $errors->has('gender') ? 'has-error' : '' }}">
		<label class="control-label" for="gender">gender</label>
		{{ Form::text('gender', null, ['class' => 'form-control require', 'id' => 'gender']) }}
		<div class="error-message">{{ $errors->first('gender') }}</div>
	</div>

	<div class="field {{ $errors->has('mobile') ? 'has-error' : '' }}">
		<label class="control-label" for="mobile">mobile</label>
		{{ Form::text('mobile', null, ['class' => 'form-control require', 'id' => 'mobile']) }}
		<div class="error-message">{{ $errors->first('mobile') }}</div>
	</div>

	<div class="field {{ $errors->has('nationalCode') ? 'has-error' : '' }}">
		<label class="control-label" for="nationalCode">nationalCode</label>
		{{ Form::text('nationalCode', null, ['class' => 'form-control require', 'id' => 'nationalCode']) }}
		<div class="error-message">{{ $errors->first('nationalCode') }}</div>
	</div>

	<div class="field {{ $errors->has('password') ? 'has-error' : '' }}">
		<label class="control-label" for="password">password</label>
		{{ Form::text('password', null, ['class' => 'form-control require', 'id' => 'password']) }}
		<div class="error-message">{{ $errors->first('password') }}</div>
	</div>

	<div class="field {{ $errors->has('passwordRepeat') ? 'has-error' : '' }}">
		<label class="control-label" for="passwordRepeat">passwordRepeat</label>
		{{ Form::text('passwordRepeat', null, ['class' => 'form-control require', 'id' => 'passwordRepeat']) }}
		<div class="error-message">{{ $errors->first('passwordRepeat') }}</div>
	</div>

	<div class="field {{ $errors->has('captcha') ? 'has-error' : '' }}">
		<label class="control-label" for="captcha">captcha</label>
		{{ HTML::image(Captcha::img(), 'Captcha image') }}
		{{ Form::text('captcha', null, ['class' => 'form-control require', 'id' => 'captcha']) }}
		<div class="error-message">{{ $errors->first('captcha') }}</div>
	</div>

	<div class="field {{ $errors->has('agreement') ? 'has-error' : '' }}">
		<label class="control-label" for="agreement">agreement</label>
		{{ Form::text('agreement', null, ['class' => 'form-control require', 'id' => 'agreement']) }}
		<div class="error-message">{{ $errors->first('agreement') }}</div>
	</div>

	<div>
		<button>مرحله بعد</button>
	</div>

	<div class="clearfix"></div>
{{ Form::close() }}

@stop
