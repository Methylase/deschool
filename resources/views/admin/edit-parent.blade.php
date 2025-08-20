@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Edit Parent</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

        
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-danger"> Edit Parent </h6>
                  <div class="float-right text-danger " id="editParentToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="edit-parent-body">
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
                <form class="form" action="/update-parent" enctype="multipart/form-data" method="POST">
                    {{method_field('PUT')}}

                    {{csrf_field()}}
                     <input type="hidden" name="id" value="{{old('id', $parentInformation->id)}}">
                     <input type="hidden" name="userId" value="{{$parentInformation->corox_model_id ? old('id', $parentInformation->corox_model_id) : $userId}}">
                     <div class="row">
                        <div class="col-md-6 col-sm-6 ">                      
                           <div class="form-group">             
                            <img src="{{$parentInformation->parent_profile_image !== null || $parentInformation->parent_profile_image !='' ? url('uploads/'.$parentInformation->parent_profile_image) : asset('admin/img/The-Register.jpg') }}" width=200 height=150 class="col-md-4 col-sm-4 img-responsive img-rounded">                                 
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
                      <hr>                    
                     <div class="row">
                      <div class="col-md-6 col-sm-6 ">
                        <div class="form-group">
                          <label for="first-name" class="control-label text-info"> FirstName</label>
                           <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Enter FirstName" value="{{$parentInformation->parent_firstname !== null ? $parentInformation->parent_firstname :old('firstname', $parentInformation->parent_firstname) }}">
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
                           <input type="text" id="middlename" name="middlename" class="form-control" placeholder="Enter MiddleName" value="{{$parentInformation->parent_middlename !== null ? $parentInformation->parent_middlename :old('middlename',  $parentInformation->parent_middlename) }}">
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
                           <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Enter MiddleName" value="{{$parentInformation->parent_lastname !== null ? $parentInformation->parent_lastname :old('lastname',  $parentInformation->parent_lastname) }}">
                           <span class="text-danger">
                            @if($errors->has('lastname'))
                              {{ $lastname= $errors->first('lastname')}}
                            @else
                              {{$lastname=''}}                            
                            @endif
                          </span>                       
                          </div>
                      </div>                      
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="email" class="control-label text-info"> Email</label>
                             <input type="email" id="email" name="email" class="form-control" placeholder="Enter  Email" value="{{$parentInformation->parent_email !== null ? $parentInformation->parent_email :old('email',  $parentInformation->parent_email) }}">
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
                              @if($parentInformation->parent_marital_status ==="none" || $parentInformation->parent_marital_status ===NULL)
                                 <option value="none">Select-Marital-Status</option>
                                 <option value="single">Single</option>  
                                 <option value="married">Married</option>
                                
                              @elseif($parentInformation->parent_marital_status ==="married")
                                 <option value="single">Single</option>                                 
                                 <option value="{{$parentInformation->parent_marital_status ==="married"? $parentInformation->parent_marital_status :old('maritalStatus', $parentInformation->parent_marital_status) }}" selected>{{ucfirst($parentInformation->parent_marital_status)}}</option>
                                    
                              @elseif($parentInformation->parent_marital_status ==="single")
                                 <option value="{{$parentInformation->parent_marital_status ==="single"? $parentInformation->parent_marital_status :old('maritalStatus', $parentInformation->parent_marital_status) }}" selected>{{ucfirst($parentInformation->parent_marital_status)}}</option>                                 
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
                           @if($parentInformation->parent_gender ==="none" || $parentInformation->parent_gender ===NULL)                        
                              <label for="gender" class="radio-inline text-info">Male</label>
                              <input type="radio" id="gender-male" name="gender" value="male">
                              <label for="gender" class="radio-inline text-info">Female</label>                                                                     
                              <input type="radio" id="gender-female" name="gender"   value="female">
                           @elseif($parentInformation->parent_gender ==="male")
                              <label for="gender" class="radio-inline text-info">Male</label>
                              <input type="radio" id="gender-male" name="gender" value="{{$parentInformation->parent_gender ==="male" ? $parentInformation->parent_gender :old('gender', $parentInformation->parent_gender) }}" checked>
                              <label for="gender" class="radio-inline text-info">Female</label>                                                                     
                              <input type="radio" id="gender-female" name="gender"  value="female">
                           @elseif($parentInformation->parent_gender ==="female")
                              <label for="gender" class="radio-inline text-info">Male</label>
                              <input type="radio" id="gender-male" name="gender" value="male">
                              <label for="gender" class="radio-inline text-info">Female</label>                                                                     
                              <input type="radio" id="gender-female" name="gender"  value="{{$parentInformation->parent_gender ==="female" ? $parentInformation->parent_gender :old('gender', $parentInformation->parent_gender) }}" checked>
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
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="phone-number" class="control-label text-info"> Phone Number </label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Parent Phone" value="{{$parentInformation->parent_phone !== null ? $parentInformation->parent_phone :old('phone', $parentInformation->parent_phone) }}">
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
                            <input type="date" id="dob" name="dob" class="form-control" value="{{$parentInformation->parent_dob !== null ? $parentInformation->parent_dob :old('dob',date('m/d/y',strtotime($parentInformation->parent_dob))) }}">
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
                              @if($parentInformation->parent_disability ==="none" || $parentInformation->parent_disability ===NULL)
                                 <option value="none">Select-Disability</option>
                                 <option value="yes">Yes</option>
                                 <option value="no">No</option>
                              @elseif($parentInformation->parent_disability ==="yes")
                                 <option value="none">Select-Disability</option>                                 
                                 <option value="{{$parentInformation->parent_disability ==='yes'? $parentInformation->parent_disability :old('disabilityStatus', $parentInformation->parent_disability) }}" selected>{{ucfirst($parentInformation->parent_disability)}}</option>
                                 <option value="no">No</option>  
                              @elseif($parentInformation->parent_disability ==="no")
                                 <option value="none">Select-Disability</option>                                   
                                  <option value="yes">Yes</option>
                                 <option value="{{$parentInformation->parent_disability ==='no'? $parentInformation->parent_disability :old('disabilityStatus', $parentInformation->parent_disability) }}" selected>{{ucfirst($parentInformation->parent_disability)}}</option>      
                              @endif                                    
                             </select>
                             <span class="text-danger">
                             @if($errors->has('disabilityStatus'))
                                {{ $disabilityStatus= $errors->first('disabilityStatus')}}
                              @else
                                {{$disabilityStatus=''}}                            
                              @endif                              
                            </span>                              
                        </div>
                      </div>                                            
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="list-type-of-disability" class="control-label text-info">List Disability Type</label>
                           <textarea  id="listDisability" name="listDisability" class="form-control" placeholder="Enter The List Of Disability" >{{$parentInformation->parent_list_disability !== null ? $parentInformation->parent_list_disability :old('listDisability', $parentInformation->parent_list_disability) }}</textarea>
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
                            <textarea  id="hobbies" name="hobbies" class="form-control" placeholder="Enter Parent Hobbies" >{{$parentInformation->parent_hobbies !== null ? $parentInformation->parent_hobbies :old('hobbies', $parentInformation->parent_hobbies) }}</textarea>
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
                            <textarea  id="address" name="address" class="form-control" placeholder="Enter Parent Address" >{{$parentInformation->parent_address !== null ? $parentInformation->parent_address :old('address', $parentInformation->parent_address) }}</textarea>
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
                            <input type="text" id="city" name="city" class="form-control" placeholder="Enter City" value="{{$parentInformation->parent_city !== null ? $parentInformation->parent_city :old('city', $parentInformation->parent_city) }}">
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
                             <input type="text" id="socialMedia" name="socialMedia" class="form-control" placeholder="Enter Social Medial Handle" value="{{$parentInformation->parent_social_media !== null ? $parentInformation->parent_social_media :old('socialMedia', $parentInformation->parent_social_media) }}">
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
                              @if($parentInformation->parent_state ==="none" || $parentInformation->parent_state === null)
                                 <option value="none">Select State</option>
                              @else($parentInformation->parent_state !=="none" || $parentInformation->parent_state !== null)
                                 <option value="{{$parentInformation->parent_state !== null ? $parentInformation->parent_state :old('state', $parentInformation->parent_state) }}" selected>{{$parentInformation->parent_state}}</option>
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
                              @if($parentInformation->parent_localG ==="none" || $parentInformation->parent_localG === null)
                                 <option value="none">Select Local-Govt</option>
                              @else($parentInformation->parent_localG !=="none" || $parentInformation->parent_localG !== null)
                                 <option value="{{$parentInformation->parent_localG !== null ? $parentInformation->parent_localG :old('localG', $parentInformation->parent_localG) }}" selected>{{$parentInformation->parent_localG}}</option>
                              @endif   
                             </select>
                             <span class="text-danger">
                                @if($errors->has('localG'))
                                  {{ $localG= 'The local government field is required'}}
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
                           <button type="submit"  id="updateParent"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Save </button>
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
 