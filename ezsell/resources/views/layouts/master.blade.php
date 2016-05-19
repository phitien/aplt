<?php
use App\Ezsell\Models\Cat;
use App\Ezsell\Helper;
use App\Ezsell\Config;

$usecode = Config::USE_CODE ? 'true' : 'false';
$MODES = json_encode ( Config::$modes );
$mode = ( int ) Helper::getMode ();
$mediaBaseUrl = Config::MEDIA_BASE_URL;
$noavatarman = "{$mediaBaseUrl}/noavatarman";
$noavatarwoman = "{$mediaBaseUrl}/noavatarwoman";
$cats = Cat::getHierarchy ();
$location = json_encode ( Helper::getLocation () );
$appMessage = isset ( $appMessage ) ? $appMessage : '';
?>@extends('layouts.base')

@section('variables')
@parent
		var currentLocation = {!! $location !!};
		var usecode = {!! $usecode !!};
		var MODES = {!! $MODES !!};
		var mode = {!! $mode !!};
		var appMessage = '{{ $appMessage }}';
		var cats = {!! $cats !!};
		var data = {!! isset($data) ? json_encode($data) : '{}' !!};
		var mediaBaseUrl = '{!! $mediaBaseUrl !!}';
		var noavatarman = '{!! $noavatarman !!}';
		var noavatarwoman = '{!! $noavatarwoman !!}';
@endsection