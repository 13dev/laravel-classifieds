@extends('layouts.app')

@section('titulo', 'Eliminar Utilizador')

@section('content')
<div class="container"> 
    <!-- Gestão de utilizadores -->
    <div class="col-md-12">    
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <h1 style="text-align: center;">Eliminar Utilizador - {{ ucfirst($user->username) }}<br/><small> Ao realizar esta ação todo relacionado a este utilizador sera apagado!</small></h1>
                        <hr>
                        Informações do usuario!
                        <ul>
                            <li>Nome: <b>{!! $user->name !!}</b></li>
                            <li>Ultimo Nome: <b>{!! $user->last_name !!}</b></li>
                            <li>Username: <b>{!! $user->username !!}</b></li>
                            <li>Membro desde: <b>{!! date('d/m/Y h:i:s',strtotime($user->created_at)) !!}</b></li>
                            <li>Email: <b>{!! $user->email !!}</b></li>
                        </ul>
                        <div class="row">
                            {!! Form::model('deleteUser', ['method' => 'POST', 'autocomplete'=>'false']) !!}
                            {!! csrf_field() !!}
                            <div class="col-md-6 pull-right" style="text-align:center; padding:30px;">
                                {!! Form::submit('ELIMINAR', ['class' => 'btn btn-danger btn-block']) !!}
                            </div>

                            <div class="col-md-6 pull-left" style="text-align:center; padding:30px;">
                                <a href='{{ url('/admin/users') }}'>
                                    <input type='button' class='btn btn-info btn-block' value='NÃO ELIMINAR'>
                                </a>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection
