@extends('template')

@section('head')
	<link href="{{ asset('css/exercice.scss') }}" rel="stylesheet">
	<link href="{{ asset('css/detail-exercice.scss') }}" rel="stylesheet">
@endsection

@section('contenu')
	<add-exercice-form v-bind:types="{{ $types }}" v-bind:objectifs="{{ $objectifs }}"/>
@endsection