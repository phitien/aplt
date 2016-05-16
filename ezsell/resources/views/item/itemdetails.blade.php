<?php

$showBanner = false;
// $leftCols = 0;
// $rightCols = 0;

?>@extends('layouts.master')

@section('title', 'EZSell - Details')

@section('scripts')
@parent
	<script type="text/javascript">
		var itemdetails_item = {!! $itemdetails_item !!};
	</script>
	{{ Html::script('js/pages/itemdetails.js', ['type' => 'text/javascript']) }}
@endsection

@section('left')
@parent
@endsection

@section('center')
@parent
@endsection

@section('right')
@parent
@endsection