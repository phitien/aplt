@extends('layouts.master')

@section('title', 'EZSell')

@section('css')
@parent
@endsection

@section('script')
@parent

@endsection

@section('top')
@endsection

@section('bottom')
@parent
	<script type="text/javascript">
	var user = {!! $user !!};
	</script>
    <script type="text/javascript" src="js/pages/profile.js"></script>
@endsection