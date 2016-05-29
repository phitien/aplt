@extends('layouts.master')

@section('title', 'EZSell - Error')

@section('bottomscripts')
@parent
@endsection

@section('content')
@parent
	<div class="content">
		<div class="title">Lỗi rồi :( !! : {{ $exception->getMessage() }}</div>
		<div class="trace"><ul>
		@foreach ($lines as $i => $line)
		    <li>{{ $line }}</li>
		@endforeach
		</ul></div>
	</div>
@endsection