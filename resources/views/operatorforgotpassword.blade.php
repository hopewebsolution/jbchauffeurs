@extends('masters/master')
@section('title', 'Login')
@section('content')
<div class="container">
    <div class="row login-container recovery-password">
        <div class="col-lg-8 col-md-12">
            <div class="member-login-center">
                <div class="login-box form-heading">
                    <h3>Password recovery</h3>
                    
                    <form id="form">
                        <div class="form-group text-left">
                            <label for="account-id">Please enter your Account ID</label>
                            <input type="text" class="form-control" id="account-id" name="account-id" required>
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