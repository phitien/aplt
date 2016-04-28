@extends('layouts.master')

@section('title', 'EZSell - Password')

@section('top')
@parent
	<div>
		Hehe email đổi rồi đấy, đăng nhập bằng email mới đi ha :D 
	</div>
@endsection

@section('bottomscripts')
@parent
	<script type="text/javascript">
		setTimeout(function () {
			document.location.href = '/';
		}, 5000);
	</script> 
@endsection