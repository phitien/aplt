@extends('layouts.master')

@section('title', 'EZSell - Register')

@section('top')
@parent
	<div>
		Hỏng rồi, không đăng ký được, lý do vì {{ $data['message'] }}. Thử lại phát đi.
	</div>
@endsection

@section('bottom')
@parent
	<script type="text/javascript" src="js/pages/register.js"></script> 
@endsection