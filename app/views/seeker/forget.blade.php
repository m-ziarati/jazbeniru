@extends('layouts.master')

@section('content')

{{ Form::open(['action' => 'SeekerController@forget']) }}
	
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

	<div class="field {{ $errors->has('captcha') ? 'has-error' : '' }}">
		<label class="control-label" for="captcha">captcha</label>
		{{ HTML::image(Captcha::img(), 'Captcha image') }}
		{{ Form::text('captcha', null, ['class' => 'form-control require', 'id' => 'captcha']) }}
		<div class="error-message">{{ $errors->first('captcha') }}</div>
	</div>
	
	<button>Remind</button>
{{ Form::close() }}

@stop
