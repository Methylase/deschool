
@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Add New Student</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

        
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold"> Add New Student </h6>
                  <div class="float-right text-danger " id="studentToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="student-body">
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
                  <form class="form" action="/add-student" enctype="multipart/form-data" method="POST">
                     {{csrf_field()}}
                      <input type="hidden" name="userId" value="{{$userId}}">
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
                           <input type="text" id="firstname" name="firstname" class="form-control" placeholder="Enter FirstName">
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
                           <input type="text" id="middlename" name="middlename" class="form-control" placeholder="Enter MiddleName" >
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
                           <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Enter MiddleName" value="">
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
                             <input type="email" id="email" name="email" class="form-control" placeholder="Enter  Email" value="">
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
                            <textarea  id="address" name="address" class="form-control" placeholder="Enter Student Address" ></textarea>
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
                              <label for="gender" class="radio-inline text-info">Male</label>
                              <input type="radio" id="gender-male" name="gender" value="male">
                              <label for="gender" class="radio-inline text-info">Female</label>                                                                     
                              <input type="radio" id="gender-female" name="gender"   value="female">
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
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Student Phone Number">
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
                            <input type="date" id="dob" name="dob" class="form-control">
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
                              <option value="">Select-Disability</option>
                              <option value="yes">Yes</option>
                              <option value="no">No</option>                   
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
                           <textarea  id="listDisability" name="listDisability" class="form-control" placeholder="Enter The List Of Disability" ></textarea>
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
                            <textarea  id="hobbies" name="hobbies" class="form-control" placeholder="Enter Student Hobbies" ></textarea>
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
                          <label for="register-number"  class="control-label text-info"> Registration Number</label>
                            <input type="text" id="registerNumber" name="registerNumber" class="form-control" placeholder="Enter Registration Number">                        </div>
                            <span class="text-danger">
                              @if($errors->has('registerNumber'))
                                {{ $registerNumber= $errors->first('registerNumber')}}
                              @else
                                {{$registerNumber=''}}                            
                              @endif
                            </span>        
                        </div>                                                  
                     </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="city" class="control-label text-info"> City</label>
                            <input type="text" id="city" name="city" class="form-control" placeholder="Enter City">
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
                           <label for="class-name" class="control-label text-info" > Parent's Name</label>
                                <select class="form-control" id="parentName" name="parentName">
                                   <option value="">Select-Parent's-Name</option>
                                    @if($parents !=null )
                                    @foreach($parents as $parent)
                                      @if($parent->parent_gender=='male')
                                         @php $fullname = 'Mr '.ucfirst($parent->parent_firstname).' '.ucfirst($parent->parent_lastname)
                                         @endphp
                                      @elseif($parent->parent_gender=='female')
                                         @php $fullname = 'Mrs '.ucfirst($parent->parent_firstname).' '.ucfirst($parent->parent_lastname)
                                         @endphp
                                      @else
                                         @php $fullname = ucfirst($parent->parent_firstname).' '.ucfirst($parent->parent_lastname)
                                         @endphp
                                      @endif
                                         <option value="{{$parent->id}}">{{$fullname}}</option>
                                      @endforeach
                                    @endif
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
                              <option value="">Select-Class-Name</option>
                              @if($classes !=null )
                                  @foreach($classes as $class)
                                      <option value="{{$class->id}}">{{ucfirst($class->class_name)}}</option>
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
                                  <option value="">Select-Session</option>
                                  @for($i=1950; $i <= date('Y'); $i++)
                                      <option value="{{$i}}" selected>{{$i}}</option> 
                                  @endfor
                                </select>
                                <span class="text-danger">
                              `   @if($errors->has('session'))
                                    {{ $session= $errors->first('session')}}
                                  @else
                                    {{$session=''}}                            
                                  @endif
                                </span>  `                         
                              </div>
                         </div>                    
                     </div>                     
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <label for="state" class="control-label text-info"> State</label>
                            <select class="form-control" id="state" name="state">
                                 <option value="">Select State</option>
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
                              <option value="">Select Local-Government</option>
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
                           <button type="submit"  id="updateStaff"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Save </button>
                        </div>
                      </div>
                    </div>  
                  </form>
                </div>
              </div>
            </div>
          </div>
        <!-- /.container-fluid -->
  @endsection