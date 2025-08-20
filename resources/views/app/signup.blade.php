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
        alert-success alert-dismissable text-center text-small" style="margin-top:20px">
          <a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a>
          <strong>
              Success
          </strong>
          {{session('message')}}
        </div>
    @endif
    @if(session()->has('errorMessage'))
        <div class="offset-md-1 col-md-10 offset-sm-1 col-sm-10 alert
        alert-danger alert-dismissable text-center text-small" style="margin-top:20px">
          <a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a>
          <strong>
              Danger
          </strong>
          {{session('errorMessage')}}
        </div>
    @endif                   
    <form class="user" action="/signup" method="post" novalidate >
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
      <button type="submit"  class="btn btn-info btn-user btn-block py-3">
        Signup
      </button>
    </form>
    <hr>
    <div class="text-center justify-content-around">
      <a class="small" style="color:grey" href="/login">Login</a>
      <a class="small" href="forgot-password.html">Forgot Password?</a>
    </div>  
  </div>
@endsection