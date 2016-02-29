@extends('layouts.master')

@section('content')

{{ Form::open([]) }}
	
	<div class="field {{ $errors->has('password') ? 'has-error' : '' }}">
		<label class="control-label" for="password">password</label>
		{{ Form::text('password', null, ['class' => 'form-control require', 'id' => 'password']) }}
		<div class="error-message">{{ $errors->first('password') }}</div>
	</div>

	<div class="field {{ $errors->has('repeatPassword') ? 'has-error' : '' }}">
		<label class="control-label" for="repeatPassword">repeatPassword</label>
		{{ Form::text('repeatPassword', null, ['class' => 'form-control require', 'id' => 'repeatPassword']) }}
		<div class="error-message">{{ $errors->first('repeatPassword') }}</div>
	</div>
	
	<button>Reset password</button>

{{ Form::close() }}

@stop
