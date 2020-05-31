@extends('template')

@section('contenu')
    <exercices-by-user v-bind:exercices="{{ $exercices }}" v-bind:types="{{ $types }}" v-bind:objectifs="{{ $objectifs }}"/>
@endsection