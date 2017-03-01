@extends('layouts.app')

@section('titulo', 'Criar anúncio')

@section('content')


@if(session()->has('message'))
<div class="alert alert-success">
    <strong>Sucesso!</strong> {{ session('message') }}
</div>
@endif
@if(session()->has('message-error'))
<div class="alert alert-danger">
    <strong>Ups!</strong> {{ session('message-error') }}
</div>
@endif



<div class="row">
    @if (count($errors) > 0)
    <div class="form-group {{ $errors->has('titulo') ? 'has-error' :'' }} col-md-12">
        <h3>Ups Tens alguns erros:</h3>
        <ul>
            @foreach ($errors->all() as $error)
            <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="form-group col-md-12">
        {!! Form::label('Categoria:') !!}
        {!! Form::text('path',$itemPath, ['disabled'=> 'true', 'class' => 'form-control']) !!}
    </div>

    {!! Form::model('postCriar', ['method' => 'POST', 'files' => true]) !!}
    <div class="form-group {{ $errors->has('titulo') ? 'has-error' :'' }} col-md-12">
        {!! Form::label('titulo', 'Titulo do Anuncio:') !!}
        {!! Form::text('titulo',old('titulo'), ['class' => 'form-control']) !!}
    </div>
    
    {!! Form::hidden('category_id', $category) !!}

    <div class="form-group {{ $errors->has('descricao') ? 'has-error' :'' }} col-md-12">
        {!! Form::label('descricao', 'Descrição do Anúncio:') !!}
        {!! Form::text('descricao',old('descricao'), ['class' => 'form-control']) !!}
    </div>

    <div class="form-group {{ $errors->has('images[]') ? 'has-error' :'' }} col-md-12">
        {!! Form::label('images', 'Imagens do Anúncio:') !!}
        {!! Form::file('images[]', ['multiple'=> 'true']) !!}
    </div>


    <div class="col-md-12 pull-right" style="text-align:center;">
        {!! Form::submit('Criar Produto', ['class' => 'btn btn-info col-md-4 col-sm-8 pull-right']) !!}
    </div>

    {!! Form::close() !!}
</div>

@endsection