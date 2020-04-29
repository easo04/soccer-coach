@extends('template')

@section('head')
    <link href="{{ asset('css/exercice.scss') }}" rel="stylesheet">
	<link href="{{ asset('css/detail-exercice.scss') }}" rel="stylesheet">
@endsection

@section('contenu')
    <update-exercice-form v-bind:exercice="{{ $exercice }}" v-bind:types="{{ $types }}" v-bind:variantes="{{ $exercice->variantes }}"/>
@endsection