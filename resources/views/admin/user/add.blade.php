@extends('layouts.app')

@section('titulo', 'Adicionar utilizadores')

@section('content')
<div class="container"> 
    <!-- Gestão de utilizadores -->
    <div class="col-md-12">    
        <div class="panel panel-primary">
            <div class="panel-heading">Adicionar utilizador</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">

                        @if(session()->has('message'))
                        <div class="alert alert-success">
                            <strong>Sucesso!</strong> {{ session('message') }}
                        </div>
                        @endif

                        <div class="row">
                            {!! Form::model('addUser', ['method' => 'POST', 'autocomplete' => 'false']) !!}
                            {!! csrf_field() !!}

                            <div class="form-group {{ $errors->has('username') ? 'has-error' :'' }} col-md-6">
                                {!! Form::label('username', 'Username:') !!}
                                {!! Form::text('username', old('username'), ['class' => 'form-control']) !!}
                                {!! $errors->first('username','<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' :'' }} col-md-6">
                                {!! Form::label('name', 'Nome:') !!}
                                {!! Form::text('name',old('name'), ['class' => 'form-control']) !!}
                                {!! $errors->first('name','<span class="help-block">:message</span>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('last_name') ? 'has-error' :'' }} col-md-6">
                                {!! Form::label('last_name', 'Ultimo Nome:') !!}
                                {!! Form::text('last_name',old('last_name'), ['class' => 'form-control']) !!}
                                {!! $errors->first('last_name','<span class="help-block">:message</span>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('email') ? 'has-error' :'' }} col-md-6">
                                {!! Form::label('email', 'E-Mail:') !!}
                                {!! Form::text('email',old('email'), ['class' => 'form-control']) !!}
                                {!! $errors->first('email','<span class="help-block">:message</span>') !!}
                            </div>
                            
                            <div class="form-group {{ $errors->has('password') ? 'has-error' :'' }} col-md-6">
                                {!! Form::label('password', 'Password:') !!}
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                                {!! $errors->first('password','<span class="help-block">:message</span>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' :'' }} col-md-6">
                                {!! Form::label('password_confirmation', 'Confirmar password:') !!}
                                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                                {!! $errors->first('password_confirmation','<span class="help-block">:message</span>') !!}
                            </div>

                            <div class="col-md-12 pull-right" style="text-align:center;">
                                {!! Form::submit('ADICIONAR UTILIZADOR', ['class' => 'btn btn-success col-md-4 col-sm-8 pull-right']) !!}
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection