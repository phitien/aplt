@extends('layouts.master')

@section('title', 'EZSell - Password')

@section('top')
@parent
	<div>
		Hỏng rồi, không đổi được email rồi, lý do vì {{ $data['message'] }}. Thử lại phát đi.
	</div>
@endsection

@section('bottomscripts')
@parent
	<script type="text/javascript" src="js/pages/email.js"></script> 
@endsection