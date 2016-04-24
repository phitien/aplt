@extends('IM.email.html_template')

@section('title'){{ $title }}@endsection

@section('content')
	<div class="content">
    	<div class="title">{{ $title }}</div>
    	<br/>
    	<br/>
    	<div>Please active your account by clicking <a href="{{ $url }}">here</a> and start enjoy shopping.</div>
    	<br/>
    </div>
@endsection