@extends('layouts.master')

@section('title', 'EZSell - Change password')

@section('variables')
@parent
		sessionManager.set('page', 'ChangePasswordPage');
@endsection