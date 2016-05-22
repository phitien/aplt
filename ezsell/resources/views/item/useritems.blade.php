<?php

$showBanner = false;
$rightCols = 0;

?>@extends('layouts.master')

@section('title', 'EZSell - User item list')

@section('variables')
@parent
		sessionManager.set('page', 'UserItemsPage');
@endsection