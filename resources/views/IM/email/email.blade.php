@extends('IM.email.html_template')

@section('title'){{ $title }}@endsection

@section('content')
	<div class="content">
    	<div class="title">{{ $title }}</div>
    	<br/>
    	<br/>
    	<div>Your email account has been changed to {{ $email }}. Please login to {{ $email }} to activate it.</div>
    	<br/>
    </div>
@endsection