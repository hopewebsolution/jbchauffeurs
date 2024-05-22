<!DOCTYPE html>
<html lang="en-US" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!--  
    Document Title
    =============================================
    -->
    <title>{{ config('app.name', 'Laravel') }} Admin | Forget Password </title>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Default stylesheets-->
    <link href="{{ asset('public/assets/admin_assets/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('public/assets/admin_assets/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/admin_assets/css/custom.min.css')}}" rel="stylesheet">
  </head>
  <body class="login">
    <div>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            {!! Form::open(['route' => 'password.email','class'=>'login_form','id'=>'login_form']) !!}
              @if ($errors->any())
                  <div class="alert alert-danger">
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach   
                  </div>
              @endif
              <h1>Reset Password</h1>
              <div class="form-group">
                <label for="email1">Email address</label>
                {!! Form::email('email','',['class'=>'form-control','id'=>'email','placeholder'=>'Enter Email','required'=>'required']) !!} 
              </div>
             
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="position:relative;padding:0px;">
                <div class="form-group">
                  <input type="submit" class="btn btn-sm btn-lg btn-primary hws_btn" value="Submit" style="width: 100%;padding: 10px;font-size: 16px;">
                </div>
              </div>
              {!! Form::close() !!}
            </section>
        </div>
      </div>
    </div>
  </body>
</html>