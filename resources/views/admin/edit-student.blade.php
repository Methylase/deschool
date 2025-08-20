
@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Edit Student</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

        
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-danger"> Edit Student </h6>
                  <div class="float-right text-danger " id="editStudentToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="edit-student-body">
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
                <form class="form" action="/update-student" enctype="multipart/form-data" method="POST">
                    {{method_field('PUT')}}

                    {{csrf_field()}}
                     <input type="hidden" name="id" value="{{old('id', $studentInformation->id)}}">
                     <input type="hidden" name="userId" value="{{$studentInformation->corox_model_id ? old('id', $studentInformation->corox_model_id) : $userId}}">
                     <div class="row">
                        <div class="col-md-6 col-sm-6 ">                      
                           <div class="form-group">             
                            <img src="{{$studentInformation->student_profile_image !== null || $studentInformation->student_profile_image !='' ? url('uploads/'.$studentInformation->student_profile_image) : asset('admin/img/The-Register.jpg') }}" width=200 height=150 class="col-md-4 col-sm-4 img-responsive img-rounded">                                 
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
                           <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Enter FirstName" value="{{$studentInformation->student_firstname !== null ? $studentInformation->student_firstname :old('firstname', $studentInformation->student_firstname) }}">
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
                           <input type="text" id="middlename" name="middlename" class="form-control" placeholder="Enter MiddleName" value="{{$studentInformation->student_middlename !== null ? $studentInformation->student_middlename :old('middlename',  $studentInformation->student_middlename) }}">
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
                           <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Enter MiddleName" value="{{$studentInformation->student_lastname !== null ? $studentInformation->student_lastname :old('lastname',  $studentInformation->student_lastname) }}">
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
                             <input type="email" id="email" name="email" class="form-control" placeholder="Enter  Email" value="{{$studentInformation->student_email !== null ? $studentInformation->student_email :old('email',  $studentInformation->student_email) }}">
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
                          <label for="school-address" class="control-label text-info"> Address</label>
                            <textarea  id="address" name="address" class="form-control" placeholder="Enter Parent Address" >{{$studentInformation->student_address !== null ? $studentInformation->student_address :old('address', $studentInformation->student_address) }}</textarea>
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
                        <div class="form-group" style="margin-top:40px">
                           @if($studentInformation->student_gender ==="none" || $studentInformation->student_gender ===NULL)                        
                              <label for="gender" class="radio-inline text-info">Male</label>
                              <input type="radio" id="gender-male" name="gender" value="male">
                              <label for="gender" class="radio-inline text-info">Female</label>                                                                     
                              <input type="radio" id="gender-female" name="gender"   value="female">
                           @elseif($studentInformation->student_gender ==="male")
                              <label for="gender" class="radio-inline text-info">Male</label>
                              <input type="radio" id="gender-male" name="gender" value="{{$studentInformation->student_gender ==="male" ? $studentInformation->student_gender :old('gender', $studentInformation->student_gender) }}" checked>
                              <label for="gender" class="radio-inline text-info">Female</label>                                                                     
                              <input type="radio" id="gender-female" name="gender"  value="female">
                           @elseif($studentInformation->student_gender ==="female")
                              <label for="gender" class="radio-inline text-info">Male</label>
                              <input type="radio" id="gender-male" name="gender" value="male">
                              <label for="gender" class="radio-inline text-info">Female</label>                                                                     
                              <input type="radio" id="gender-female" name="gender"  value="{{$studentInformation->student_gender ==="female" ? $studentInformation->student_gender :old('gender', $studentInformation->student_gender) }}" checked>
                           @endif
                        </div>
                      </div>
                    </div>                        
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="phone-number" class="control-label text-info"> Phone Number </label>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Parent Phone" value="{{$studentInformation->student_phone !== null ? $studentInformation->student_phone :old('phone', $studentInformation->student_phone) }}">
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="date-of-birth" class="control-label text-info">Date Of Birth</label>
                            <input type="date" id="dob" name="dob" class="form-control" value="{{$studentInformation->student_dob !== null ? $studentInformation->student_dob :old('dob',date('m/d/y',strtotime($studentInformation->student_dob))) }}">
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
                              @if($studentInformation->student_disability ==="none" || $studentInformation->student_disability ===NULL)
                                 <option value="none">Select-Disability</option>
                                 <option value="yes">Yes</option>
                                 <option value="no">No</option>
                              @elseif($studentInformation->student_disability ==="yes")
                                 <option value="none">Select-Disability</option>                                 
                                 <option value="{{$studentInformation->student_disability ==='yes'? $studentInformation->student_disability :old('disabilityStatus', $studentInformation->student_disability) }}" selected>{{ucfirst($studentInformation->student_disability)}}</option>
                                 <option value="no">No</option>  
                              @elseif($studentInformation->student_disability ==="no")
                                 <option value="none">Select-Disability</option>                                   
                                  <option value="yes">Yes</option>
                                 <option value="{{$studentInformation->student_disability ==='no'? $studentInformation->student_disability :old('disabilityStatus', $studentInformation->student_disability) }}" selected>{{ucfirst($studentInformation->student_disability)}}</option>      
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
                           <textarea  id="listDisability" name="listDisability" class="form-control" placeholder="Enter The List Of Disability" >{{$studentInformation->student_list_disability !== null ? $studentInformation->student_list_disability :old('listDisability', $studentInformation->student_list_disability) }}</textarea>
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
                            <textarea  id="hobbies" name="hobbies" class="form-control" placeholder="Enter Parent Hobbies" >{{$studentInformation->student_hobbies !== null ? $studentInformation->student_hobbies :old('hobbies', $studentInformation->student_hobbies) }}</textarea>
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
                          <label for="registration-number" class="control-label text-info"> Registration Number</label>
                           <input type="text" id="registerNumber" name="registerNumber" class="form-control" placeholder="Enter Registration Number" value="{{$studentInformation->student_registration_number !== null ? $studentInformation->student_registration_number :old('address', $studentInformation->student_registration_number) }}" disabled>
                          </div>
                      </div>                         
                     </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="city" class="control-label text-info"> City</label>
                            <input type="text" id="city" name="city" class="form-control" placeholder="Enter City" value="{{$studentInformation->student_city !== null ? $studentInformation->student_city :old('city', $studentInformation->student_city) }}">
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
                           <label for="social-media" class="control-label text-info" > Parent's Name</label>
                            <select class="form-control" id="parentName" name="parentName">
                            <option value="none" >Select Local-Govt</option>
                              @foreach($parents as $parent)
                                    @if($parent->parent_gender !=null || $parent->parent_gender !='' || $parent->parent_gender=='male')
                                       @php $fullname = 'Mr '.ucfirst($parent->parent_firstname).' '.ucfirst($parent->parent_lastname)
                                       @endphp
                                    @elseif($parent->parent_gender !=null || $parent->parent_gender !='' || $parent->parent_gender=='female')
                                       @php $fullname = 'Mrs '.ucfirst($parent->parent_firstname).' '.ucfirst($parent->parent_lastname)
                                       @endphp
                                    @else
                                       @php $fullname = ucfirst($parent->parent_firstname).' '.ucfirst($parent->parent_lastname)
                                       @endphp
                                    @endif                                  
                                @if($information[0]['parentId'] === 'none' || $information[0]['parentId'] === null)
                                   <option value="none" selected>Select Local-Govt</option>
                                  <option value="{{$parent->id !== null ? $parent->id :old('parentName',$parent->id) }}">{{$fullname}}</option>                                  
                                @elseif($information[0]['parentId'] !=="none" )
                                  @if($information[0]["parentId"] == $parent->id)
                                                              
                                   <option value="{{$information[0]['parentId'] == $parent->id ? $information[0]['parentId'] :old('parentName',$information[0]['parentId']) }}" selected>{{$fullname}}</option>
                                  @else
                                    
                                   <option value="{{$parent->id}}" >{{$parent->parent_firstname}}</option>
                                  @endif
                                @endif   
                              @endforeach 
                            </select>
                            <span class="text-danger">
                              @if($errors->has('parentName'))
                                {{ $parentName= $errors->first('parentName')}}
                              @else
                                {{$parentName=''}}                            
                              @endif
                            </span>                        
                        </div>
                      </div>                        
                    </div>
                   <div class="row">
                     <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <label for="class-name" class="control-label text-info" > Assign Class</label>
                                <select class="form-control" id="className" name="className">
                                   <option value="none">Select-Class-Name</option>
                                    @if($classes !=null )
                                       @foreach($classes as $class)
                                          @if($information[0]["classId"] == $class->id)
                                           <option value="{{$information[0]['classId'] == $class->id ? $information[0]['classId'] :old('className',$information[0]['classId']) }}" selected>{{ucfirst($class->class_name)}}</option>
                                          @else
                                             <option value="{{$class->id}}" >{{ucfirst($class->class_name)}}</option>
                                          @endif
                                       @endforeach
                                    @endif
                                </select>
                                <span class="text-danger">
                                @if($errors->has('className'))
                                  {{ $className= $errors->first('className')}}
                                @else
                                  {{$className=''}}                            
                                @endif
                              </span> 
                            </div>
                      </div>                   
                         <div class="col-md-6 col-sm-6 ">
                           <div class="form-group">
                             <label for="class-name" class="control-label text-info"> Year / Session</label>
                                <select class="form-control" id="session" name="session">
                                   <option value="none">Select-Session</option>
                                    @for($i=1950; $i <= date('Y'); $i++)
                                       @if($studentInformation->student_session == $i)
                                          <option value="{{$studentInformation->student_session}}" selected>{{$studentInformation->student_session}}</option>
                                       @else
                                          <option value="{{$i}}" >{{$i}}</option>  
                                       @endif
                                    @endfor
                                </select>
                                <span class="text-danger">
                                 @if($errors->has('session'))
                                    {{ $session= $errors->first('session')}}
                                  @else
                                    {{$session=''}}                            
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
                              @if($studentInformation->student_state ==="none" || $studentInformation->student_state === null)
                                 <option value="none">Select State</option>
                              @else($studentInformation->student_state !=="none" || $studentInformation->student_state !== null)
                                 <option value="{{$studentInformation->student_state !== null ? $studentInformation->student_state :old('state', $studentInformation->student_state) }}" selected>{{$studentInformation->student_state}}</option>
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
                              @if($studentInformation->student_localG ==="none" || $studentInformation->student_localG === null)
                                 <option value="none">Select Local-Govt</option>
                              @else($studentInformation->student_localG !=="none" || $studentInformation->student_localG !== null)
                                 <option value="{{$studentInformation->student_localG !== null ? $studentInformation->student_localG :old('localG', $studentInformation->student_localG) }}" selected>{{$studentInformation->student_localG}}</option>
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
                           <button type="submit"  id="updateStudent"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Save </button>
                        </div>
                      </div>
                    </div>  
                  </form>
                </div>
              </div>
            </div>
          </div>
        <!-- /.container-fluid -->
      <!-- End of Main Content -->
  @endsection
