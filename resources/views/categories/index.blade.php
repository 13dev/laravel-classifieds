@extends('layouts.app')

@section('titulo','Categorias')
@section('extra-style','<link rel="stylesheet" href="assets/css/messages.css">')

@section('content')

<div class="container">     
    <div class="panel panel-primary">
        <div class="panel-heading">Editar categorias</div>
        <div class="panel-body">
            <div class="row">

                <div class="col-md-12">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-warning alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>	
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <h3>Lista das categorias</h3>
                    <ul>
                        @if(count($allCategories))

                        @foreach($allCategories as $category)
                        <li>
                            {{ $category }}

                        </li>
                        @endforeach
                        @else
                        <div class="alert alert-warning alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                            <strong>Nenhuma categoria!</strong>
                        </div>
                        @endif

                    </ul>
                </div>

                <div class="col-md-6">
                    <h3>Adicionar nova categoria:</h3>

                    {!! Form::open(['route'=>'addCategory']) !!}

                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                        {!! Form::label('Titulo:') !!}
                        {!! Form::text('title', old('title'), ['class'=>'form-control', 'placeholder'=>'Titulo da categoria']) !!}
                        <span class="text-danger">{{ $errors->first('title') }}</span>
                    </div>

                    <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                        {!! Form::label('Categoria:') !!}

                        <select class="form-control" name="parent_id">
                            <option selected="selected" value="">Selecione uma categoria: </option>
                            @foreach($allCategoriesSelect as $category)
                            <option value="{{ $category['value'] }}">{{ $category['title'] }}</option>
                            @endforeach
                        </select>

                        <span class="text-danger">{{ $errors->first('id') }}</span>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success">Adicionar</button>
                    </div>

                    {!! Form::close() !!}


                </div>
                <div class="col-md-12">
                    <hr>
                    <h2>Remover categoria <small> Ao remover uma categoria todos os descendentes serão removidos!</small></h2>

                    {!! Form::open(['route'=>'deleteCategory']) !!}

                    <div class="form-group {{ $errors->has('id') ? 'has-error' : '' }}">
                        {!! Form::label('Categoria:') !!}
                        <select class="form-control" name="id">
                            <option selected="selected" value="">Selecione uma categoria para remover: </option>
                            @foreach($allCategoriesSelect as $category)
                            <option value="{{ $category['value'] }}">{{ $category['title'] }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('id') }}</span>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-danger">Remover</button>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('extra-script')
