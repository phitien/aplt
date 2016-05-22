<?php

$showBanner = false;

?>@extends('layouts.master')

@section('title', 'EZSell - Want to buy something')

@section('variables')
@parent
		sessionManager.set('page', 'BuyItemPage');
@endsection