@extends('layouts.master')

@section('title', 'EZSell - Password')

@section('top')
@parent
	<div>
		Hỏng rồi, không đổi được mật khẩu, lý do vì {{ $data['message'] }}. Thử lại phát đi.
	</div>
@endsection

@section('bottomscripts')
@parent
	<script type="text/javascript" src="js/pages/password.js"></script> 
@endsection