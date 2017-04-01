@extends('layouts.app')

@section('titulo', 'Editar utilizadores')

@section('content')
<div class="container"> 
    <!-- Gestão de utilizadores -->
    <div class="col-md-12">    
        <div class="panel panel-primary">
            <div class="panel-heading">Editar utilizador</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        
                        @if(session()->has('message'))
                        <div class="alert alert-success">
                            <strong>Sucesso!</strong> {{ session('message') }}
                        </div>
                        @endif
                        
                        <div class="row">
                            {!! Form::model('editUser', ['method' => 'POST', 'autocomplete'=>'false']) !!}
                            {!! csrf_field() !!}

                            <div class="form-group {{ $errors->has('name') ? 'has-error' :'' }} col-md-6">
                                {!! Form::label('name', 'Nome:') !!}
                                {!! Form::text('name',$user->name, ['class' => 'form-control']) !!}
                                {!! $errors->first('name','<span class="help-block">:message</span>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('last_name') ? 'has-error' :'' }} col-md-6">
                                {!! Form::label('last_name', 'Ultimo Nome:') !!}
                                {!! Form::text('last_name',$user->last_name, ['class' => 'form-control']) !!}
                                {!! $errors->first('last_name','<span class="help-block">:message</span>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('email') ? 'has-error' :'' }} col-md-12">
                                {!! Form::label('email', 'E-Mail:') !!}
                                {!! Form::text('email',$user->email, ['class' => 'form-control']) !!}
                                {!! $errors->first('email','<span class="help-block">:message</span>') !!}
                            </div>
                            
                            <div class="col-md-12 pull-right" style="text-align:center;">
                                {!! Form::submit('EDITAR PERFIL', ['class' => 'btn btn-info col-md-4 col-sm-8 pull-right']) !!}
                            </div>
                            
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection