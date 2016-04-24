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
	Hỏng rồi, đăng ký không được, lý do vì {{ $data['message'] }}. Thử đăng ký lại phát đi. 
@endsection