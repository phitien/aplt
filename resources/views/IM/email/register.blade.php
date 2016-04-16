@extends('IM.email.html_template')

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
	<div class="content">
    	<div class="title">Welcome to EZSell</div>
    	<br/>
    	<br/>
    	<div>Please active your account by clicking <a href="{{ $url }}">here</a> and start enjoy shopping.</div>
    </div>
@endsection