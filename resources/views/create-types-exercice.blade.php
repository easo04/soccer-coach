@extends('template')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../css/themify-icons/themify-icons.css" rel="stylesheet">
@endsection

@section('contenu')
<div class="container p-3 my-3 border container-soccer-coach">
	<br>
	<h3>Création d'un type d'exercice</h3>
    <div class="panel panel-primary">	
        <div class="panel-body"> 
            <div class="col-sm-12">
                {!! Form::open(['route' => 'types-exercice.store', 'class' => 'form-horizontal panel']) !!}	
                <div class="form-group {!! $errors->has('nom') ? 'has-error' : '' !!}">
                    {!! Form::text('nom', null, ['class' => 'form-control', 'placeholder' => 'Nom']) !!}
                    {!! $errors->first('nom', '<small class="help-block">:message</small>') !!}
                </div>
                {!! Form::submit('Créer', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <a href="javascript:history.back()" class="btn btn-primary">
        <span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
    </a>
</div>
@endsection