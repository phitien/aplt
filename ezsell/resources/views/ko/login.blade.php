@extends('layouts.master')

@section('title', 'EZSell')

@section('css')
@parent
@endsection

@section('script')
@parent
@endsection

@section('bottom')
@parent
	<div>
		Hỏng rồi, không login được, lý do vì {{ $data['message'] }}. Thử lại phát đi.
	</div>
	<script type="text/javascript" src="js/pages/login.js"></script> 
@endsection