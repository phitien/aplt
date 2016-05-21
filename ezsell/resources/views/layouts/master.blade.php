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
		sessionManager.set('location', {!! $location !!});
		sessionManager.set('usecode', {!! $usecode !!});
		sessionManager.set('MODES', {!! $MODES !!});
		sessionManager.set('mode', {!! $mode !!});
		sessionManager.set('appMessage', '{{ $appMessage }}');
		sessionManager.set('cats', {!! $cats !!});
		sessionManager.set('rawdata', {!! isset($data) ? json_encode($data) : '{}' !!});
		sessionManager.set('mediaBaseUrl', '{!! $mediaBaseUrl !!}');
		sessionManager.set('noavatarman', '{!! $noavatarman !!}');
		sessionManager.set('noavatarwoman', '{!! $noavatarwoman !!}');
@endsection