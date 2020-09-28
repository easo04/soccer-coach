@extends('template')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/detail-exercice.scss') }}">
@endsection

@section('contenu')
    <div class="row contenu-exercices">
        <div class="col-sm-9">  
            <div class="row details-exercice">
                <div class="col-sm-6 details-exercice-image">
                    <div class="image-exercice">
                        <img class="img-responsive" src="{{ asset('images/uploaded/' . $exercice->image) }}">
                    </div>
                    <div class="btn-action-exercice">
                        <div class="float-left">
                            @auth 
                                <add-favoris :id-exercice="{{$exercice->id}}" :is-added="{{$exercice->isFavoris}}"/> 
                            @endauth
                        </div>
                        <div class="float-right">
                            <a data-v-1dcfdb9b="" class="btn"><i data-v-1dcfdb9b="" class="ti-facebook"></i></a>
                            <a data-v-1dcfdb9b="" class="btn"><i data-v-1dcfdb9b="" class="ti-instagram"></i></a>  
                        </div>
                    </div>                           
                </div>
                <div class="col-sm-6 details-exercice-info">
                    <div class="detail bloc-info">
                        <h3>{{ $exercice->principe }}</h3>
                        <p class="description-exercice">{{ $exercice->description }}</p>
                        @if(count($exercice->variantes) > 0)   
                            <div class="variantes">
                                @foreach ($exercice->variantes as $variante)
                                    <div class="variante">
                                        <div class="variante-header clearfix">
                                            <span class="float-left"><i class="ti-pin-alt color-soccer-coach"></i> Variante #{{$loop->index + 1}}</span>
                                            <span class="float-right time"><i class="ti-timer color-soccer-coach"></i> {{$variante->time}}</span>
                                        </div>
                                        <div class="variante-body">                   
                                            <p>{{$variante->description}}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="details-items-info">
                            <div class="item-info-exe">
                                <div>
                                    <p class="text">DURÉE:</p>
                                    <p class="value"><i class="ti-timer color-soccer-coach"></i> {{ $exercice->time }}</p>
                                </div>
                            </div>
                            <div class="item-info-exe">
                                <div>
                                    <p class="text">NOMBRE DE JOUEURS:</p>
                                    <p class="value">{{ $exercice->nbJoueurs }}</p>
                                </div>
                            </div>
                            <div class="item-info-exe">
                                <div>
                                    <p class="text">TYPE:</p>
                                    <p class="value"><i class="{{$exercice->typeExercice->icon}} color-soccer-coach"></i> {{ $exercice->typeExercice->nom }}</p>
                                </div>
                            </div>
                        </div>
                    </div>     
                </div>
            </div>
            <div class="row mt-3">
                    <div class="col-sm-6">
                    </div>
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
            <div class="search-by-type search-div soccer-designer">
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