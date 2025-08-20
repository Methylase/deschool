
@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Assign Subject </h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold"> Assign Subject </h6>
                  <div class="float-right text-danger " id="subjectToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="subject-body">
                  <div class="col-lg-12 mb-4">                
                     <h6 class="m-0  font-weight-bold"> Assign Subjects to Teacher</h6>                
                     <form class="form" action="" method="">
                        {{csrf_field()}}
                        <div class="row">
                         <div class="col-md-6 col-sm-6">
                           <div class="form-group teacher-name-group">
                             <label for="teacher-name" class="control-label text-info"> Teacher Name</label>
                              <select class="form-control" id="teacher-name" name="teacher-name">
                                <option value="">Select-Teacher-Name</option>
                                @if(isset($teacher_result) && $teacher_result !="")
                                  @foreach($teacher_result as $teacher) 
                                    <option value="{{$teacher['id']}}">{{ucfirst($teacher['fullname'])}}</option>
                                  @endforeach
                                @endif                  
                              </select>
                           </div>
                         </div>
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
                       </div>
                       <div class="row">
                         <div class="col-md-6 offset-sm-6 col-sm-6">
                           <div class="form-group">
                              <button type="button"  id="assignSubject"  class="btn btn-success form-control" ><i class="fa fa-save"></i>   Assign Subject </button>
                           </div>
                         </div>
                       </div>  
                     </form>
                     <hr>
                  <div class="table-responsive">      
                    @if(isset($assignSubjects) && $assignSubjects !='')
                      <h6 class="m-4 font-weight-bold">Table For Subjects Assign To A Teacher</h6>        
                    <table class="table table-bordered border-bottom-info" id="dataTableAssignSubject" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                        <th>S/N</th>
                          <th>Teacher's Name</th>
                          <th>Subject Name</th>
                        </tr>
                      </thead>
                        @php$i=1
                        @endphp
                        <tbody>
                          @foreach($assignSubjects as $assignSubject)
                            <tr>
                              <td>{{$i}}</td>
                              <td>
                              {{ucfirst($assignSubject['fullname'])}}
                              </td>
                              <td>   
                              {{ucfirst($assignSubject['subject'])}}                           
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
          </div>
        <!-- /.container-fluid -->

@endsection