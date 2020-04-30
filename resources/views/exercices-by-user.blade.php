@extends('template')

@section('head')
    <link href="{{ asset('css/exercice.scss') }}" rel="stylesheet">
@endsection

@section('contenu')
 
    <div class="action-exercice">
            <div class="btn-create-exercice">
                <a class="btn btn-soccer-coach-action" href="/exercice/create">
                    <i class="ti-plus"></i> Créer un exercice
                </a>
            </div>
        </div>
    <div class="actions">
     
    </div>
    <h3>Mes exercices</h3>
    <div class="row lst-exercices">
    	@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
        @endif
        @foreach ($exercices as $exercice)
            <div class="col-sm-4 card card-exercice">
                <div class="card-exercice-image">
                    <img class="card-img-top img-liste" src="../../images/uploaded/{{ $exercice->image }}">
                    <a href="{{ $exercice->typeExercice->id }}">
                        <span class="bought"><i class="{{$exercice->typeExercice->icon}}"></i> {{ $exercice->typeExercice->nom }}</span>
                    </a>
                </div>
                <div class="card-body body-exercice">      
                    <div class="card-title-principe">
                        <h4 class="card-title">{!! $exercice->principe !!}</h4>
                        <h6><i class="ti-timer color-soccer-coach"></i> Durée: {!! $exercice->time !!}</h6>
                    </div>

                    <p>{!! $exercice->description !!}</p>
                </div>
                <div class="card-footer footer-exercice">
                    {!! link_to_route('exercice.show', 'Voir', [$exercice->id], ['class' => 'btn btn-block btn-soccer-coach']) !!}
                </div>
            </div>
        @endforeach
    </div>
    {!! $links !!}
@endsection