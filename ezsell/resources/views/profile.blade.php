@extends('layouts.master')

@section('title', 'EZSell - Profile')

@section('variables')
@parent
		sessionManager.set('page', 'ProfilePage');
@endsection