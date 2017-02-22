@extends('layouts.app')

@section('titulo', 'Admin Painel')

@section('content')
<div class="container"> 
	<!-- Gestão de utilizadores -->
	<div class="col-md-12">    
		<div class="panel panel-primary">
			<div class="panel-heading">Editar utilizadores</div>
	  			<div class="panel-body">
	  				<div class="row">
	  					<div class="col-md-12"> 
				            <table class="table table-striped table-bordered table-list">
			                  <thead>
			                    <tr>
			                        <th class="hidden-xs">ID</th>
			                        <th>Name</th>
			                        <th>Username</th>
			                        <th>Email</th>
			                        <th><em class="fa fa-cog"></em> Ações</th>
			                    </tr> 
			                  </thead>
			                    <tbody>

			                    @foreach($users as $user)
			                    	<tr>
			                            <td class="hidden-xs">{{ $user->id }} </td>
			                            <td>{{ ucfirst($user->name) }}&nbsp;{{ ucfirst($user->last_name) }}</td>
			                            <td><a href="{{ URL::to('/u/') .'/'. $user->username }}">{{ $user->username }}</a></td>
			                            <td>{{ $user->email }}</td>
			                            <td align="center">
			                              <a class="btn btn-default"><em class="fa fa-pencil"></em></a>
			                              <a class="btn btn-danger"><em class="fa fa-trash"></em></a>
			                            </td>
			                          </tr>
			                    @endforeach

			                    </tbody>
							</table>
	  					</div>
	  				</div>
	  			</div>
	  	</div>
  	</div>
  	<!-- end Gestão de utilizadores -->
  	<!-- Gestão de Produtos -->
  		<div class="col-md-6">    
		<div class="panel panel-primary">
			<div class="panel-heading">Editar Produtos</div>
	  			<div class="panel-body">
	  				<div class="row">
	  					<div class="col-md-12"> 
	  						<h1>Gestão de Produtos!</h1>
	  					</div>
	  				</div>
	  			</div>
	  	</div>
  	</div>
  	<!-- end Gestão de Produtos -->
  	<!--  Gestão de categorias -->
	<div class="col-md-6">    
		<div class="panel panel-primary">
			<div class="panel-heading">Editar categorias</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-12"> 
							<h1>Gestão de categorias</h1>
						</div>
					</div>
				</div>
		</div>
	</div>
  	<!-- end Gestão de catgorias -->
</div>
@endsection