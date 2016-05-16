<?php

$showBanner = false;

?>@extends('layouts.master')

@section('title', 'EZSell - Want to sell something')

@section('scripts')
@parent
	{{ Html::script('js/pages/sellitem.js', ['type' => 'text/javascript']) }}
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