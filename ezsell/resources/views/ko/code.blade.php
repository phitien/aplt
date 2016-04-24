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
	Hỏng rồi, không gửi được thư kích hoạt, lý do vì {{ $data['message'] }}. Thử lại phát đi. 
@endsection