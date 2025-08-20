@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->

            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
                <!-- Approach -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="row">
                            <img src="{{$schoolInformation->school_profile_image !== null || $schoolInformation->school_profile_image !='' ? url('uploads/'.$schoolInformation->school_profile_image) : asset('my-register/img/The-Register.jpg') }}" class="col-md-3 col-sm-3 img-responsive img-rounded center-block">
                            <div class=" col-md-4 offset-sm-1 col-sm-4">
                                 <h4 class="m-2 font-weight-bold">{{$schoolInformation->school_name !== null || $schoolInformation->school_name != '' ? $schoolInformation->school_name : $userEmail }}</h4>
                                 <p class="m-2" ><span> CEO\PRINCIPAL </span></p>
                                 <p class="m-2" ><i class="fa fa-map-marker text-danger"> </i> <i> {{$schoolInformation->school_address}}</i> </p>
                            </div>
                            <div class="offset-md-1 col-md-3 offset-sm-1 col-sm-3">
                             <h4 class="m-3 font-weight-bold"><i class="fab fa-facebook text-primary"></i> <i class="fab fa-twitter-square text-info"></i> <i class="fab fa-google-plus text-danger"></i> <i class="fab fa-linkedin text-primary"></i> </h4>
                             <a href="/send-memo"><button type="button" class="m-3 btn btn-sm btn-info"><i class="fa fa-envelope"> </i> send memo </button></a>
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
                                     <li class="services col-sm-3"><h6><strong>{{strtoupper($service)}}</strong></h6></li>
                                 @endforeach
                                 @endif
                              </ul>
                           </div>
                        </div>
                        <div class="row">
                           <div class="offset-md-1 col-md-5 0ffset-sm-1 col-sm-5" style="border:solid 1px #f4f4f4; border-radius:3px; border-radius: 3px;">
                              <p class="row m-2" style="width:200px"><strong style="float:left;clear:left">Description:</strong ></p>
                              <p class="m-2">{{$schoolInformation->school_description}}</p>
                           </div>
                           <div class="offset-md-1 col-md-5 0ffset-sm-1 col-sm-5" style="border:solid 1px #f4f4f4; border-radius:3px; border-radius: 3px;">
                            <p class="m-2"><strong> Email: </strong> {{$schoolInformation->school_email}}</p>
                             @if($schoolInformation->school_phone1 !== null)
                            <p class="m-2"><strong> Phone: </strong> {{$schoolInformation->school_phone1}}</p>
                            @else
                              <p class="m-2"><strong> Phone: </strong> {{$schoolInformation->school_phone2}}</p>
                             @endif
                            <p class="m-2"><strong> Address: </strong> {{$schoolInformation->school_address}}</p>
                            <p class="m-2"><strong> Postal Address: </strong> {{$schoolInformation->school_postal_address}}</p>   
                           </div>                              
                        </div>

                         <div class=" offset-md-1 col-md-11  offset-sm-1 col-sm-11" style="margin-top:20px">
                          <h6><strong>OTHER DETAILS:</strong></h6>
                           <div class="row">
                           @if($schoolInformation->school_license != null || $schoolInformation->school_license !="none" || $schoolInformation->school_license !="unapproved")
                            <div class="col-sm-4 col-md-4">
                             <p class="m-2"><strong> License: </strong> {{ucfirst($schoolInformation->school_license)}}</p>
                            </div>                         
                            <div class="col-sm-4 col-md-4">
                             <p class="m-2"><strong> License Number: </strong> {{$schoolInformation->school_license_number}}</p>
                            </div>                            
                           @else
                            <div class="col-sm-4 col-md-4">
                             <p class="m-2"><strong> License: </strong>No Number</p>
                            </div>                         
                            <div class="col-sm-4 col-md-4">
                             <p class="m-2"><strong> License Number: </strong> {{$schoolInformation->school_license_number}}</p>
                            </div>
                           @endif
                            <div class="col-sm-4 col-md-4">
                             <p class="m-2"><strong> Number Of Staff: </strong> {{$schoolInformation->school_number_of_staffs}}</p>                             
                            </div>
                           </div>
                           <div class="row">
                            <div class="col-sm-4 col-md-4">
                             <p class="m-2"><strong> Location Situated: </strong> {{$schoolInformation->school_city}}</p>                                                   
                            </div>
                            <div class="col-sm-4 col-md-4">
                             <p class="m-2"><strong> Local-Government: </strong> {{$schoolInformation->school_localG}}</p>                                                   
                            </div>
                            <div class="col-sm-4 col-md-4">
                             <p class="m-2"><strong> State </strong> {{$schoolInformation->school_state}}</p>                                                   
                            </div>                             
                           </div>
                         </div>  
                    </div>
                </div>
            </div>
        </div>
      <!-- End of Main Content -->
  @endsection