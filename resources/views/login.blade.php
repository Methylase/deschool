<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>The School - {{$title}}</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('my-register/css/sb-admin-2.min.css')}}" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{asset('my-register/img/icon.jpg')}}"  sizes ="25x25"> 
</head>

<body >

  <div class="container-fluid">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-12">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row justify-content-center align-items-center">
              <div class="col-lg-6 col-md-5 col-sm-4 col-xs-12 d-none d-lg-block text-left" style="border-right:2px solid #23abf4">
      
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
                    <img src="{{asset('my-register/img/deschool-background.svg')}}" class="img-responsive" style="margin-left:50px" width="380" height="150">
              </div>
              <div class="col-lg-6 col-md-7 col-sm-8 col-xs-12">
                <div class="p-5">
                  <div class="text-center">
                      <h4 class="h3" style="color:#23abf4">
                          The-School  
                      </h4>
                      <h4 class="h4 text-gray-900">
                          <img src="{{asset('my-register/img/icon.jpg')}}" width="180" height="150">
                      </h4>
                  </div>
                  @if(session()->has('message'))
                     <div class="offset-md-1 col-md-10 offset-sm-1 col-sm-10 alert
                     alert-danger alert-dismissable text-center" style="margin-top:20px">
                        <a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a>
                        <strong>
                           Danger
                        </strong>
                        {{session('message')}}
                     </div>
                  @endif                                   
                  <form class="user d-form" action="/deschool/login" method="post" novalidate >
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <div class="form-group">
                      <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                        <span class="text-danger">
                          @if($errors->has('email'))
                            {{ $email= $errors->first('email')}}
                          @else
                            {{$email=''}}                            
                          @endif
                        </span> 
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
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
                    <button type="submit"  class="btn btn-info btn-user btn-block">
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
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('my-register/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('myregister/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('my-register/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('my-register/js/sb-admin-2.min.js')}}"></script>

</body>

</html>
