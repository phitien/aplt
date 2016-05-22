<?php

$showBanner = false;

?>@extends('layouts.master')

@section('title', 'EZSell - Want to sell something')

@section('variables')
@parent
		sessionManager.set('page', 'SellItemPage');
@endsection