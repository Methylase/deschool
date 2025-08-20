@extends('layouts.container')
  @section('content')

  <div class="col-lg-6 col-md-5 col-sm-4 mb-5 col-xs-12 d-none d-lg-block text-left" style="border-right:2px solid #23abf4">

        <div class="p-5">
          <h4 class="h3 text-center" style="color:#23abf4">
            Register With Us Today
          </h4>                        
          <ul style="font-size:16px;color:#2F2E41" >
            <li><strong>Recording and Computing Result Made Easy.</strong></li>
            <li><strong>Recording Of Daily School Transactions e.g School Fees, Sales Books And Other Stationeries.</strong></li>
            <li><strong>Monitoring Teachers And Students Clock-In and Clock-Out</strong></li>
          </ul>                        
          
        </div>
        <img src="{{asset('admin/img/deschool-background.svg')}}" class="img-responsive" style="margin-left:50px" width="380" height="150">
  </div>
  <div class="col-lg-6 col-md-7 col-sm-8 col-xs-12">
    <div class="p-5">
      <div class="text-center">
          <h4 class="h3" style="color:#23abf4">
              The-School  
          </h4>
          <h4 class="h4 text-gray-900">
              <img src="{{asset('admin/img/icon.jpg')}}" width="180" height="150">
          </h4>
      </div>
      @if(session()->has('message'))
          <div class="offset-md-1 col-md-10 offset-sm-1 col-sm-10 alert
          alert-success alert-dismissable text-center" style="margin-top:20px">
            <a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a>
            <strong>
                Success
            </strong>
            {{session('message')}}
          </div>
      @endif
      @if(session()->has('errorMessage'))
          <div class="offset-md-1 col-md-10 offset-sm-1 col-sm-10 alert
          alert-danger alert-dismissable text-center" style="margin-top:20px">
            <a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a>
            <strong>
                Danger
            </strong>
            {{session('errorMessage')}}
          </div>
      @endif                                    
      <form class="user d-form" action="/password" method="post" novalidate >
        <input name="_token" type="hidden" value="{{ csrf_token() }}">
        <div class="form-group">
        <input type="hidden" name="checker" value="{{$checker}}">
          <input type="password" name="password" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter New Password...">
            <span class="text-danger">
              @if($errors->has('password'))
                {{ $password= $errors->first('password')}}
              @else
                {{$password=''}}                            
              @endif
            </span> 
        </div>
        <div class="form-group">
            <button type="submit"  class="btn btn-info btn-user btn-block">
            Change Password
            </button>
        </div>

      </form>                  

    </div>
  </div>
@endsection