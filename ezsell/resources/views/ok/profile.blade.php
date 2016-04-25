@extends('layouts.master')

@section('title', 'EZSell - Profile')

@section('top')
@parent
	<div>
		Hehe update ok rồi đấy :).
	</div>
@endsection

@section('bottom')
@parent
	<script type="text/javascript">
	var user = {!! $user !!};
	</script>
    <script type="text/javascript" src="js/pages/profile.js"></script>
@endsection