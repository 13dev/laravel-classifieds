@extends('layouts.app')

@section('titulo', 'Editar perfil')

@section('content')

@if(session()->has('message'))
<div class="alert alert-success">
	<strong>Sucesso!</strong> {{ session('message') }}
</div>
@endif
<div class="row">
{!! Form::model('postEditar', ['method' => 'POST', 'autocomplete'=>'false']) !!}
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

	<div class="form-group {{ $errors->has('password') ? 'has-error' :'' }} col-md-6">
		{!! Form::label('password', 'Password:') !!}
		<input type="password" name="password_fake" id="password_fake" class="hidden" autocomplete="off" style="display: none;">
		<input type="password" name="password" id='password' autocomplete="new-password" class="form-control">
		
	</div>

	<div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' :'' }} col-md-6">
		{!! Form::label('password_confirmation', 'Confirm Password:') !!}
		{!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
		{!! $errors->first('password_confirmation','<span class="help-block">:message</span>') !!}
	</div>
	<div class="col-md-12 pull-right" style="text-align:center;">
		{!! Form::submit('EDITAR PERFIL', ['class' => 'btn btn-info col-md-4 col-sm-8 pull-right']) !!}
	</div>

{!! Form::close() !!}
</div>

@endsection