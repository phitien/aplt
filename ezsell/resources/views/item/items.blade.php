@extends('layouts.master')

@section('title', 'EZSell - Details')

@section('scripts')
@parent
	<script type="text/javascript">
		var cat = {!! $cat !!};
		var items = {!! $items !!};
	</script>
@endsection

@section('bottomscripts')
@parent
	<script type="text/javascript" src="js/pages/items.js"></script>
@endsection