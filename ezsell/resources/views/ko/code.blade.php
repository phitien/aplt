@extends('layouts.master')

@section('title', 'EZSell')

@section('css')
@parent
@endsection

@section('script')
@parent
@endsection

@section('top')
@parent
	<div>
		Hỏng rồi, không gửi được thư kích hoạt, lý do vì {{ $data['message'] }}. Thử lại phát đi.
	</div> 
@endsection

@section('bottom')
@parent
	<script type="text/javascript" src="js/pages/code.js"></script> 
@endsection