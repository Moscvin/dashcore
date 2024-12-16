@extends('core.layouts.auth')

@section('content')
    <!-- Theme style -->
    <div class="container">
        <div class="login-box">
            <div class="login-logo">
                <a href="/" style="color:#FFFFFF"><img src="{{config('login_logo_url')}}" alt="logo"></a>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Effettua il login</p>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} {{ $errors->has('username') ? ' has-error' : '' }}">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-user"></i></span>
                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}"
                                required autofocus placeholder="username or email">
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif

                    </div> <!-- form group-->
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-lock"></i></span>
                            <input id="password" type="password" class="form-control" name="password" required
                                placeholder="password">
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div> <!-- form group-->
                    <div class="row">
                        <div class="col-xs-8">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ricordami!
                        </div><!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Entra</button>
                        </div><!-- /.col -->
                    </div><!-- row-->
                    <a href="{{ route('first-login') }}">Primo accesso</a><br>
                    <a href="{{ route('retrieve-password') }}" class="text-center">Reimposta la password</a>
                </form>
            </div>
        </div>
    </div>
@endsection
