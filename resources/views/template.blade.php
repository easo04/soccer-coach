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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/themify-icons/themify-icons.css') }}" rel="stylesheet">
		<link href="{{ asset('css/soccer-coach.scss') }}" rel="stylesheet">
    	@yield('head')
		<!--[if lt IE 9]>
			{{ Html::style('https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js') }}
			{{ Html::style('https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') }}
		<![endif]-->
		<style> textarea { resize: none; } </style>
</head>
<body>
	<div id="app">
		<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
				<a class="navbar-brand" href="{{ url('/') }}">SoccerCoach S3</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
						<li class="nav-item">
                            <a class="nav-link link-custom" href="{{ url('/') }}"><i class="ti-home"></i> Accueil</a>
						</li>
						<li class="nav-item">
                            <a class="nav-link link-custom" href="{{ route('exercice.index') }}"><i class="ti-star"></i> Exercices</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle link-custom" href="#" id="navbardrop" data-toggle="dropdown"><i class="ti-clipboard"></i> Types d'exercices</a>
							<list-types-exercices id-area="navbardrop"/>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle link-custom" href="#" id="navbardrop2" data-toggle="dropdown"><i class="ti-tag"></i> Objectifs</a>
							<list-objectifs id-area="navbardrop2"/>
						</li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link link-custom" href="{{ route('login') }}"><i class="ti-lock"></i> {{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
							<li class="nav-item">
								<a class="nav-link link-custom" href="{{ route('register') }}"><i class="ti-face-smile"></i> {{ __('Register') }}</a>
							</li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle link-custom" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
									<i class="ti-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right dropdown-custom" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="#"><i class="ti-face-smile"></i> Mon profil</a>
									<a class="dropdown-item" href="{{ route('user.exercices') }}"> <i class="ti-list"></i> Mes exercices</a>
									<a class="dropdown-item" href="#"><i class="ti-map"></i> Mes séances</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
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
		<div class="container p-3 my-3 border container-soccer-coach">
			@yield('contenu')
		</div>
		<footer></footer>
	</div>
</body>
</html>