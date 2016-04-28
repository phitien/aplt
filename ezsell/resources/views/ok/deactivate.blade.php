@extends('layouts.master')

@section('title', 'EZSell - Deactivate')

@section('top')
@parent
	<div>
		Hehe, deactivate được rồi !!
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