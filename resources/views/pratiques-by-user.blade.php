@extends('template')

@section('contenu')
    <pratiques-by-user v-bind:pratiques="{{ $pratiques }}">
@endsection