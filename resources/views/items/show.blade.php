@extends('layouts.app')

@section('titulo') {{ $item->titulo }} @endsection

@section('content')
<ul>
	<li class="item">ID:
		<b>{{ $item->id }}</b>
	</li>
	<li class="item">USER:
		<b>{{ $item->user->name }}</b>
	</li>
	<li class="item">TITULO
		<b>{{ $item->titulo }}</b>
	</li>
	<li class="item">DESCRIÇÃO
		<b>{{ $item->descricao }}</b>
	</li>
	<li>
		informações do usuario!
		<ul>
			<li>Nome: <b>{!! $item->user->name !!}</b></li>
			<li>Ultimo Nome: <b>{!! $item->user->last_name !!}</b></li>
			<li>Username: <b>{!! $item->user->username !!}</b></li>
			<li>Membro desde: <b>{!! date('d/m/Y h:i:s',strtotime($item->user->created_at)) !!}</b></li>
			<li>Email: <b>{!! $item->user->email !!}</b></li>
		</ul>
		
	</li>
	<li>
		IMAGES: <b>{{ count($item->images) }} imagens</b>  
		<ul>
		@foreach( $item->images as $imagem )
			<li>
				{{ $imagem->path }} - ID : {{ $imagem->id }} - ITEM_ID: {{ $imagem->item_id }}
			</li>

			<img src=" {{ url('/') }} /content/anuncios/{{ $imagem->path }}" width="300">
		
		@endforeach
		</ul>

		<b></b>
	</li>
</ul>

@endsection