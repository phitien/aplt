@extends('layouts.master')

@section('title', 'EZSell - Deactivate account')

@section('variables')
@parent
		sessionManager.set('page', 'DeactivatePage');
@endsection