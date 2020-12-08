<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	{{-- <link rel="stylesheet" href="template/css/style.css"/>
	<link rel="stylesheet" href="template/css/font-awesome/css/font-awesome.min.css"/>
	<link rel="stylesheet" href="template/css/lightbox.css"> --}}

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800,300italic,400italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,700italic,700,400italic' rel='stylesheet' type='text/css'>
	
	{{-- <script src="template/js/jquery-1.9.1.js" type="text/javascript"></script>
	<script src="template/js/js.js" type="text/javascript"></script> --}}
	    <!-- Important Owl stylesheet -->
    {{-- <link rel="stylesheet" href="template/owl-carousel/owl.carousel.css"> --}}
    <!-- Default Theme -->
    {{-- <link rel="stylesheet" href="template/owl-carousel/owl.theme.css"> --}}
    <!-- Include js plugin -->


    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    {{-- <script src="template/owl-carousel/owl.carousel.js"></script>
    <script src="template/js/countdown.js" type="text/javascript" charset="utf-8"></script>
    <script src="template/js/lightbox.js" type="text/javascript" charset="utf-8"></script> --}}
    <!--[if IE]>
    	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  	<![endif]-->	
</head>
<body>
	<div id="app">
		<header>
			<nav>
				<ul>
					<li><a href="{{route('standing.index')}}">Турнирная таблица</a></li>
					<li><a href="{{route('schedule.index')}}">Расписание</a></li>
					<li><a href="{{route('guess.index')}}">Тотализатор</a></li>
					<li><a href="">Команды</a></li>
					@guest
						<li><a href="{{ route('login') }}">Войти</a></li>
					@else
						<li><a href="#">{{ Auth::user()->name }}</a></li>
						<li>
							<a href="{{ route('logout')}}" onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">Выйти
							</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</li>
					@endguest
				</ul>
			</nav>
		</header>
		<main>
			<section class="bg-dark-blue">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							@yield('content')
						</div>
					</div>
				</div>
			</section>
		</main>
	</div>
</body>

</html>