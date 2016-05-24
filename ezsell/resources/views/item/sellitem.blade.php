<?php

$showBanner = false;

?>@extends('layouts.master')

@section('title', 'EZSell - Want to sell something')

@section('variables')
@parent
		manager.set('page', 'SellItemPage');
@endsection