@extends('layouts.master')

@section('title', 'Welcome to IM')

@section('css')
	{{ HTML::style('css/im.css') }}
@endsection

@section('script')
	{{ HTML::script('js/im.js') }}
@endsection

@section('sidebar')
    @parent
    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
	<div class="content">
    	<div class="title">Welcome to IM</div>
    </div>
@endsection