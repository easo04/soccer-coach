<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SoccerCoach S3</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<script src="{{ asset('js/app.js') }}" defer></script>
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/themify-icons/themify-icons.css') }}" rel="stylesheet">
	@yield('head')
	<!--[if lt IE 9]>
		{{ Html::style('https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js') }}
		{{ Html::style('https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') }}
	<![endif]-->
	<style> textarea { resize: none; } </style>
</head>
<body>
	<div id="app">
		<div class="sous-nav">
			<header-page />
		</div>
		<nav class="navbar navbar-expand-md navbar-light shadow-sm menu-top">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
						@guest
							<li class="nav-item">
								<a class="nav-link link-custom" href="{{ url('/') }}"><i class="ti-home"></i>  Accueil</a>
							</li>
						@endguest
						<li class="nav-item">
                            <a class="nav-link link-custom" href="{{ route('exercice.index') }}"><i class="ti-star"></i> Exercices</a>
						</li>
						@auth
							<li class="nav-item">
								<a class="nav-link link-custom" href="{{ route('user.services') }}"><i class="ti-view-list"></i>  Mes services</a>
							</li>
						@endauth
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link link-custom" href="{{ route('login') }}"> {{ __('Connexion') }}</a>
                            </li>
                            <!-- @if (Route::has('register'))
							<li class="nav-item">
								<a class="nav-link link-custom" href="{{ route('register') }}">{{ __('Register') }}</a>
							</li>
                            @endif -->
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle link-custom" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
									<i class="ti-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-custom" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="#"><i class="ti-face-smile"></i> Mon profil</a>
									<a class="dropdown-item" href="{{ route('user.services') }}"><i class="ti-map"></i> Mes services</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
										onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="ti-na"></i> Déconnexion
									</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
				</div>	
			</div>
		</nav>		
		<div class="border container-soccer-coach" id="contenu-page">
			@yield('contenu')
		</div>
		<footer></footer>
	</div>
</body>
</html>