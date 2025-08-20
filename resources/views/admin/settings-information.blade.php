@extends('layouts.admin')
  @section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Information - Update</h1>
      </div>
        <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
    
      <!-- Content Column -->
      <div class="col-lg-12 mb-4">
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
  
        <!-- Approach -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Information Update </h6>
            <div class="float-right text-danger" id="settingsInformationToggle"><i class="fas fa-plus" id="close"></i></div>
          </div>
          <div class="card-body" id="settings-information-body">
              @if(!isset( $schoolInformation->id))
                  <form class="form" action="/add-info-settings" enctype="multipart/form-data" method="POST">
              @else
              <form class="form" action="/update-info-settings" enctype="multipart/form-data" method="POST">   
                  {{method_field('PUT')}}
                  @if($schoolInformation->school_enable !='' || $schoolInformation->school_enable !=null)
                    @php $readOnly =$schoolInformation->school_enable; $disabled ="disabled";
                    @endphp
                  @else
                    @php $readOnly =$schoolInformation->school_enable; $disabled ="";
                    @endphp                           
                  @endif
                @endif

                {{csrf_field()}}
                <input type="hidden" name="id" value="{{old('id', $schoolInformation->id)}}">
                <input type="hidden" name="userId" value="{{$schoolInformation->corox_model_id ? old('id', $schoolInformation->corox_model_id) : $userId}}">
                <div class="row">
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                      <label for="school-profile-image" class="control-label text-info"> Profile Image</label>                        
                        <input type="file" id="profileImage" name="profileImage" class="form-control" {{$disabled}}>
                    </div>
                  </div>                       
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-6 col-sm-6 ">
                    <div class="form-group">
                      <label for="school-name" class="control-label text-info"> Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter School Name" value="{{$schoolInformation->school_name !== null ? $schoolInformation->school_name :old('name', $schoolInformation->school_name) }}" {{$readOnly}}>
                        <span class="text-danger">
                        @if($errors->has('name'))
                          {{ $name= $errors->first('name')}}
                        @else
                          {{$name=''}}                            
                        @endif
                      </span>                        
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                      <label for="school-email" class="control-label text-info"> Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter School Email" value="{{$schoolInformation->school_email !== null ? ucfirst($schoolInformation->school_email) :old('email',  $userEmail) }}" {{$readOnly}}>
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
                      <label for="phone-number" class="control-label text-info"> Phone Number 1</label>
                        <input type="text" id="phone1" name="phone1" class="form-control" placeholder="Enter School Phone Number" value="{{$schoolInformation->school_phone1 !== null ? $schoolInformation->school_phone1 :old('phone1', $schoolInformation->school_phone1) }}" {{$readOnly}}>
                        <span class="text-danger">
                        @if($errors->has('phone1'))
                          {{ $phone1= $errors->first('phone1')}}
                        @else
                          {{$phone1=''}}                            
                        @endif
                      </span>                       
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                      <label for="school-email" class="control-label text-info" > Phone Number 2</label>
                        <input type="text" id="phone2" name="phone2" class="form-control" placeholder="Enter School Phone Number" value="{{$schoolInformation->school_phone2 !== null ? $schoolInformation->school_phone2 :old('phone2', $schoolInformation->school_phone2) }}" {{$readOnly}}>
                        <span class="text-danger">
                        @if($errors->has('phone2'))
                          {{ $phone2= $errors->first('phone2')}}
                        @else
                          {{$phone2=''}}                            
                        @endif
                      </span>                        
                        </div>
                  </div>                        
                </div>
                <div class="row">
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                      <label for="school-address" class="control-label text-info"> Address</label>
                        <textarea  id="address" name="address" class="form-control" placeholder="Enter School Address" {{$readOnly}}>{{$schoolInformation->school_address !== null ? $schoolInformation->school_address :old('address', $schoolInformation->school_address) }}</textarea>
                        <span class="text-danger">
                        @if($errors->has('address'))
                          {{ $address= $errors->first('address')}}
                        @else
                          {{$address=''}}                            
                        @endif
                      </span>                       
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                      <label for="license" class="control-label text-info" > License</label>
                        <select class="form-control" id="license" name="license" {{$disabled}}>
                          @if($schoolInformation->school_license ==="none" || $schoolInformation->school_license ===NULL)
                            <option value="{{$schoolInformation->school_license !== null ? $schoolInformation->school_license :old('license', $schoolInformation->school_license) }}">Select-License-Status</option>
                            <option value="approved">Approved</option>
                            <option value="unapprove">Unapproved</option>
                          @elseif($schoolInformation->school_license ==="approved")
                            <option value="none">Select-License-Status</option>
                            <option value="{{$schoolInformation->school_license !== null ? $schoolInformation->school_license :old('license', $schoolInformation->school_license) }}" selected>Approved</option>
                            <option value="unapprove">Unapproved</option>
                          @else
                            <option value="none">Select-License-Status</option>
                            <option value="approved">Approved</option>
                            <option value="{{$schoolInformation->school_license !== null ? $schoolInformation->school_license :old('license', $schoolInformation->school_license) }}" selected>Unapproved</option> 
                          @endif
                        </select>
                        <span class="text-danger">
                          @if($errors->has('license'))
                            {{ $license= $errors->first('license')}}
                          @else
                            {{$license=''}}                            
                          @endif
                        </span>                             
                    </div>
                  </div>                        
                </div>
                <div class="row">
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                      <label for="city" class="control-label text-info"> City</label>
                        <input type="text" id="city" name="city" class="form-control" placeholder="Enter City" value="{{$schoolInformation->school_city !== null ? $schoolInformation->school_city :old('city', $schoolInformation->school_city) }}" {{$readOnly}}>
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
                        <input type="text" id="social" name="social" class="form-control" placeholder="Enter Social Medial Handle" value="{{$schoolInformation->school_social_media !== null ? ucfirst($schoolInformation->school_social_media) :old('social', $schoolInformation->school_social_media) }}" {{$readOnly}}>
                        <span class="text-danger">
                          @if($errors->has('social'))
                            {{ $social= $errors->first('social')}}
                          @else
                            {{$social=''}}                            
                          @endif
                        </span>                        
                        </div>
                  </div>                        
                </div>                        
                <div class="row">
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                      <label for="state" class="control-label text-info"> State</label>
                        <select class="form-control" id="state" name="state" {{$disabled}}>
                          @if($schoolInformation->school_state ==="none" || $schoolInformation->school_state === null)
                            <option value="none">Select State</option>
                          @else($schoolInformation->school_state !=="none" || $schoolInformation->school_state !== null)
                            <option value="{{$schoolInformation->school_state !== null ? $schoolInformation->school_state :old('state', $schoolInformation->school_state) }}" selected>{{$schoolInformation->school_state}}</option>
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
                        <select class="form-control" id="localG" name="localG" {{$disabled}}>
                          @if($schoolInformation->school_localG ==="none" || $schoolInformation->school_localG === null)
                            <option value="none">Select Local-Govt</option>
                          @else($schoolInformation->school_localG !=="none" || $schoolInformation->school_localG !== null)
                            <option value="{{$schoolInformation->school_localG !== null ? $schoolInformation->school_localG :old('localG', $schoolInformation->school_localG) }}" selected>{{$schoolInformation->school_localG}}</option>
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
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                      <label for="number-of-staff" class="control-label text-info"> Number Of Staffs</label>
                        <input type="number" id="numberStaff" name="numberStaff" class="form-control" placeholder="Present Number Of Staff" value="{{ isset($numberOfStaffs) && $numberOfStaffs !== '' ? $numberOfStaffs :old('numberStaff', $schoolInformation->school_number_of_staffs)}}" {{$disabled}}>
                        <span class="text-danger">
                          @if($errors->has('numberStaff'))
                            {{ $numberStaff= $errors->first('numberStaff')}}
                          @else
                            {{$numberStaff=''}}                            
                          @endif
                        </span>                         
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                      <label for="school-email" class="control-label text-info" > Description Of The School</label>
                        <textarea type="email" id="description" name="description" class="form-control" placeholder="Enter Short Description Of School" {{$readOnly}}>{{$schoolInformation->school_description !== null ? ucfirst($schoolInformation->school_description) :old('description', $schoolInformation->school_description) }}</textarea>
                        <span class="text-danger">
                          @if($errors->has('description'))
                            {{ $description= $errors->first('description')}}
                          @else
                            {{$description=''}}                            
                          @endif
                        </span>                         
                        </div>
                  </div>                        
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 ">
                    <div class="form-group">
                      <label for="lincense" id="services" class="control-label text-info" > Educational Services</label>
                        <select class="form-control" name="services[]" multiple {{$disabled}}>
                          @if($schoolInformation->school_services ==="none" || $schoolInformation->school_services ===NULL)
                            <option none="none">Select-Educational-Services</option>
                            <option value="creche/playgroup">Creche/Play-Group</option>
                            <option value="nursery">Nursery</option>
                            <option value="primary/basic">Primary/Basic</option>
                            <option value="secondary">Secondary</option>
                          @else($schoolInformation->school_services !=="none")
                            <option none="none">Select-Educational-Services</option>
                            @foreach($services as $key => $value)
                                @if($services[$key]=="creche/playgroup")
                                  <option value="{{$services[$key]}}" selected>Creche/Play-Group</option>
                                @elseif($services[$key]=="nursery")
                                  <option value="{{$services[$key]}}" selected>Nursery</option>
                                @elseif($services[$key]=="primary/basic")
                                  <option value="{{$services[$key]}}" selected>Primary/Basic</option>
                                @elseif($services[$key]=="secondary")
                                  <option value="{{$services[$key]}}" selected>Secondary</option>                                
                                @endif   
                            @endforeach
                            @foreach($schoolServices as $key => $value)
                                @if($schoolServices[$key] =="creche/playgroup")
                                  <option value="{{$schoolServices[$key]}}" >Creche/Play-Group</option>
                                @elseif($schoolServices[$key] =="nursery")
                                  <option value="{{$schoolServices[$key]}}" >Nursery</option>
                                @elseif($schoolServices[$key] =="primary/basic")
                                  <option value="{{$schoolServices[$key]}}" >Primary/Basic</option>
                                @elseif($schoolServices[$key] =="secondary")
                                  <option value="{{$schoolServices[$key]}}">Secondary</option>                                
                                @endif   
                            @endforeach                                                                    
                          @endif      
                        </select>
                        <span class="text-danger">
                          @if($errors->has('services'))
                            {{ $services= $errors->first('services')}}
                          @else
                            {{$services=''}}                            
                          @endif
                        </span>                              
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                      <label for="date" id="date" class="control-label text-info">Established Date</label>
                        <input type="date" name="date" class="form-control" value="{{$schoolInformation->school_establish_date !== null ? $schoolInformation->school_establish_date :old('date',date('m/d/y',strtotime($schoolInformation->school_establish_date))) }}" {{$disabled}}>
                        <span class="text-danger">
                          @if($errors->has('date'))
                            {{ $date= $errors->first('date')}}
                          @else
                            {{$date=''}}                            
                          @endif
                        </span>                         
                      </div>
                  </div>                        
                </div>
                <div class="row">
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                      <label for="license-number" class="control-label text-info" > License Number</label>
                        <input type="text" id="license" name="licenseNumber" class="form-control" placeholder="Enter License Number" value="{{$schoolInformation->school_license_number !== null ? $schoolInformation->school_license_number :old('licenseNumber', $schoolInformation->school_license_number) }}" {{$readOnly}}>
                        <span class="text-danger">
                          @if($errors->has('licenseNumber'))
                            {{ $licenseNumber= $errors->first('licenseNumber')}}
                          @else
                            {{$licenseNumber=''}}                            
                          @endif
                        </span>                        
                      </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                      <label for="postal-address" class="control-label text-info" >Postal Address</label>
                        <input type="text" id="postalCode" name="postalAddress" class="form-control" placeholder="Enter Postal Code" value="{{$schoolInformation->school_postal_address !== null ? $schoolInformation->school_postal_address :old('postalAddress', $schoolInformation->school_postal_address) }}" {{$readOnly}}>
                        <span class="text-danger">
                          @if($errors->has('postalCode'))
                            {{ $postalCode= $errors->first('postalCode')}}
                          @else
                            {{$postalCode=''}}                            
                          @endif
                        </span>                        
                      </div>
                  </div>                        
                </div>
                <div class="row">
                  <div class="col-md-6 offset-sm-6 col-sm-6">
                    <div class="form-group">
                      <br><br>
                        <button type="submit"  id="updateInformation"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Save </button>
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
       