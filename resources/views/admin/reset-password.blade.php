@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Reset Password</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">                
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold"> Reset Password </h6>
                  <div class="float-right text-danger" id="settingsToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="settings-body">
                    <div class="col-lg-12 mb-4">     
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
                     <form class="form" action="/reset-password" method="POST">
                        {{csrf_field()}}
                        <div class="row">
                         <div class="col-md-6 col-sm-6">
                           <div class="form-group class-subject-group">
                                <label for="password" class="control-label text-info"> Password</label>
                                <input type="password"  name="password" class="form-control" placeholder="Enter password">
                                <span class="text-danger">
                                    @if($errors->has('password'))
                                        {{ $password=$errors->first('password')}} 
                                    @else
                                        {{$password=''}}                            
                                    @endif
                                </span> 
                           </div>
                         </div>
                         <div class="col-md-6 col-sm-6">
                           <div class="form-group date-group">
                              <label for="confirm-password" class="control-label text-info"> Confirm Password</label>
                              <input type="password"  name="password_confirmation" class="form-control" Placeholder="Enter confirm password">
                           </div>
                         </div>                        
                       </div>
                       <div class="row">
                         <div class="col-md-6 offset-sm-6 col-sm-6">
                            <div class="form-group">
                              <button type="submit"  class="btn btn-success form-control" > Reset </button>
                            </div>
                         </div>
                       </div>  
                     </form>
                  </div>                  
                </div>
              </div>
            </div>
          </div>
      <!-- End of Main Content -->
  @endsection
 