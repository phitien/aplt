@extends('layouts.master')

@section('title', 'EZSell')

@section('css')
	{{ Html::style('css/im.css') }}
@endsection

@section('script')
	{{ Html::script('js/im.js') }}
@endsection

@section('sidebar')
    @parent
@endsection

@section('content')
	<form method="POST" action="/login">
		{!! csrf_field() !!}
	    <div>
	        Email
	        <input type="email" name="email" value="{{ old('email') }}">
	    </div>
	    <div>
	        Password
	        <input type="password" name="password" id="password">
	    </div>
	    <div>
	        <input type="checkbox" name="remember"> Remember Me
	    </div>
	    <div>
	        <button type="submit">Login</button>
	    </div>
	</form>
@endsection