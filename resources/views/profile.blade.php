<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>The Register - Profile</title>
  <!-- Custom fonts for this template-->
  <link href="{{asset('my-register/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
   <link href="{{asset('my-register/css/font-awesome.min.css" rel="stylesheet')}}" rel="stylesheet>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{asset('my-register/img/icon.jpg')}}"  sizes ="25x25"> 
  <!-- Custom styles for this template-->
  <link href="{{asset('my-register/css/sb-admin-2.min.css')}}" rel="stylesheet">
  <script src="{{asset('my-register/vendor/jquery/jquery.min.js')}}"></script>  
  <script>
      function dateTime(){
        var date = new Date();
        var h = date.getHours();
        var m = date.getMinutes();
        if (h > 12) {
          h -= 12;
        }else if (h ===0){
          h = 12
        }
        var s =date.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        var  result = h+':'+ m +':'+s;
        document.getElementById('time').innerHTML = result;
        var t =setTimeout(dateTime,1000);
      }
      function checkTime(i) {
        if (i < 10) {
           i = "0" + i;
        }
        return i;
      }     

  </script>
    <style>
     .img-rounded{
        display: block;
        border-radius:50%;
        
     }
      .services{
         margin-left: 5px;
      }
    </style>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
   <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/deschool/dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-smile"></i>
        </div>
        <div class="sidebar-brand-text mx-3"> Register </div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/deschool/dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSchool" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog fa-spin text-gray-400"></i>
          <span>School Settings</span>
        </a>
        <div id="collapseSchool" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">School Settings:</h6>
              @if(Auth::user()->isAdmin())
                <a class="collapse-item" href="/deschool/info-settings">Information Update</a>
                <a class="collapse-item" href="/deschool/profile">Profile</a>                   
                <a class="collapse-item" href="/deschool/priv-settings">Privilege</a>            
                <a class="collapse-item" href="cards.html">Send Memo</a>
                <a class="collapse-item" href="cards.html">View Memo Replys</a>
             @elseif(Auth::user()->isMember())
              <a class="collapse-item" href="/deschool/profile">Profile</a> 
             @endif                
          </div>
        </div>
      </li>
      <!-- Divider -->
    @if(Auth::user()->isAdmin())  
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>
      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStaff" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Staffs</span>
        </a>
        <div id="collapseStaff" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Staffs:</h6>
            <a class="collapse-item" href="/deschool/add-staff">Add New Staff</a>
            <a class="collapse-item" href="/deschool/view-staffs">View Staffs Table</a>
            <a class="collapse-item" href="/deschool/staff-register"> Staffs Register</a>       
          </div>
        </div>
      </li>
    @endif    
  <!-- Divider -->
     
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTeachers" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Teachers</span>
        </a>
        <div id="collapseTeachers" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Teachers</h6>
            @if(Auth::user()->isMember())
            <a class="collapse-item" href="/deschool/teacher">Teacher Register</a>
            @elseif(Auth::user()->isAdmin())
            <a class="collapse-item" href="/deschool/teacher"> Add Teacher</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Others:</h6>
            @endif    
          </div>
        </div>
      </li>
      <!-- Divider -->
    @if(Auth::user()->isAdmin())  
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseParents" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa fa-handshake text-gray-400"></i>
          <span>Parents</span>
        </a>
        <div id="collapseParents" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Parents</h6>
            <a class="collapse-item" href="/deschool/add-parent">Add New Parent</a>          
            <a class="collapse-item" href="/deschool/view-parents">View Parent Table</a>
          </div>
        </div>
      </li>
       
      <!-- Divider -->  
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collpaseStudents" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-users text-gray-400"></i>
          <span>Students</span>
        </a>
        <div id="collpaseStudents" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Students:</h6>
            <a class="collapse-item" href="/deschool/add-student"> Add New Student</a>
            <a class="collapse-item" href="/deschool/view-students">View Students Table</a>
            <a class="collapse-item" href="/deschool/students-registers"> Students Register</a>                 
            <a class="collapse-item" href="/deschool/students-s"> Add Student Result</a>               
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Others:</h6>
            <a class="collapse-item" href="register.html"> Old Student Archive</a>                  
            <a class="collapse-item" href="404.html">Assign Book</a>
            <a class="collapse-item" href="blank.html">Book Assign To Students</a>
          </div>
        </div>
      </li> 
      <!-- Divider -->
      
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFinances" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-credit-card text-gray-400"></i>
          <span>Revenue</span>
        </a>
        <div id="collapseFinances" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Revenue:</h6>
            <a class="collapse-item" href="buttons.html">Daily Revenue</a>
            <a class="collapse-item" href="cards.html">Monthly Revenue</a>
            <a class="collapse-item" href="cards.html">Other Finances</a>            
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePayment" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-credit-card text-gray-400"></i>
          <span>Make Payment</span>
        </a>
        <div id="collapsePayment" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Make Payment:</h6>
            <a class="collapse-item" href="buttons.html"> School Fees</a>
            <a class="collapse-item" href="cards.html">School Bus</a>
            <a class="collapse-item" href="cards.html">Stationaries</a>
            <a class="collapse-item" href="cards.html">Party And Excusion</a>
            <a class="collapse-item" href="cards.html">View Payment Table</a>            
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSubject" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-book text-gray-400"></i>
          <span>General Settings</span>
        </a>
        <div id="collapseSubject" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">General Settings:</h6>
            <a class="collapse-item" href="/deschool/general-settings">General Settings</a>
            <a class="collapse-item" href="/deschool/assign-subject">Assign Subject</a>            
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLibrary" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-building text-gray-400"></i>
          <span>Library</span>
        </a>
        <div id="collapseLibrary" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Library:</h6>
            <a class="collapse-item" href="buttons.html">Add New books</a>
            <a class="collapse-item" href="cards.html">View Books</a>
            <a class="collapse-item" href="cards.html"> Assign Book</a>            
          </div>
        </div>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKitchen" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-briefcase text-gray-400"></i>
          <span>Others</span>
        </a>
        <div id="collapseKitchen" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Kitchen:</h6>
            <a class="collapse-item" href="buttons.html">Add Material</a>
            <a class="collapse-item" href="cards.html">View Material</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Equipment:</h6>
            <a class="collapse-item" href="404.html">Add Equipment</a>
            <a class="collapse-item" href="blank.html">View Equipment</a>         
          </div>
        </div>
      </li>
    @endif             
      <!-- Nav Item - Charts -->
      <!--<li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>-->

      <!-- Nav Item - Tables -->
      <!--<li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>-->
      <li class="nav-item">
        <a class="nav-link" href="{{url('/deschool/logout')}}" onclick="event.preventDefault();
       document.getElementById('logout-form').submit()">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          <span>Logout</span></a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <span class="bg-danger" id="time" style="padding:8px;color:white;border-radius:3px"></span>
          </div>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-success">
                      <i class="fas fa-donate text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 7, 2019</div>
                    $290.29 has been deposited into your account!
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Spending Alert: We've noticed unusually high spending for your account.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter">7</span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler ?? 58m</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/AU4VPcFN4LE/60x60" alt="">
                    <div class="status-indicator"></div>
                  </div>
                  <div>
                    <div class="text-truncate">I have the photos that you ordered last month, how would you like them sent to you?</div>
                    <div class="small text-gray-500">Jae Chun ?? 1d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/CS2uCrpNzJY/60x60" alt="">
                    <div class="status-indicator bg-warning"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Last month's report looks great, I am very happy with the progress so far, keep up the good work!</div>
                    <div class="small text-gray-500">Morgan Alvarez ?? 2d</div>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div>
                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone told me that people say this to all dogs, even if they aren't good...</div>
                    <div class="small text-gray-500">Chicken the Dog ?? 2w</div>
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              @if(Auth::user()->isAdmin())
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{$schoolInformation->school_name !== null || $schoolInformation->school_name != '' ? ucfirst($schoolInformation->school_name) : ucfirst($userEmail) }}</span>
             @elseif(Auth::user()->isMember())
              <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ ucfirst($userEmail) }}</span>
             @endif
                <img class="img-profile rounded-circle" src="{{$schoolInformation->school_profile_image !== null || $schoolInformation->school_profile_image !='' ? url('uploads/'.$schoolInformation->school_profile_image) : asset('my-register/img/The-Register.jpg') }}">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/deschool/profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="/deschool/info-settings">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{url('/deschool/logout')}}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit()">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->

            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
                <!-- Approach -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                            <img src="{{$schoolInformation->school_profile_image !== null || $schoolInformation->school_profile_image !='' ? url('uploads/'.$schoolInformation->school_profile_image) : asset('my-register/img/The-Register.jpg') }}" class="col-md-3 col-sm-3 img-responsive img-rounded center-block">
                            <div class=" col-md-4 offset-sm-1 col-sm-4">
                                 <h4 class="m-3 font-weight-bold">{{$schoolInformation->school_name !== null || $schoolInformation->school_name != '' ? $schoolInformation->school_name : $userEmail }}</h4>
                                 <p class="m-3" ><i class="btn btn-sm btn-primary" style="height:28px">Admin</i> <span> CEO\PRINCIPAL </span></p>
                                 <p class="m-3" ><i class="fa fa-map-marker text-danger"> </i> <i> {{$schoolInformation->school_address}}</i> </p>
                            </div>
                            <div class="offset-md-1 col-md-3 offset-sm-1 col-sm-3">
                             <h4 class="m-3 font-weight-bold"><i class="fab fa-facebook text-primary"></i> <i class="fab fa-twitter-square text-info"></i> <i class="fab fa-google-plus text-danger"></i> <i class="fab fa-linkedin text-primary"></i> </h4>
                              <button type="button" class="m-3 btn btn-sm btn-info"><i class="fa fa-envelope"> </i> send message</button>
                            </div>                                 
                        </div>
                       
                    </div>
                    <div class="card-body" id="profile-body">
                        <div class="row">
                           <div class=" offset-md-1 col-md-11  offset-sm-1 col-sm-11">
                             <ul class="pagination responsive row">
                                 <li class="col-md-12 col-sm-12"> <h6><strong>OUR EDUCATIONAL SERVICES:</strong></h6></li>
                             </ul>
                              <ul class="pagination responsive row">
                                 @if($schoolInformation->school_services)
                                    @php $schoolServices = explode('-', $schoolInformation->school_services )  
                                    @endphp
                                    @foreach($schoolServices as $service ) 
                                     <li class="services col-sm-3"><h6><strong>{{strtoupper($service)}} <i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i><i class="fa fa-star text-warning"></i></strong></h6></li>
                                 @endforeach
                                 @endif
                              </ul>
                           </div>
                        </div>
                        <div class="row">
                           <div class="offset-md-1 col-md-5 0ffset-sm-1 col-sm-5" style="border:solid 1px #f4f4f4; border-radius:3px; border-radius: 3px;">
                              <p class="row m-3" style="width:200px"><strong style="float:left;clear:left">Description:</strong ></p>
                              <p class="m-3">{{$schoolInformation->school_description}}</p>
                           </div>
                           <div class="offset-md-1 col-md-5 0ffset-sm-1 col-sm-5" style="border:solid 1px #f4f4f4; border-radius:3px; border-radius: 3px;">
                            <p class="m-3"><strong> Email: </strong> {{$schoolInformation->school_email}}</p>
                             @if($schoolInformation->school_phone1 !== null)
                            <p class="m-3"><strong> Phone: </strong> {{$schoolInformation->school_phone1}}</p>
                            @else
                              <p class="m-3"><strong> Phone: </strong> {{$schoolInformation->school_phone2}}</p>
                             @endif
                            <p class="m-3"><strong> Address: </strong> {{$schoolInformation->school_address}}</p>
                            <p class="m-3"><strong> Postal Address: </strong> {{$schoolInformation->school_postal_address}}</p>   
                           </div>                              
                        </div>

                         <div class=" offset-md-1 col-md-11  offset-sm-1 col-sm-11" style="margin-top:20px">
                          <h6><strong>OTHER DETAILS:</strong></h6>
                           <div class="row">
                           @if($schoolInformation->school_license != null || $schoolInformation->school_license !="none" || $schoolInformation->school_license !="unapproved")
                            <div class="col-sm-3 col-md-3">
                             <p class="m-3"><strong> License: </strong> {{ucfirst($schoolInformation->school_license)}}</p>
                            </div>                         
                            <div class="col-sm-3 col-md-3">
                             <p class="m-3"><strong> License Number: </strong> {{$schoolInformation->school_license_number}}</p>
                            </div>                            
                           @else
                            <div class="col-sm-3 col-md-3">
                             <p class="m-3"><strong> License: </strong>No Number</p>
                            </div>                         
                            <div class="col-sm-3 col-md-3">
                             <p class="m-3"><strong> License Number: </strong> {{$schoolInformation->school_license_number}}</p>
                            </div>
                           @endif
                            <div class="col-sm-3 col-md-3">
                             <p class="m-3"><strong> Number Of Staff: </strong> {{$schoolInformation->school_number_of_staffs}}</p>                             
                            </div>
                           </div>
                           <div class="row">
                            <div class="col-sm-3 col-md-3">
                             <p class="m-3"><strong> City: </strong> {{$schoolInformation->school_city}}</p>                                                   
                            </div>
                            <div class="col-sm-4 col-md-4">
                             <p class="m-3"><strong> Local-Government: </strong> {{$schoolInformation->school_localG}}</p>                                                   
                            </div>
                            <div class="col-sm-3 col-md-3">
                             <p class="m-3"><strong> State </strong> {{$schoolInformation->school_state}}</p>                                                   
                            </div>                             
                           </div>
                         </div>  
                    </div>
                </div>
            </div>
        </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; The Register {{$date}}</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">??</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>
  <script>
      window.onload=dateTime(); 
   </script>  
  <!-- Bootstrap core JavaScript-->

  <script src="{{asset('my-register/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('my-register/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('my-register/js/sb-admin-2.min.js')}}"></script>

  <!-- Page level plugins -->
  <script src="{{asset('my-register/vendor/chart.js/Chart.min.js')}}"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('my-register/js/demo/chart-area-demo.js')}}"></script>
  <script src="{{asset('my-register/js/demo/chart-pie-demo.js')}}"></script>
    <form id='logout-form' action="{{url('/deschool/logout')}}"
    method="POST" style='display:none'>
        {{csrf_field()}}
    </form>
</body>

</html>
