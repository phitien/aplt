<?php

$showBanner = false;
// $leftCols = 0;
// $rightCols = 0;

?>@extends('layouts.master')

@section('title', 'EZSell - Details')

@section('variables')
@parent
		manager.set('page', 'ItemDetailsPage');
@endsection