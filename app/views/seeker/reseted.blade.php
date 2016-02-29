@extends('layouts.master')

@section('content')

your password reseted<br/>
<a href="{{ action('SeekerController@login') }}">Login page</a>

@stop
