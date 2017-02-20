@extends('layouts.app')

@section('titulo') {{ $user->name }} @endsection

@section('content')
<h1>OLÁ {{ $user->name }}</h1>
<ul>
	<li>Nome: <b>{!! $user->name !!}</b></li>
	<li>Ultimo Nome: <b>{!! $user->last_name !!}</b></li>
	<li>Username: <b>{!! $user->username !!}</b></li>
	<li>Membro desde: <b>{!! date('d/m/Y h:i:s',strtotime($user->created_at)) !!}</b></li>
	<li>Email: <b>{!! $user->email !!}</b></li>
</ul>
<h1>Anúncios:</h1>
<hr>

<div class="itens">
	@foreach($user->item as $item)
	
		<span class="id">ID: <a href="/a/{{ $item->slug }}">{{ $item->id }}</a></span><br>
		<span class="titulo">Titulo: {{ $item->titulo }}</span><br>
		<span class="descricao">Descrição: {{ $item->descricao }}</span><br>
		<span class="created_at">Criado em: {{ date('d/m/Y h:i:s',strtotime($item->created_at)) }}</span><br>
		<span class="images">Imagens:</span>
		<ul>
		@foreach($item->images as $img)
			<span class="path"><li>{{ $img->path }}</li></span>
		@endforeach
		</ul>
		
		<hr>
	@endforeach
	
</div>


@endsection