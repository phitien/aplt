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
	<div class="content">
    	<div class="title">Welcome</div>
    </div>
@endsection