@extends('layouts.master')

@section('title', 'EZSell - Change location')

@section('variables')
@parent
		sessionManager.set('page', 'ChangeLocationPage');
@endsection