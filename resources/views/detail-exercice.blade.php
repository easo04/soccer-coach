@extends('template')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/exercice.scss') }}">
    <link rel="stylesheet" href="{{ asset('css/detail-exercice.scss') }}">
@endsection

@section('contenu')
    <div class="actions-exercice-detail">
        @auth
            @if(Auth::user()->id == $exercice->users_id)
                <div class="btn-mes-exercices">
                    <a class="btn btn-soccer-coach-action" href="{{ route('user.exercices') }}"> <i class="ti-list"></i> Mes exercices</a>
                </div>
            @endif
            <div class="btns">                
                    <a class="btn btn-soccer-coach-action" href="/customer/print-pdf/{{ $exercice->id }}"><i class="fa fa-file-pdf-o"></i> Télecharger</a>
                    @if(Auth::user()->id == $exercice->users_id)
                        <a class="btn btn-soccer-coach-action" href="{{ route('exercice.edit', [$exercice->id]) }}"><i class="ti-pencil"></i> Modifier</a>
                        <a class="btn btn-soccer-coach-action" data-toggle="modal" data-target="#modalDelete"><i class="ti-trash"></i> Supprimer</a>
                    @endif       
            </div>
        @endauth
    </div>
    <div class="row details-exercice">
        <div class="col-sm-6 details-exercice-image">
            <div class="image-exercice">
                <img class="img-responsive" src="../images/uploaded/{{ $exercice->image }}">
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
    <div class="modal" id="modalDelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Supprimer exercice</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Voulez-vous supprimer l'exercice <span>{{ $exercice->principe }}</span>?
                </div>
                <div class="modal-footer">
                    {!! Form::open(['method' => 'DELETE', 'route' => ['exercice.destroy', $exercice->id]]) !!}
                        <button type="submit" class="btn btn-soccer-coach-action"><i class="ti-trash"></i> Supprimer</button>
                    {!! Form::close() !!}
                </div>
            </div>               
        </div>
    </div>
@endsection