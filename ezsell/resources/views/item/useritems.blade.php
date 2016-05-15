@extends('layouts.master')

@section('title', 'EZSell - Details')

@section('scripts')
@parent
	<script type="text/javascript">
		var user = {!! $user !!};
		var items = {!! $items !!};
	</script>
@endsection

@section('bottomscripts')
@parent
	<script type="text/javascript" src="js/pages/useritems.js"></script>
@endsection