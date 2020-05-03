@extends('template')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/exercice.scss">
@endsection

@section('contenu')
    <div class="actions">      
        <div class="action-recherche">
            <nav class="navbar navbar-expand-sm bg-info navbar-dark">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link selected-type" href="/exercice"><i class="ti-star"></i> Tous</a>
                    </li>
                    @foreach ($types as $type)
                        <li class="nav-item">
                            <a class="nav-link" href="exercice/type/{{ $type->id }}"><i class="{{ $type->icon }}"></i> {!! $type->nom !!}</a>
                        </li>
                    @endforeach       
                </ul>
            </nav>
        </div>
    </div>
    <h3>EXERCICES POPULAIRES</h3>
    <div class="row lst-exercices">
        @if(session()->has('ok'))
            <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
        @endif
        @foreach ($exercices as $exercice)
            <div class="col-sm-4 card card-exercice">
                <div class="card-exercice-image">
                    <img class="card-img-top img-liste" src="images/uploaded/{{ $exercice->image }}"/>
                    <a href="exercice/type/{{ $exercice->typeExercice->id }}">
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
                    {!! link_to_route('exercice.show', 'Voir', [$exercice->id], ['class' => 'btn btn-block btn-soccer-coach']) !!}
                </div>
            </div>
        @endforeach
    </div>
    {!! $links !!}
@endsection