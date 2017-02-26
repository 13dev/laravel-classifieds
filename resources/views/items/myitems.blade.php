@extends('layouts.app')

@section('titulo', 'Meus anúncios')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(!count($items))
                <h1> Não tens Anuncios online! </h1>
            @else
                <table class="table table-striped table-bordered table-list">
                    <thead>
                        <tr>
                            <th class="hidden-xs">ID</th>
                            <th>Titulo</th>
                            <th>Descrição</th>
                            <th>Categoria</th>
                        </tr> 
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td class="hidden-xs">{{ $item->id }} </td>
                            <td>{{ ucfirst($item->titulo) }}</td>
                            <td>{{ $item->descricao }}</td>
                            <td>{{ $item->category->title }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $itemsPagin->render() }}
            @endif
        </div>
    </div>
</div>

@endsection