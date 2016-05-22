@extends('layouts.master')

@section('title', 'EZSell - Change account name')

@section('variables')
@parent
		sessionManager.set('page', 'ChangeAccountPage');
@endsection