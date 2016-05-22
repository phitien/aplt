@extends('layouts.master')

@section('title', 'EZSell - Change account email')

@section('variables')
@parent
		sessionManager.set('page', 'ChangeEmailPage');
@endsection