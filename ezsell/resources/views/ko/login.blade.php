@extends('layouts.master')

@section('title', 'EZSell - Login')

@section('top')
@parent
	<div>
		Hỏng rồi, không login được, lý do vì {{ $data['message'] }}. Thử lại phát đi.
	</div>
@endsection

@section('bottomscripts')
@parent
	<script type="text/javascript" src="js/pages/login.js"></script> 
@endsection