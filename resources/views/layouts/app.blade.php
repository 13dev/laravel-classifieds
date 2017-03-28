<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('titulo') - Vendas Madeira</title>
    <!-- Fonts 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">-->
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="shortcut icon" href="#" type="image/x-icon">

    <style>
        body {
            font-family: "Raleway","Lato","Helvetica Neue",Helvetica,Arial,sans-serif;
            color:#00587F;
        }
        .btn-link {
            color: #002C40;
        }

        .fa-btn {
            margin-right: 6px;
        }
        #logotipo {
            margin: 20px 0px 10px 0px;
        }
        .btn-header {
            margin-top: 35px;
        }
    </style>
    @yield('extra-style')
</head>
<?php
$count = 0;
if(!Auth::guest()){
    Nahid\Talk\Facades\Talk::setAuthUserId(Auth::user()->id);
    
    foreach(Nahid\Talk\Facades\Talk::getInbox() as $m){
        if($m->thread->is_seen == 0 && $m->thread->user_id != Auth::user()->id){
           $count++;
        }
    } 
}

?>
<body id="app-layout">
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <img id="logotipo" src="#" alt="Logotipo Madeira Vendas"><BR>
            <span id="slogan">PUBLIQUE AQUI É GRATIS</span>
        </div>
        <div class="col-md-4">
            <div class="btn-header">
                <div class="btn-group btn-group-justified">
                    <a href="#" class="btn btn-primary">CRIAR UMA CONTA</a>
                    <a href="#" class="btn btn-info">REGISTAR-ME</a>
                </div>
            </div>
        </div>
    </div>
</div>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    VENDAS MADEIRA
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">INÍCIO</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())

                        <li><a href="{{ url('/login') }}">ENTRAR</a></li>
                        <li><a href="{{ url('/register') }}">REGISTAR-ME</a></li>
                        
                    @else


                    <li><a href="{{ url('/a/add/item') }}">PUBLICAR ANÚNCIO</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }}<span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/u/'.Auth::user()->name) }}"><i class="fa fa-btn fa-eye"></i>Ver perfil</a></li>
                                <li><a href="{{ url('/perfil') }}"><i class="fa fa-btn fa-wrench"></i>Editar Perfil</a></li>
                                <li><a href="{{ url('/a/view/myitems') }}"><i class="fa fa-btn fa-wrench"></i>Meus anuncios</a></li>
                                <li><a href="{{ url('/m/') }}"><i class="fa fa-btn fa-envelope"></i>Mensagens <span class="badge"> {{ $count }}</span></a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Sair</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
<div class="container">
    @if($count > 0)
<div class="alert alert-success">
    @if($count == 1)
    <strong>Nova Mensagem</strong> 
    @else
    <strong>Novas Mensagens</strong> 
    @endif
    Reveja a aba 'Mensagens' para ver as suas novas mensagens!
</div>
@endif
    @yield('content')
</div>
    <footer>
        @yield('footer')
    </footer>
    <!-- JavaScripts -->
    <script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    @yield('extra-script')
</body>
</html>
