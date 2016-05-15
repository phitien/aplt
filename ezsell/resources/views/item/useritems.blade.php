@extends('layouts.master')

@section('title', 'EZSell - User items')

@section('scripts')
@parent
	<script type="text/javascript">
		var user = {!! $user ? $user : '{}' !!};
		var items = {!! $items !!};
	</script>
@endsection

@section('bottomscripts')
@parent
	<script type="text/javascript" src="js/pages/useritems.js"></script>
@endsection