@extends('masters/master')
@section('content')
<div class="container">
    <div class="row login-container recovery-password">
        <div class="col-lg-8 col-md-12">
            <div class="member-login-center">
                <div class="login-box form-heading">
                    <h3>Reset Password</h3>
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
                    
                    <form action="{{ route('forget.password.store') }}" method="post">
                        @csrf
                        <div class="form-group text-left">
                            <label for="email">Please enter your Email ID</label>
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="text" class="form-control mt-3" id="email" name="email">
                            <span class="invalid-feedback">This field is required.</span>
                            @error('email')
                                <strong class="text-danger" style="font-size: 15px;">{{ $message }}</strong>
                            @enderror 
                            <br>
                            <br>
                            <label for="password">Please enter your new Password</label>
                            <div class="password-container">
                                <input type="password" class="form-control mt-3" id="password" name="password">
                                <span class="toggle-password">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                    </svg>
                                </span>
                                <span class="invalid-feedback">This field is required.</span>
                                @error('password')
                                    <strong class="text-danger" style="font-size: 15px;">{{ $message }}</strong>
                                @enderror
                            </div>
                            <br>
                            <br>
                            <label for="password_confirmation">Please confirm your Password</label>
                            <div class="password-container">
                                <input type="password" class="form-control mt-3" id="password_confirmation" name="password_confirmation">
                                <span class="toggle-password">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                    </svg>
                                </span>
                                <span class="invalid-feedback">This field is required.</span>
                                @error('password_confirmation')
                                    <strong class="text-danger" style="font-size: 15px;">{{ $message }}</strong>
                                @enderror 
                            </div>
                        </div>
                        
                        <button type="submit" class="login-btn">Submit</button>
                    </form>
                  
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(item => {
        item.addEventListener('click', function() {
            const passwordField = this.previousElementSibling;
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
        });
    });
</script>
@endsection
@push('footer-scripts')

@endpush
