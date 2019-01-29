@extends('layouts.public')

@section('head_content')
        <meta name="description" content="Explora todas las recetas disponibles en PaNPaS.">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{--
            Esta hoja de estilos crea una BARRA de Desplazmiento Extra dentro de
            esta página.
            ¿Es necesaria para algo en especial o se puede eliminar?
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> --}}

        <!-- CSS -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/alertify.min.css"/>
        <!-- Default theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/default.min.css"/>
        <!-- Semantic UI theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/semantic.min.css"/>
        {{-- El tema de Bootstrap no es necesario porque ya está incluido en la hoja de estilos principal (css/app.css) --}}
        {{--
        <!-- Bootstrap theme -->
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/css/themes/bootstrap.min.css"/>--}}

        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.css') }}">

        <title>{{ config('app.name', 'PaNPaS') }} - Mi cuenta</title>
@endsection

@section('content')

        @include('layouts.public-navbar-auth')

        {{-- Header --}}
        <header class="masthead" style="
            --bg-url: url(../images/header-recetas.jpg);
            --bg-attach: fixed;
            --bg-size: cover;
            --bg-x: center;
            --bg-y: center;
        ">
            <div>
                <h2>{{ config('app.name', 'PaNPaS') }}</h2>
                <span>Visualiza todas las recetas disponibles</span>
                <span>Ingresa las tuyas. Vota las de otros usuarios</span>
            </div>
        </header>

        {{-- Panel-de-Recetas --}}
        <section id="ranking">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-12 text-center">
                        <div id="secc-cabecera" class="card text-white">
                            <div class="d-flex justify-content-between m-1">
                                <h1 class="p-2">Recetas</h1>
                                <div class="p-2">
                                    <form class="form-inline mt-2" action="/buscarReceta" method="post">
                                        <input class="form-control mr-sm-2" type="text" placeholder="Término..." name="buscador">
                                        <button class="btn btn-info" type="submit" name="buscadorSubmit">Buscar</button>
                                    </form>
                                </div>
                                <div class="p-2"><button class="btn btn-info mt-2" data-toggle="modal" data-target="#recetaInsModal" title="Registrar una receta">Nueva</button></div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (isset($busqueda))
                <div class="row">
                    <div class="col-12 mb-2">
                        <h2>Resultado de la búsqueda... "{{ $busqueda }}"</h2>
                    </div>
                </div>
                @endif

                <div class="row">

                @foreach($recetas as $receta)

                    <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 ranking-item">
                        <a class="ranking-link" href="/receta/{{$receta->titulo}}">
                            <div class="ranking-hover" title="Preparar {{ $receta->titulo }}">
                                <div class="ranking-hover-content">
                                    <i class="fas fa-plus fa-3x"></i>
                                </div>
                            </div>
                            <img class="img-fluid" src="{{ $receta->imagen }}" title="{{ $receta->titulo }}">
                        </a>
                        <div class="ranking-caption">
                            <h4>
                                {{ $receta->titulo }}
                            </h4>
                            <p class="text-muted">por <a href="/{{ $receta->user->username }}" title="Ver perfil de {{ $receta->user->username }}" class="link-marco">{{ $receta->user->username }}</a></p>
                            <h5 class="stars-votos" title="{{ $receta->titulo }} tiene {{ $receta->votos }} votos">

                            @if (Auth::user()->username != $receta->user->username)
                                {{-- Si el usuario no coincide con el de la receta --}}

                                @if(Auth::user()->favoritos->contains('id', $receta->id)) {{-- si ya la tiene en favoritos --}}
                                    <a href="unfav/{{ $receta->id }}"><i class="fas fa fa-star fa-lg" title="Votar-" style="color: red;"></i> </a>
                                @else {{-- si no la tiene en favoritos --}}
                                    <a href="fav/{{ $receta->id }}"><i class="fas fa-star fa-lg" title="Votar+"></i> </a>
                                @endif

                            @else
                                    <i class="fas fa-star fa-lg" title="No puedes votar una receta tuya"></i>
                            @endif
                                    {{ $receta->votos }}
                            </h5>
                        </div>
                    </div>

                @endforeach

                </div>
            </div>
        </section>
        {{-- Panel-de-Usuarios --}}
@endsection

{{-- ============================================================================ --}}
{{-- ============================================================================ --}}

@section('footer_scripts_content')
        {{-- MODAL INSERTAR-RECETA :: ini --}}
        <div class="modal fade" id="recetaInsModal" tabindex="-1" role="dialog" aria-labelledby="recetaInsModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">

                {{-- Modal content :: ini --}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="recetaInsModalLabel">Insertar Receta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="/insertarReceta" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="modal-body">
                        <p class="col-lg-12">
                            <label><strong>Título</strong></label>
                            <input type="text" name="titulo" class="col-lg-12 w3-input" required>
                        </p>
                        <p class="col-lg-12">
                            <label><strong>Descripción</strong></label>
                            <textarea name="descripcion" class="col-lg-12 w3-input" required></textarea>
                        </p>
                        <p class="col-lg-12">
                            <label><strong>Imagen</strong></label>
                            <input type="text" name="imagen" class="col-lg-12 w3-input" value="https://lorempixel.com/640/480/?14725" required>
                        </p>
                        <p class="col-lg-12">
                            <label><strong>Ingredientes</strong></label>
                            <textarea name="ingredientes" class="col-lg-12 w3-input" required></textarea>
                        </p>
                        <p class="col-lg-12">
                            <label><strong>Elaboración</strong></label>
                            <textarea name="elaboracion" class="col-lg-12 w3-input" required></textarea>
                        </p>
                    </div>

                    <div class="modal-footer">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" title="Cerrar ventana modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="btn_registro" title="Registrar receta">{{ __('Insertar') }}</button>
                        </span>
                    </div>
                    </form>
                </div>
                {{-- Modal content :: fin --}}

            </div>
        </div>
        {{-- MODAL INSERTAR-RECETA :: fin --}}

        {{-- jQuery, Bootstrap, jQuery Easing --}}
        <script src="{{ asset('js/app.js') }}"></script>

        {{-- Otros --}}
        <script src="{{ asset('js/agency.js') }}"></script>

        {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

         Librería de Notificaciones de alerta - JS :: ini --}}
        <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/alertify.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                    @if (isset($toast) != null)
                        alertify.set('notifier','position', 'top-right');
                        alertify.notify('Receta Insertada', 'success');
                    @endif
                });
        </script>
        {{-- Librería de Notificaciones de alerta - JS :: fin --}}
@endsection
