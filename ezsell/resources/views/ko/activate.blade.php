@extends('layouts.master')

@section('title', 'EZSell - Activate')

@section('top')
@parent
	<div>
		Hỏng rồi, đăng ký không được, lý do vì {{ $data['message'] }}. Thử đăng ký lại phát đi.
	</div> 
@endsection