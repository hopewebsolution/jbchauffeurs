@extends('masters/master')
@section('title', 'Change Password')
@section('content')
<div id="midwrap1">
    <div class="container">
        
        @include('customerNav')
        <div class="search-holder">&nbsp;&nbsp;<strong>Change Password</strong></div>
        @if(session()->has('success'))
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="alert alert-success">
                        <strong>{{ session('success') }}</strong>
                    </div>
                </div>
            </div>
        @endif 
        @if(session()->has('error'))
            <div class="row justify-content-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="alert alert-danger">
                        <strong>{{ session('error') }}</strong>
                    </div>
                </div>
            </div>
        @endif    
        {!! Form::open(['route'=>['user.updatePwd'],'class'=>'form-horizontal bookfrm','id'=>'register']) !!}
        <div class="row" id="frm-holder">
            <div class="col-sm-6">
            <div class="form-group">
                <label for="inputPasswordCurrent">Old Password:</label>
                <input type="password" class="form-control"  name="old_password" value="">
                <span class="hws_error text-right text-danger">{{ $errors->first('old_password') }}</span>
            </div>
            <div class="form-group">
                <label for="inputPasswordCurrent">New Password:</label>
                <input type="password" class="form-control" name="password" value="">
                <span class="hws_error text-right text-danger">{{ $errors->first('password') }}</span>
            </div>
            <div class="form-group">
                <label for="inputPasswordCurrent">Confirm Password:</label>
                <input type="password" class="form-control" name="conf_password" value="">
                <span class="hws_error text-right text-danger">{{ $errors->first('conf_password') }}</span>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="submit" value="Submit">
            </div>
            </div>
        </div>
        {!! Form::close() !!}
           
        </div>
        
    </div>
</div>
@endsection
@push('footer-scripts')
    
@endpush