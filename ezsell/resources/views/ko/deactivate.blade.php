@extends('layouts.master')

@section('title', 'EZSell - Deactivate')

@section('top')
@parent
	<div>
		Hỏng rồi, không deactivate được, lý do vì {{ $data['message'] }}. Thử lại phát đi.
	</div>
@endsection

@section('bottomscripts')
@parent
	<script type="text/javascript" src="js/pages/deactivate.js"></script> 
@endsection