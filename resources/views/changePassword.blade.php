@extends('app.master')
@section('content')
<main id="main" class="main">
<div class="container">
    <div class="row login-container recovery-password">
        <div class="col-lg-8 col-md-12">
            <div class="member-login-center">
                <div class="login-box form-heading">
                    <h3>Change Password</h3>
                    
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form id="form" method="POST" action="{{ route('change.password') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group text-left">
                            <label for="current-password">Current Password</label>
                            <div class="password-container">
                                <input type="password" class="form-control" id="current-password" value="{{ old('current_password') }}" name="current_password" placeholder='Enter your current password'>
                                <span class="toggle-password" data-target="#current-password">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path>
                                    </svg>
                                </span>
                                @error('current_password')
                                    <strong class="text-danger" style="font-size: 15px;">{{ $message }}</strong>
                                @enderror  
                            </div>
                        </div>

                        <div class="form-group text-left">
                            <label for="new-password">New Password</label>
                            <div class="password-container">
                                <input type="password" class="form-control" id="new-password" value="{{ old('password') }}" name="password" placeholder='Enter new password'>
                                <span class="toggle-password" data-target="#new-password">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path>
                                    </svg>
                                </span>
                                @error('password')
                                    <strong class="text-danger" style="font-size: 15px;">{{ $message }}</strong>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group text-left">
                            <label for="confirm-password">Confirm Password</label>
                            <div class="password-container">
                                <input type="password" class="form-control" id="confirm-password" name="password_confirmation" placeholder='Confirm new password'>
                                <span class="toggle-password" data-target="#confirm-password">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path>
                                    </svg>
                                </span>
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
</main>

<script>
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordField = document.querySelector(targetId);
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
        });
    });
</script>
@endsection
