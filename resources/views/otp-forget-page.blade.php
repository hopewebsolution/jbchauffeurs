@extends('masters/master')
@section('content')
<div class="container">
    <div class="row login-container recovery-password">
        <div class="col-lg-8 col-md-12">
            <div class="member-login-center">
                <div class="login-box form-heading">
                    <h3>Password recovery</h3>
                    
                    <form action="{{route('forget.password.store')}}" method="post">
                        @csrf
                        <div class="form-group text-left">
                            <label for="account-id">Please enter your Email ID</label>
                            <input type="hidden" name="token" value="{{$token}}">
                            <input type="text" class="form-control mt-3" id="email" name="email" required>
                            <br>
                            <br>
                            <label for="account-id">Please enter your new  Password</label>
                            <input type="password" class="form-control mt-3" id="password" name="password" required>
                            <br>
                            <br>
                            <label for="account-id">Please confirm your  Password</label>
                            <input type="password" class="form-control mt-3" id="password_confirmation" name="password_confirmation" required>
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