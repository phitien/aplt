<?php

$showBanner = false;

?>@extends('layouts.master')

@section('title', 'EZSell - Want to buy something')

@section('variables')
@parent
		manager.set('page', 'BuyItemPage');
@endsection