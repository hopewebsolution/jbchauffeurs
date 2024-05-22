@extends('masters/master')
@section('title', 'Login')
@section('content')
<div id="midwrap1">
    <div class="container">
        <div class="cntblock">
            <div class="pg-title"><h1>Customer Account Login</h1></div>
            <div class="row">
               <div class="col-md-8 col-sm-8">
                    <div class="member-login">
                        {!! Form::open(['route'=>['user.login'],'id'=>'form']) !!}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach   
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="input-group email-input">
                                    <div class="input-group-addon email-login">Email</div>
                                    {!! Form::email('email','',['class'=>'form-control','required'=>'required','placeholder'=>"Email"]) !!}
                                    <div class="input-group-addon"><span class="fa fa-users"> </span></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">Password</div>
                                    {!! Form::password('password',['class'=>'form-control pass-control','required'=>'required','placeholder'=>"Password"]) !!}
                                    <div class="input-group-addon"><span class="fa fa-key"> </span></div>
                                </div>
                            </div>
                            <div class="buttons">
                                <a href="{{route('user.forgetPwd')}}">Forgot Password?</a>
                                <a style="float: left; clear: both;" href="{{route('user.signupForm')}}">Need an account? Sign up</a>
                                <input class="submit pull-right" type="submit" value="Login" />
                                <div class="clear"> </div>
                            </div>
                        {!! Form::close() !!}
                        <div class="clear"></div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    @include('sidebar')
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-scripts')
    
@endpush