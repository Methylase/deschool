@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit mark</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold">Edit Mark</h6>
                  <div class="float-right text-danger " id="resultAggregatorToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="result-aggregator-body">   
                    
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
                  <form class="form" action="/update-mark" enctype="multipart/form-data" method="POST">
                    {{method_field('PUT')}}   
                    {{csrf_field()}}    
                    <input type="hidden" name="id" value="{{old('id', $mark->id)}}">

                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group class-name-group">
                          <label for="class-name" class="control-label text-info"> Class Name</label>
                          <input type="text" class="form-control" readonly value="{{$class !== null ? ucfirst($class->class_name) :old('class-name', ucfirst($class->class_name)) }}">
                          <input type="hidden" value="{{$class !== null ? $class->id :old('class-name', $class->id) }}" class="form-control" name="class_name">
                            
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">                       
                        <div class="form-group term-name-group">
                          <label for="term" class="control-label text-info"> Term Of The Year</label>
                          <input type="text" class="form-control" readonly value="{{$mark !== null ? $mark->term :old('term-name', $mark->term) }}" name="term_name">
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
                          <input type="text" class="form-control" readonly value="{{$student !== null ? ucwords($student->student_firstname.' '. $student->student_lastname) :old('student-name', ucwords($student->student_firstname.' '. $student->student_lastname)) }}">
                          <input type="hidden" value="{{$student !== null ? $student->id :old('student-name', $student->id) }}" class="form-control" id="student-name" name="student_name">
                            
                        </div>
                      </div>                                                                        
                    </div>                      
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group subject-name-group">
                          <label for="subject-name" class="control-label text-info"> Subject Name</label>
                          <input type="text" class="form-control" readonly value="{{$subject !== null ? $subject->subject_name :old('subject-name', $subject->subject_name) }}">
                          <input type="hidden" value="{{$subject !== null ? $subject->id :old('subject-name', $subject->id) }}" class="form-control" id="subject-name" name="subject_name">
                            
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group mark-type-group">
                          <label for="mark-type" class="control-label text-info"> Mark Type</label>
                          <input type="text" readonly class="form-control" value="{{$mark !== null ? $mark->mark_type :old('mark-type', $mark->mark_type) }}" id="mark-type" name="mark_type">
                        </div>
                      </div>                                                  
                    </div>  
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group mark-group">
                          <label for="mark-name" class="control-label text-info"> Mark</label>
                          <input class="form-control"  class="form-control" value="{{$mark !== null ? $mark->mark :old('mark-name', $mark->mark) }}" id="mark-name"  name="mark_name" placeholder="Enter Mark">
                        </div>
                      </div> 
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">  
                          <br><br>                     
                          <button type="submit"   class="btn btn-success form-control" ><i class="fa fa-save"></i> Save</button>
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