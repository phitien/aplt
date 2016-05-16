<?php 

$showBanner = true;

?>@extends('layouts.master')

@section('title', 'EZSell - Home page')

@section('scripts')
@parent
    {{ Html::script('js/pages/home.js', ['type' => 'text/javascript']) }}
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