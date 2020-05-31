@extends('template')

@section('head')
	<link href="{{ asset('css/detail-exercice.scss') }}" rel="stylesheet">
@endsection

@section('contenu')
    <update-exercice-form v-bind:exercice="{{ $exercice }}"
        v-bind:variantes="{{ $exercice->variantes }}" v-bind:objectifs-exercice="{{ $exercice->objectifs }}"/>
@endsection