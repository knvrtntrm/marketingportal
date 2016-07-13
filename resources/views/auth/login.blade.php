@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">

        <div class="col-md-4 col-md-offset-4">

            <div class="login-box {{ $errors->has('email') ? ' animated jello' : '' }} {{ $errors->has('password') ? ' animated jello' : '' }}" style="padding: 40px;
    border: 1px solid #E8E8E8;">
                <div class="login-logo">
                    <img src="{{ asset('images/km.png') }}" style="    margin: 0 auto;
    display: block;
    margin-bottom: 20px;" />
                </div><!-- /.login-logo -->
                <div class="login-box-body">
                    
                    <form action="{{ url('/login') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group has-feedback ">
                            <input type="email" class="form-control" placeholder="Email" value="{{ old('email') }}" name="email">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="password" class="form-control" placeholder="Password" name="password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="checkbox icheck">
                                    <label>
                                        <input type="checkbox"> Onthoud mij
                                    </label>
                                </div>
                            </div><!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Log in</button>
                            </div><!-- /.col -->
                        </div>
                    </form>

                    <!--<div class="social-auth-links text-center">
                        <p>- OR -</p>
                        <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
                        <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
                    </div><!-- /.social-auth-links -->

                    <!--<a href="#">I forgot my password</a><br>
                    <a href="register.html" class="text-center">Register a new membership</a>-->

                </div><!-- /.login-box-body -->
            </div><!-- /.login-box -->

      </div>
    </div>
</div>
@endsection
