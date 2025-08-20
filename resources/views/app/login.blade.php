
@extends('layouts.container')
  @section('content')

    <div class="form-container p-5">
      <div class="text-center">
          
          <img src="{{asset('app/img/graduation-cap.png')}}" width="80" height="80">
          <h4 class="h4 mb-3 text-info" >
              Theschool  
          </h4>
      </div>
      @if(session()->has('message'))
          <div class="col-md-12 col-sm-12 alert
          alert-danger alert-dismissable text-center" style="margin-top:20px">
            <a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a>
            <strong>
                Danger
            </strong>
            {{session('message')}}
          </div>
      @endif                                   
      <form class="user d-form" action="/login" method="post" novalidate >
        <input name="_token" type="hidden" value="{{ csrf_token() }}">
        <div class="form-group">
          <input type="email" name="email" class="form-control form-control-user p-4" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
            <span class="text-danger">
              @if($errors->has('email'))
                {{ $email= $errors->first('email')}}
              @else
                {{$email=''}}                            
              @endif
            </span> 
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control form-control-user p-4" id="exampleInputPassword" placeholder="Password">
            <span class="text-danger">
              @if($errors->has('password'))
                {{ $password=$errors->first('password')}} 
              @else
                {{$password=''}}                            
              @endif
            </span> 
        </div>
        <div class="form-grounp">
          <div class="custom-control custom-checkbox small">
            <input type="checkbox" name='remember_me' class="custom-control-input" id="customCheck">
            <label class="custom-control-label" for="customCheck">Remember Me</label>
          </div>
        </div>
        <button type="submit"  class="btn btn-info btn-user btn-block py-3">
          Login
        </button>
        <!--<a href="index.html" class="btn btn-google btn-user btn-block">
          <i class="fab fa-google fa-fw"></i> Login with Google
        </a>
        <a href="index.html" class="btn btn-facebook btn-user btn-block">
          <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
        </a>-->
      </form>
      <hr>
      <div class="text-center justify-content-around">
        <a class="small" style="color:grey" href="/signup">Create Account</a>
        <a class="small" href="/forgot-password">Forgot Password?</a>
      </div>                  

    </div>

@endsection


