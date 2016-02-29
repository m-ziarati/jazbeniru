@extends('layouts.master')

@section('content')

صفحه پرداخت<br/>
مبلغ {{ 14300 }} جهت فعالسازی حساب<br/>

<a href="{{ route('seeker.step2.purchase') }}">رفتن به صفحه پرداخت</a>

@stop
