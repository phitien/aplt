@extends('layouts.master')

@section('title', 'EZSell - Profile')

@section('top')
@parent
	<div>
		Hỏng rồi, update có vài lỗi, lý do vì {{ $data['message'] }}. Thử lại phát đi.
	</div>
@endsection

@section('bottomscripts')
@parent
	<script type="text/javascript">
	var user = {!! $user !!};
	</script>
    <script type="text/javascript" src="js/pages/profile.js"></script>
@endsection