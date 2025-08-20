@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Students Class Status</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

        
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold">Students Class Status</h6>
                  <div class="float-right text-danger " id="classStatusToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="class-status-body">
                  <form class="form" action=""  method="">
                    {{csrf_field()}}                    
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group class-name-group">
                          <label for="class-name" class="control-label text-info"> Class Name</label>
                          <select class="form-control" id="class-name" name="class-name">
                            <option value="">Select-Class</option>
                            @if(isset($classes) && $classes !="")
                                @foreach($classes as $class) 
                                    <option value="{{$class->id}}">{{ucfirst($class->class_name)}}</option>
                                @endforeach
                            @endif                                
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group student-name-group">
                          <label for="student-name" class="control-label text-info"> Student Name</label>
                          <select class="form-control" id="student-name" name="student-name">
                              <option value="">Select-Student-Name</option>                                
                          </select>
                        </div>
                      </div>                            
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group term-name-group">
                          <label for="term" class="control-label text-info"> Term Of The Year</label>
                          <select class="form-control" id="term-name" name="term-name">
                                <option value="">Select-Term</option>
                                <option value="first term">First Term</option>
                                <option value="second-term">Second Term</option>
                                <option value="third-term">Third Term</option>                               
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group year-group">
                          <label for="year" class="control-label text-info">Session Year</label>
                          <input class="form-control" value="{{date('Y').'-'.(date('Y')+1)}}" id="year"  name="year" readonly>
                        </div>
                      </div>                            
                    </div>                    
                    <div class="row">
                      <div class="offset-md-6 col-md-6 offset-sm-6 col-sm-6">
                        <div class="form-group">                       
                          <button type="button"  id="saveStatus"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Save </button>
                        </div>
                      </div>
                    </div>  
                  </form>
                  <hr>
                  <br>
                  <div class="promotion"></div>
                  <h6 class="m-0 font-weight-bold">Promote student to the next class</h6>
                  <br>
                  <form class="form" action=""  method="">
                    {{csrf_field()}}                    
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group present-class-group">
                          <label for="class-name" class="control-label text-info">Present Class Name</label>
                          <select class="form-control" id="present-class" name="present-class">
                            <option value="">Select-Class</option>
                            @if(isset($classes) && $classes !="")
                                @foreach($classes as $class) 
                                  <option value="{{$class->id}}">{{ucfirst($class->class_name)}}</option>
                                @endforeach
                            @endif                                
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group student-group">
                          <label for="student-name" class="control-label text-info"> Student Name</label>
                          <select class="form-control" id="student" name="student">
                            <option value="">Select-Student-Name</option>                                
                          </select>
                        </div>
                      </div>                            
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group promote-class-group">
                          <label for="class-name" class="control-label text-info">Promotion Class Name</label>
                          <select class="form-control" id="promote-class" name="promote-class">
                            <option value="">Select-Class</option>
                            @if(isset($classes) && $classes !="")
                                @foreach($classes as $class) 
                                  <option value="{{$class->id}}">{{ucfirst($class->class_name)}}</option>
                                @endforeach
                            @endif                                
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <br><br>
                          <button type="button"  id="promoteStudent"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Promote</button>
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