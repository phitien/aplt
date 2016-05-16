<?php

$showBanner = false;
$rightCols = 0;

?>@extends('layouts.master')

@section('title', 'EZSell - User item list')

@section('scripts')
@parent
	<script type="text/javascript">
		var useritems_user = {!! $useritems_user !!};
		var useritems_items = {!! $useritems_items !!};
	</script>
	{{ Html::script('js/pages/useritems.js', ['type' => 'text/javascript']) }}
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