@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Select Subject</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

        
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Select Subject</h6>
                  <div class="float-right text-danger " id="selectSubjectToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="select-subject-body">
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
                      <div class="col-md-6 col-sm-6 ">
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
                        <div class="checkbox class-department-group">
                          <br><br>
                          <label for="condition" class="control-label text-info">If Senior Class Check</label>
                          <input type="checkbox" id="condition" name="condition" >
                        </div>
                      </div>                                             
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group class-department-group senior" style="display:none">
                          <label for="department-name" class="control-label text-info"> Department Name</label>
                          <select id="department" name="department" class="form-control" >
                            <option value="">Select Department</option>
                            <option value="science">Science Department</option>
                            <option value="commercial">Commercial Department</option>
                            <option value="art">Art Department</option>
                          </select>
                        </div>
                      </div> 
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                          <br><br>                   
                          <button type="button"  id="selectSubject"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Save </button>
                        </div>
                      </div> 
                    </div>   
                                      
                  </form>
                  <hr>
                  <div class="table-responsive">      
                    @if(isset($studentSubjects) && $studentSubjects !='')
                      <h6 class="m-4  font-weight-bold">Table For Student's Subjects in different classes</h6>        
                    <table class="table table-bordered  border-bottom-info display" id="dataTableSelectSubject" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                        <th>S/N</th>
                          <th>Student Name</th>
                          <th>Subject Name</th>
                          <th>Class Name</th>
                          <th>Academic Year</th>
                        </tr>
                      </thead>
                        @php$i=1
                        @endphp
                        <tbody>
                          @foreach($studentSubjects as $studentSubject)
                            <tr>
                              <td>{{$i}}</td>
                              <td>
                              {{ucfirst($studentSubject['fullname'])}}
                              </td>                             
                              <td>   
                              {{ucfirst($studentSubject['subject'])}}                           
                              </td>
                              <td>
                              {{ucfirst($studentSubject['class'])}}
                              </td> 
                              <td>
                              {{ucfirst($studentSubject['year'])}}
                              </td>                                                                                           
                            </tr>
                          @php$i++
                          @endphp
                          @endforeach
                          </tbody>   
                    </table>
                      @endif
                  </div>                   
                </div>
              </div>
            </div>
          </div>
      <!-- End of Main Content -->
  @endsection