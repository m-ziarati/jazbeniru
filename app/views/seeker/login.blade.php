@extends('layouts.master')

@section('content')

{{ Form::open(['action' => 'SeekerController@auth']) }}
	
	{{ Form::text('mobile', null, []) }}
	{{ Form::password('mobile', []) }}
	<button>Login</button>
	<a href="{{ action('SeekerController@forget') }}">forgot your password?</a>
{{ Form::close() }}

@stop
