@extends('layouts.app')
@section('titulo', 'Bem-vindo')

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

@if(Auth::guest())
<a href="{{ url('/login') }}">Clica aqui</a> para fazeres o login!
@else
<div class="row">
    <div class="col-md-6 col-sm-8 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">Os teus anúncios</div>
            <div class="panel-body">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                        </tr>
                        <tr>
                            <td>Mary</td>
                            <td>Moe</td>
                            <td>mary@example.com</td>
                        </tr>
                        <tr>
                            <td>July</td>
                            <td>Dooley</td>
                            <td>july@example.com</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endsection