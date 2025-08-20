@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Result Aggregator</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold">Result Aggregator</h6>
                  <div class="float-right text-danger " id="resultAggregatorToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="result-aggregator-body">      
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
                        <div class="form-group term-name-group">
                          <label for="term" class="control-label text-info"> Term Of The Year</label>
                          <select class="form-control" id="term-name" name="term-name">
                            <option value="">Select-Class</option>
                            <option value="first term">First Term</option>
                            <option value="second-term">Second Term</option>
                            <option value="third-term">Third Term</option>                               
                          </select>
                        </div>
                      </div>                           
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group year-group">
                          <label for="year" class="control-label text-info">Session Year</label>
                          <input  type="text" value="{{date('Y').'-'.(date('Y')+1)}}" name="year" id="year" class="form-control" readonly>
                        </div>
                      </div> 
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group student-name-group">
                          <label for="student-name" class="control-label text-info"> Student Name</label>
                          <select class="form-control" id="student-name" name="student-name">
                              <option value="">Select-Student-Name</option> 

                              @if(isset($students) && $students !="")
                                @foreach($students as $student) 
                                  <option value="{{$student->id}}">{{ucwords($student->student_firstname.' '. $student->student_lastname)}}</option>
                                @endforeach
                              @endif                  
                          </select>
                        </div>
                      </div>                                                                        
                    </div>                      
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group subject-name-group">
                          <label for="subject-name" class="control-label text-info"> Subject Name</label>
                          <select class="form-control" id="subject-name" name="subject-name">
                              <option value="">Select-Subject-Name</option> 
                                @if(isset($subjects) && $subjects !="")
                                  @foreach($subjects as $subject) 
                                    <option value="{{$subject->id}}">{{ucfirst($subject->subject_name)}}</option>
                                  @endforeach
                                @endif            
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group mark-type-group">
                          <label for="mark-type" class="control-label text-info"> Mark Type</label>
                          <select class="form-control" id="mark-type" name="mark-type">
                            <option value="">Select-Mark-Type</option>
                            <option value="note">Note Assessment</option>
                            <option value="assignment">Assignment Mark</option>
                            <option value="first test">First Test Mark</option>  
                            <option value="second test">Second Test Mark</option>    
                            <option value="examination">Examination Mark</option>  
                          </select>
                        </div>
                      </div>                                                  
                    </div>  
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group mark-group">
                          <label for="mark-name" class="control-label text-info"> Mark</label>
                          <input class="form-control" v id="mark-name"  name="mark-name" placeholder="Enter Mark">
                        </div>
                      </div> 
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">  
                          <br><br>                     
                          <button type="button"  id="saveResult"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Save</button>
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