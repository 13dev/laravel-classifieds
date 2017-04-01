@extends('layouts.app')

@section('titulo', 'Criar conta')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Register 
                </div>
                <div class="panel-body">
                    @if(!session()->has('message'))
                    <form action="{{ url('/register') }}" class="form-horizontal" method="POST" role="form">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">
                                Name
                            </label>
                            <div class="col-md-6">
                                <input class="form-control" name="name" type="text" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>
                                            {{ $errors->first('name') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">
                                Last name
                            </label>
                            <div class="col-md-6">
                                <input class="form-control" name="last_name" type="text" value="{{ old('last_name') }}">
                                    @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>
                                            {{ $errors->first('last_name') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">
                                username
                            </label>
                            <div class="col-md-6">
                                <input class="form-control" name="username" type="text" value="{{ old('username') }}">
                                    @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>
                                            {{ $errors->first('username') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">
                                E-Mail Address
                            </label>
                            <div class="col-md-6">
                                <input class="form-control" name="email" type="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>
                                            {{ $errors->first('email') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">
                                Password
                            </label>
                            <div class="col-md-6">
                                <input class="form-control" name="password" type="password">
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>
                                            {{ $errors->first('password') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">
                                Confirm Password
                            </label>
                            <div class="col-md-6">
                                <input class="form-control" name="password_confirmation" type="password">
                                    @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>
                                            {{ $errors->first('password_confirmation') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-btn fa-user">
                                    </i>
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                    @elseif(session()->has('message'))
                    <div class="alert alert-success">
                        <strong>
                            Parabéns!
                        </strong>
                        {{ session('message') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
