@extends('layouts.master')

@section('title', 'EZSell - Register')

@section('variables')
@parent
		sessionManager.set('page', 'RegisterPage');
@endsection