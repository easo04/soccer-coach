@extends('template')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/detail-exercice.scss') }}">
@endsection

@section('contenu')
    <div class="row contenu-exercices">
        <div class="col-sm-9">
            <div class="actions-exercice-detail">
                @auth
                    <div class="btns">      
                        <add-favoris :id-exercice="{{$exercice->id}}" :is-added="{{$exercice->isFavoris}}"/>
                    </div>  
                @endauth
            </div>
            <div class="row details-exercice">
                <div class="col-sm-6 details-exercice-image">
                    <div class="image-exercice">
                        <img class="img-responsive" src="{{ asset('images/uploaded/' . $exercice->image) }}">
                    </div>                              
                </div>
                <div class="col-sm-6 details-exercice-info">
                    <div class="detail bloc-info">
                        <h3>{{ $exercice->principe }}</h3>
                        <p class="description-exercice">{{ $exercice->description }}</p>
                        <div class="d-flex justify-content-center details-items-info">
                            <div class="p-flex">
                                <p class="text">DURÉE:</p>
                                <p class="value"><i class="ti-timer color-soccer-coach"></i> {{ $exercice->time }}</p>
                            </div>
                            <div class="p-flex">
                                <p class="text">NOMBRE DE JOUEURS:</p>
                                <p class="value">{{ $exercice->nbJoueurs }}</p>
                            </div>
                            <div class="p-flex">
                                <p class="text">TYPE:</p>
                                <p class="value"><i class="{{$exercice->typeExercice->icon}} color-soccer-coach"></i> {{ $exercice->typeExercice->nom }}</p>
                            </div>
                        </div>
                    </div>     
                </div>
            </div>
            <div class="row mt-3">
                    @if(count($exercice->variantes) > 0)   
                        <div class="variantes col-sm-6">
                            @foreach ($exercice->variantes as $variante)
                                <div class="variante">
                                    <div class="variante-header clearfix">
                                        <h5 class="float-left"><i class="ti-pin-alt color-soccer-coach"></i> Variante #{{$loop->index + 1}}</h5>
                                        <h5 class="float-right time"><i class="ti-timer color-soccer-coach"></i> {{$variante->time}}</h5>
                                    </div>
                                    <div class="variante-body">                   
                                        <p>{{$variante->description}}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="col-sm-6">
                        </div>
                    @endif
                <div class="col-sm-6">
                    @if($exercice->observations != '')
                        <div class="observations-exercice bloc-sm bloc-info">
                            <h5><i class="ti-eye color-soccer-coach"></i> Observations</h5>
                            <p>{{ $exercice->observations }}</p>
                        </div>
                    @endif  
                    @if($exercice->sousPrincipe != '')
                        <div class="bloc-sm bloc-info">
                            <h5><i class="ti-flag color-soccer-coach"></i> Sous-principes</h5>
                            <p>{{ $exercice->sousPrincipe }}</p>
                        </div>
                    @endif
                    @if($exercice->physique != '')
                        <div class="bloc-sm bloc-info">
                            <h5><i class="ti-heart color-soccer-coach"></i> Objectifs physiques</h5>
                            <p>{{ $exercice->physique }}</p>
                        </div>
                    @endif 
                    @if($exercice->idVideo != '')
                        <div class="video">
                            <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/{{$exercice->idVideo}}" 
                            frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>     
                        </div>
                    @elseif($exercice->url != '')
                        <div class="url">
                            <i class="ti-link color-soccer-coach"></i><a href="{{$exercice->url}}" target = "_blank"> {{$exercice->url}}</a>    
                        </div>        
                    @endif
                </div>
            </div>   
            @if(count($exercice->objectifs) > 0)  
                <div class="mt-3">
                    <h5><i class="ti-tag color-soccer-coach"></i> Objectifs</h5>   
                    <objectifs-by-exercice v-bind:objectifs="{{ $exercice->objectifs }}"/>
                </div>  
            @endif
            <div class="suggestions-exercices">
                <h5>Exercices du même type</h5>
                <div class="lst-suggestions">
                    @foreach($exerciceEvenType as $exe)
                        <a class="lien-suggestion" href="{{ route('exercice.show', ['exercice'=>$exe->id, 'name'=>$exe->principeUrl]) }}" alt="{{$exe->principeUrl}}">
                            <div class="suggestion-item">
                                <div class="img-suggestion">
                                    <img src="{{ asset('images/uploaded/' . $exe->image) }}" alt="{{$exe->principe}}"/>
                                </div>
                                <div class="principe">
                                    <h5 class="card-title">{{$exe->principe}}</h5>
                                </div>
                                <div class="time"><h6><i class="ti-timer color-soccer-coach"></i> {{$exe->time}}</h6></div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
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