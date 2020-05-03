@extends('template')

@section('head')
    <link href="{{ asset('css/exercice.scss') }}" rel="stylesheet">
@endsection

@section('contenu')
    <exercices-by-user v-bind:exercices="{{ $exercices }}" v-bind:types="{{ $types }}"/>
@endsection