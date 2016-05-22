<?php 

$showBanner = true;

?>@extends('layouts.master')

@section('title', 'EZSell - Home page')

@section('variables')
@parent
		sessionManager.set('page', 'HomePage');
@endsection