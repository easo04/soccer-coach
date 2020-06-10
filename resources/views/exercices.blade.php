@extends('template')

@section('contenu')
    <div class="row contenu-exercices">
        <div class="col-sm-9">
            <div class="actions">   
                @if(isset($objectifSearch))  
                    <div class="action-recherche">           
                        <filter-by-objectif v-bind:objectifs="{{ $objectifs }}" objectif-selected="{{ $objectifSearch }}"
                        v-bind:set-url="true" v-bind:show-btn-filter="false"/>
                    </div>
                @else
                    <div class="action-recherche">
                        <h5>Filtrer par type</h5>
                        <nav class="navbar navbar-expand-sm bg-info navbar-dark nav-type-exercice">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link selected-type" href="/exercice"><i class="ti-star"></i> Populaires</a>
                                </li>
                                @foreach ($types as $type)
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('exercice.type', ['n'=>$type->id, 'urlNom'=>$type->urlNom]) }}"><i class="{{ $type->icon }}"></i> {!! $type->nom !!}</a>
                                    </li>
                                @endforeach       
                            </ul>
                        </nav>
                        <div class="mt-2">
                            <filter-by-objectif v-bind:objectifs="{{ $objectifs }}"
                            v-bind:set-url="true" v-bind:show-btn-filter="true"/>
                        </div>
                    </div>
                @endif
            </div>
            @if(isset($objectifSearch))
                <h3>EXERCICES - {{ $nomObjectifSearch }}</h3>
            @else
                <h3>EXERCICES POPULAIRES</h3>
            @endif
            <div class="row lst-exercices">
                @if(session()->has('ok'))
                    <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
                @endif
                @forelse  ($exercices as $exercice)
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
                @empty
                    <div class="lst-vide"><span class="aucun-exercice">Aucun exercice</span></div>
                @endforelse
            </div>
            @if(isset($objectifSearch))
                {!! $links !!}
            @endif
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