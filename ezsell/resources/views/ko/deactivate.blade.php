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
		Hỏng rồi, không deactivate được, lý do vì {{ $data['message'] }}. Thử lại phát đi.
	</div>
@endsection

@section('bottom')
@parent
	<script type="text/javascript" src="js/pages/deactivate.js"></script> 
@endsection