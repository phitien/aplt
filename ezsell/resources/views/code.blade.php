@extends('layouts.master')

@section('title', 'EZSell - Send activation code')

@section('variables')
@parent
		sessionManager.set('page', 'SendActivationPage');
@endsection