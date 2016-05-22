<?php

$showBanner = false;

?>@extends('layouts.master')

@section('title', 'EZSell - Want to buy something')

@section('scripts')
@parent
	{{ Html::script('js/pages/buyitem.js', ['type' => 'text/javascript']) }}
@endsection

@section('variables')
@parent
		sessionManager.set('page', 'BuyItemPage');
@endsection