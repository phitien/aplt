@extends('layouts.master')

@section('title', 'EZSell - Login')

@section('variables')
@parent
		sessionManager.set('page', 'LoginPage');
@endsection