@extends('layouts.master')

@section('title', 'EZSell - Details')

@section('scripts')
@parent
	<script type="text/javascript">
		var item = {!! $item ? $item : null !!};
	</script>
@endsection

@section('bottomscripts')
@parent
	<script type="text/javascript" src="js/pages/item.js"></script>
@endsection