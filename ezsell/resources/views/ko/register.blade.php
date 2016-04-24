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
	Hỏng rồi, kích hoạt không được, lý do vì {{ $data['message'] }}. Thử cách khác xem. 
@endsection