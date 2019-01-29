@extends('layouts.public')

@section('head_content')
		<meta name="description" content="Gestiona tus datos, tus recetas y otras opciones.">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.css') }}">

		<title>{{ config('app.name', 'PaNPaS') }} - Mi cuenta</title>
@endsection

@section('content')

		@include('layouts.public-navbar-auth')

        {{-- Header --}}
        <header class="masthead" style="
            --bg-url: url(../images/header-followed.jpg);
            --bg-attach: fixed;
            --bg-size: cover;
            --bg-x: center;
            --bg-y: center;
        ">
            <div>
                <h2>{{ config('app.name', 'PaNPaS') }}</h2>
                <span>Estate atento, entérate de todo lo</span>
                <span>que hagan los usuarios que sigues</span>
            </div>
        </header>

		{{-- Panel --}}
        <section id="user_panel">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                            	Siguiendo
                        	</div>

                            <div class="card-body">
                               {{-- Seguidos Grid --}}
							        <section class="bg-light" id="ranking">
							            <div class="container">
							                <div class="row">
							                	@foreach($follows as $usuario)
							                    	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 ranking-item">
								                        <a class="ranking-link" data-toggle="modal" href="/unfollow/{{$usuario->id}}">
								                            <div class="ranking-hover">
								                                <div class="ranking-hover-content">
								                                    <i class="fas fa-minus fa-3x"></i>
								                                </div>
								                            </div>
								                            <img class="img-fluid" src="{{$usuario->avatar}}" alt="Bollos Suizos">
								                        </a>
								                        <div class="ranking-caption">
								                            <h4><a href="/{{$usuario->username}}">{{$usuario->username}}</a></h4>
								                            <h5 class="stars-votos" style="">
										                                <i class="fas fa-lg fas fa-sign-out-alt" title="{{$usuario->username}} está siguiendo a  {{count ($usuario->follows)}} usuarios" style="color: green;"></i > {{ count($usuario->follows) }}
										                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										                                <i class="fas fa-lg fas fa-sign-in-alt" title="{{$usuario->username}} tiene {{count($usuario->followers)}} seguidores" style="color: blue;"></i > {{ count($usuario->followers) }}
										                    </h5>
								                        </div>
							                    	</div>

							                    @endforeach
							                </div>
							            </div>
							        </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



@endsection

{{-- ============================================================================ --}}
{{-- ============================================================================ --}}

@section('footer_scripts_content')
		{{-- jQuery, Bootstrap, jQuery Easing --}}
		<script src="{{ asset('js/app.js') }}"></script>

		{{-- Otros --}}
		<script src="js/agency.js"></script>
@endsection
