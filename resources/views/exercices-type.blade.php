@extends('template')

@section('contenu')
<div class="row contenu-exercices">
    <div class="col-sm-9">
        <div class="actions">  
            <div class="action-recherche">
                <h5>Filtrer par type</h5>
                <nav class="navbar navbar-expand-sm bg-info navbar-dark nav-type-exercice">    
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/exercice"><i class="ti-star"></i> Tous</a>
                        </li>
                        @foreach ($types as $type)
                            @if($type->selected)
                                <li class="nav-item">
                                    <a class="nav-link selected-type" href="{{ route('exercice.type', ['n'=>$type->id, 'urlNom'=>$type->urlNom]) }}"><i class="{{ $type->icon }}"></i> {!! $type->nom !!}</a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('exercice.type', ['n'=>$type->id, 'urlNom'=>$type->urlNom]) }}"><i class="{{ $type->icon }}"></i> {!! $type->nom !!}</a>
                                </li>
                            @endif              
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
        <h3>EXERCICES - {{ $typeSelected->nom }}</h3>
        <div class="row lst-exercices">
            @if(session()->has('ok'))
                <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
            @endif
            @foreach ($exercices as $exercice)
                <div class="col-sm-4 card card-exercice">
                    <div class="card-exercice-image">
                        <a class="lien-image" href="{{ route('exercice.show', ['exercice'=>$exercice->id, 'name'=>$exercice->principeUrl]) }}">
                            <img class="card-img-top img-liste" src="{{ asset('images/uploaded/' . $exercice->image) }}"/>
                        </a>
                        <a href="{{ route('exercice.type', ['n'=>$exercice->typeExercice->id, 'urlNom'=>$exercice->typeExercice->urlNom]) }}">
                            <span class="bought"><i class="{{$exercice->typeExercice->icon}}"></i> {{ $exercice->typeExercice->nom }}</span>
                        </a>
                    </div>
                    <div class="card-body body-exercice">      
                        <div class="card-title-principe">
                            <h4 class="card-title">{!! $exercice->principe !!}</h4>
                            <h6><i class="ti-timer color-soccer-coach"></i> {!! $exercice->time !!}</h6>
                        </div>

                        <p>{!! $exercice->description !!}</p>
                    </div>
                    <div class="card-footer footer-exercice">
                    <a class="btn btn-block btn-soccer-coach" href="{{ route('exercice.show', ['exercice'=>$exercice->id, 'name'=>$exercice->principeUrl]) }}">Voir</a>
                    </div>
                </div>
            @endforeach
        </div>
        {!! $links !!}
    </div>
    <div class="col-sm-3 menu-droite-search"> 
        <div class="search-by-type search-div">
            Soccer designer image
        </div>     
        <div class="search-by-type search-div">
            <h4><i class="ti-clipboard"></i> Types</h4>
            <list-types-exercices :is-menu-top="false" :types="{{$types}}"/>
        </div>       
        <div class="search-by-type search-div">
            <h4><i class="ti-tag"></i> Objectifs</h4>
            <list-objectifs :is-menu-top="false" :objectifs="{{$objectifs}}"/>
        </div>
    </div>
</div>
@endsection