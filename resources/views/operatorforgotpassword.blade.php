@extends('masters/master')
@section('title', 'Login')
@section('content')
<div class="container">
    <div class="row login-container recovery-password">
        <div class="col-lg-8 col-md-12">
            <div class="member-login-center">
                <div class="login-box form-heading">
                    <h3>Password recovery</h3>
                    <!-- @if ($errors->has('sendResetLinkEmail'))
                    <div class="alert alert-danger">
                        {{ $errors->first('sendResetLinkEmail') }}
                    </div>
                @endif -->
                @if ($errors->has('operatorloginsubmit'))
                    <div class="alert alert-danger">
                        {{ $errors->first('operatorloginsubmit') }}
                    </div>
                @endif
                @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

                    <form action="{{ route('password.email.link') }}" method="post">
                        @csrf
                        <div class="form-group text-left">
                            <label for="account-id">Please enter your Account ID</label>
                            <input type="text" class="form-control" id="email"  placeholder="Enter the email" name="email" >
                            <span class="invalid-feedback">This field is required.</span>
                            @error('email')
                           <strong class="text-danger" style="font-size: 15px;">{{ $message }}</strong>
                           @enderror
                        </div>
                        
                        <button type="submit" class="login-btn">Submit</button>
                    </form>
                  
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('footer-scripts')

@endpush