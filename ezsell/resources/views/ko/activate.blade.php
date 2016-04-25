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
		Hỏng rồi, đăng ký không được, lý do vì {{ $data['message'] }}. Thử đăng ký lại phát đi.
	</div> 
@endsection