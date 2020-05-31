@extends('template')

@section('head')
    <link href="{{ asset('css/detail-exercice.scss') }}" rel="stylesheet">
@endsection

@section('contenu')
    <dashboard-soccer-coach user="{{ Auth::user()->name }}"/>
@endsection 