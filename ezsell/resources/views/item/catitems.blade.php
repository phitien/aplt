<?php

$showBanner = false;
$rightCols = 0;

?>@extends('layouts.master')

@section('title', 'EZSell - Category item list')

@section('scripts')
@parent
	<script type="text/javascript">
		var catitems_cat = {!! $catitems_cat !!};
		var catitems_items = {!! $catitems_items !!};
	</script>
	{{ Html::script('js/pages/catitems.js', ['type' => 'text/javascript']) }}
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