
@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Edit Staff</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

        
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold"> Edit Staff </h6>
                  <div class="float-right text-danger " id="editSaffToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="edit-staff-body">
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
                  @if(session()->has('messageSuccess'))
                     <div class="offset-md-1 col-md-10 offset-sm-1 col-sm-10 alert
                     alert-success alert-dismissable text-center" style="margin-top:20px">
                        <a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a>
                        <strong>
                          Success
                        </strong>
                        {{session('messageSuccess')}}
                     </div>
                  @endif
                <form class="form" action="/update-staff" enctype="multipart/form-data" method="POST">
                    {{method_field('PUT')}}

                    {{csrf_field()}}
                     <input type="hidden" name="id" value="{{old('id', $staffInformation->id)}}">
                     <input type="hidden" name="userId" value="{{$staffInformation->corox_model_id ? old('id', $staffInformation->corox_model_id) : $userId}}">
                     <div class="row">
                        <div class="col-md-6 col-sm-6 ">                      
                           <div class="form-group">             
                            <img src="{{$staffInformation->staff_profile_image !== null || $staffInformation->staff_profile_image !='' ? url('uploads/'.$staffInformation->staff_profile_image) : asset('admin/img/The-Register.jpg') }}" width=200 height=150 class="col-md-4 col-sm-4 img-responsive img-rounded">                                 
                           </div>
                        </div>                           
                      </div>                     
                     <div class="row">
                        <div class="col-md-6 col-sm-6 ">                      
                           <div class="form-group">             
                               <input type="file" id="profileImage" name="profileImage" class="form-control">
                               <span style="margin-top:4px;">Select Profile image</span>  
                           </div>
                        </div>                     
                      </div>                      
                     <div class="row">
                      <div class="col-md-6 col-sm-6 ">
                        <div class="form-group">
                          <label for="first-name" class="control-label text-info"> FirstName</label>
                           <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Enter FirstName" value="{{$staffInformation->staff_firstname !== null ? $staffInformation->staff_firstname :old('firstname', $staffInformation->staff_firstname) }}">
                           <span class="text-danger">
                            @if($errors->has('firstname'))
                              {{ $firstname= $errors->first('firstname')}}
                            @else
                              {{$firstname=''}}                            
                            @endif
                          </span>                            
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="middle-name" class="control-label text-info"> MiddleName</label>
                           <input type="text" id="middlename" name="middlename" class="form-control" placeholder="Enter MiddleName" value="{{$staffInformation->staff_middlename !== null ? $staffInformation->staff_middlename :old('middlename',  $staffInformation->staff_middlename) }}">
                           <span class="text-danger">
                            @if($errors->has('middlename'))
                              {{ $middlename= $errors->first('middlename')}}
                            @else
                              {{$middlename=''}}                            
                            @endif
                          </span> 
                        </div>
                      </div>                        
                    </div>
                     <div class="row">
                       <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="last-name" class="control-label text-info"> LastName</label>
                           <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Enter MiddleName" value="{{$staffInformation->staff_lastname !== null ? $staffInformation->staff_lastname :old('lastname',  $staffInformation->staff_lastname) }}">
                           <span class="text-danger">
                              @if($errors->has('lastname'))
                                {{ $middlename= $errors->first('lastname')}}
                              @else
                                {{$lastname=''}}                            
                              @endif
                            </span>                            
                        </div>
                      </div>                      
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="email" class="control-label text-info"> Email</label>
                             <input type="email" id="email" name="email" class="form-control" placeholder="Enter  Email" value="{{$staffInformation->staff_email !== null ? $staffInformation->staff_email :old('email',  $staffInformation->staff_email) }}" readonly>
                             <span class="text-danger">
                              @if($errors->has('email'))
                                {{ $email= $errors->first('email')}}
                              @else
                                {{$email=''}}                            
                              @endif
                            </span>                              
                        </div>
                      </div>                               
                     </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="marital-status"  class="control-label text-info"> Marital Status</label>
                             <select class="form-control" id="marital-status" name="maritalStatus">
                              @if( $staffInformation->staff_marital_status ==="none" || $staffInformation->staff_marital_status ===NULL)
                                 <option value="none">Select-Marital-Status</option>
                                 <option value="single">Single</option>  
                                 <option value="married">Married</option>
                                
                              @elseif($staffInformation->staff_marital_status ==="married")
                                 <option value="single">Single</option>                                 
                                 <option value="{{$staffInformation->staff_marital_status ==='married'? $staffInformation->staff_marital_status :old('maritalStatus', $staffInformation->staff_marital_status) }}" selected>{{ucfirst($staffInformation->staff_marital_status)}}</option>
                                    
                              @elseif($staffInformation->staff_marital_status ==="single")
                                 <option value="{{$staffInformation->staff_marital_status ==='single'? $staffInformation->staff_marital_status :old('maritalStatus', $staffInformation->staff_marital_status) }}" selected>{{ucfirst($staffInformation->staff_marital_status)}}</option>                                 
                                 <option value="Married">Married</option>     
                              @endif                                                                  
                             </select>
                             <span class="text-danger">
                                @if($errors->has('maritalStatus'))
                                  {{ $maritalStatus= $errors->first('maritalStatus')}}
                                @else
                                  {{$maritalStatus=''}}                            
                                @endif
                              </span>                              
                        </div>
                      </div>                                            
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group" style="margin-top:40px">
                          <div class="radio">
                            @if($staffInformation->staff_gender ==="none" || $staffInformation->staff_gender ===NULL)                        
                              <label for="gender" class="radio-inline text-info">Male <input type="radio" id="gender-male" name="gender" value="male"></label>
                              <label for="gender" class="radio-inline text-info">Female <input type="radio" id="gender-female" name="gender" value="female"></label>                                                                     
                            @elseif($staffInformation->staff_gender ==="male")
                              <label for="gender" class="radio-inline text-info">Male <input type="radio" id="gender-male" name="gender" value="{{$staffInformation->staff_gender ==="male" ? $staffInformation->staff_gender :old('gender', $staffInformation->staff_gender) }}" checked></label> 
                              <label for="gender" class="radio-inline text-info">Female <input type="radio" id="gender-female" name="gender"  value="female"></label>                                                                     
                            @elseif($staffInformation->staff_gender ==="female")
                              <label for="gender" class="radio-inline text-info">Male <input type="radio" id="gender-male" name="gender" value="male"></label>
                              <label for="gender" class="radio-inline text-info">Female <input type="radio" id="gender-female" name="gender"  value="{{$staffInformation->staff_gender ==="female" ? $staffInformation->staff_gender :old('gender', $staffInformation->staff_gender) }}" checked></label>                                                                     
                            @endif
                          </div>
                          <span class="text-danger">
                            @if($errors->has('gender'))
                              {{ $gender= $errors->first('gender')}}
                            @else
                              {{$gender=''}}                            
                            @endif
                          </span>                            
                        </div>                       
                      </div>
                    </div>                        
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="phone-number" class="control-label text-info"> Phone Number </label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter School Phone" value="{{$staffInformation->staff_phone !== null ? $staffInformation->staff_phone :old('phone', $staffInformation->staff_phone) }}">
                            <span class="text-danger">
                              @if($errors->has('phone'))
                                {{ $phone= $errors->first('phone')}}
                              @else
                                {{$phone=''}}                            
                              @endif
                            </span>                             
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="date-of-birth" class="control-label text-info">Date Of Birth</label>
                            <input type="date" id="dob" name="dob" class="form-control" value="{{$staffInformation->staff_dob !== null ? $staffInformation->staff_dob :old('dob',date('m/d/y',strtotime($staffInformation->staff_dob))) }}">
                            <span class="text-danger">
                              @if($errors->has('dob'))
                                {{ $dob= $errors->first('dob')}}
                              @else
                                {{$dob=''}}                            
                              @endif
                            </span> 
                        </div>
                      </div>                        
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="disability"  class="control-label text-info">Disability</label>
                             <select class="form-control" id="disabilityStatus" name="disabilityStatus">
                              @if($staffInformation->staff_disability ==="none" || $staffInformation->staff_disability ===NULL)
                                 <option value="none">Select-Disability</option>
                                 <option value="yes">Yes</option>
                                 <option value="no">No</option>
                              @elseif($staffInformation->staff_disability ==="yes")
                                 <option value="none">Select-Disability</option>                                 
                                 <option value="{{$staffInformation->staff_disability ==='yes'? $staffInformation->staff_disability :old('disabilityStatus', $staffInformation->staff_disability) }}" selected>{{ucfirst($staffInformation->staff_disability)}}</option>
                                 <option value="no">No</option>  
                              @elseif($staffInformation->staff_disability ==="no")
                                 <option value="none">Select-Disability</option>                                   
                                  <option value="yes">Yes</option>
                                 <option value="{{$staffInformation->staff_disability ==='no'? $staffInformation->staff_disability :old('disabilityStatus', $staffInformation->staff_disability) }}" selected>{{ucfirst($staffInformation->staff_disability)}}</option>      
                              @endif                                    
                             </select>
                        </div>
                        <span class="text-danger">
                          @if($errors->has('disabilityStatus'))
                            {{ $disabilityStatus= $errors->first('disabilityStatus')}}
                          @else
                            {{$disabilityStatus=''}}                            
                          @endif
                        </span>                        
                      </div>                                            
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="list-type-of-disability" class="control-label text-info">List Disability Type</label>
                           <textarea  id="listDisability" name="listDisability" class="form-control" placeholder="Enter The List Of Disability" >{{$staffInformation->staff_list_disability !== null ? $staffInformation->staff_list_disability :old('listDisability', $staffInformation->staff_list_disability) }}</textarea>
                           <span class="text-danger">
                             @if($errors->has('listDisability'))
                                {{ $listDisability= $errors->first('listDisability')}}
                              @elseif(session()->has('listDisability'))
                                {{session('listDisability')}}                                
                              @else
                                {{$listDisability=''}}                            
                              @endif                                 
                            </span>                                
                        </div>
                      </div>
                    </div>
                     <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="hobbies" class="control-label text-info"> Hobbies</label>
                            <textarea  id="hobbies" name="hobbies" class="form-control" placeholder="Enter Staff Hobbies" >{{$staffInformation->staff_hobbies !== null ? $staffInformation->staff_hobbies :old('hobbies', $staffInformation->staff_hobbies) }}</textarea>
                            <span class="text-danger">
                              @if($errors->has('hobbies'))
                                {{ $hobbies= $errors->first('hobbies')}}
                              @else
                                {{$hobbies=''}}                            
                              @endif
                            </span>                            
                        </div>
                      </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="school-address" class="control-label text-info"> Address</label>
                            <textarea  id="address" name="address" class="form-control" placeholder="Enter Staff Address" >{{$staffInformation->staff_address !== null ? $staffInformation->staff_address :old('address', $staffInformation->staff_address) }}</textarea>
                            <span class="text-danger">
                              @if($errors->has('address'))
                                {{ $address= $errors->first('address')}}
                              @else
                                {{$address=''}}                            
                              @endif
                            </span>                             
                        </div>
                      </div>                         
                     </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="city" class="control-label text-info"> City</label>
                            <input type="text" id="city" name="city" class="form-control" placeholder="Enter City" value="{{$staffInformation->staff_city !== null ? $staffInformation->staff_city :old('city', $staffInformation->staff_city) }}">
                            <span class="text-danger">
                              @if($errors->has('city'))
                                {{ $city= $errors->first('city')}}
                              @else
                                {{$city=''}}                            
                              @endif
                            </span>                            
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="social-media" class="control-label text-info" >Social Media Handle</label>
                             <input type="text" id="socialMedia" name="socialMedia" class="form-control" placeholder="Enter Social Medial Handle" value="{{$staffInformation->staff_social_media !== null ? $staffInformation->staff_social_media :old('socialMedia', $staffInformation->staff_social_media) }}">
                             <span class="text-danger">
                                @if($errors->has('socialMedia'))
                                  {{ $socialMedia= $errors->first('socialMedia')}}
                                @else
                                  {{$socialMedia=''}}                            
                                @endif
                              </span>                             
                        </div>
                      </div>                        
                    </div>                        
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="state" class="control-label text-info"> State</label>
                            <select class="form-control" id="state" name="state">
                              @if($staffInformation->staff_state ==="none" || $staffInformation->staff_state === null)
                                 <option value="none">Select State</option>
                              @else($staffInformation->staff_state !=="none" || $staffInformation->staff_state !== null)
                                 <option value="{{$staffInformation->staff_state !== null ? $staffInformation->staff_state :old('state', $staffInformation->staff_state) }}" selected>{{$staffInformation->staff_state}}</option>
                              @endif   
                            </select>
                            <span class="text-danger">
                              @if($errors->has('state'))
                                {{ $state= $errors->first('state')}}
                              @else
                                {{$state=''}}                            
                              @endif
                            </span>                             
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="local-government" class="control-label text-info" > Local-Govt</label>
                             <select class="form-control" id="localG" name="localG">
                              @if($staffInformation->staff_localG ==="none" || $staffInformation->staff_localG === null)
                                 <option value="none">Select Local-Govt</option>
                              @else($staffInformation->staff_localG !=="none" || $staffInformation->staff_localG !== null)
                                 <option value="{{$staffInformation->staff_localG !== null ? $staffInformation->staff_localG :old('localG', $staffInformation->staff_localG) }}" selected>{{$staffInformation->staff_localG}}</option>
                              @endif   
                             </select>
                             <span class="text-danger">
                                @if($errors->has('localG'))
                                  {{ $localG= $errors->first('localG')}}
                                @else
                                  {{$localG=''}}                            
                                @endif
                              </span>                              
                        </div>
                      </div>                        
                    </div>
                    <div class="row">
                      <div class="col-md-6 offset-sm-6 col-sm-6">
                        <div class="form-group">
                           <button type="submit"  id="updateStaff"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Save </button>
                        </div>
                      </div>
                    </div>  
                  </form>
                </div>
              </div>
            </div>
          </div>
      <!-- End of Main Content -->
  @endsection
 
