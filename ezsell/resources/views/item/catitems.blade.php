<?php

$showBanner = false;
$rightCols = 0;

?>@extends('layouts.master')

@section('title', 'EZSell - Category item list')

@section('variables')
@parent
		manager.set('page', 'CatItemsPage');
@endsection