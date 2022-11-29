@extends('layouts.app')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> View Students Table</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-danger"> View Students Table </h6>
                  <div class="float-right text-danger " id="viewStudentsToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="view-students-body">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                          <h6 class="m-0 font-weight-bold text-info">Students Table</h6>
                           <a href="/deschool/add-student" class="btn btn-sm btn-danger float-right">Add Student</a>
                        </div>
                           
                        <div class="card-body">
                          <div class="table-responsive">
                           @if(isset($studentInformation) && $studentInformation != null )
                            <table class="table table-bordered  border-bottom-info" id="dataTable" width="100%" cellspacing="0">
                              <thead>
                                <tr>
                                <th>S/N</th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Gender</th>
                                  <th>Class</th>
                                  <th>Parent</th>                                  
                                  <th>Phone Number</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                                @php$i=1
                                @endphp
                                 @foreach($studentInformation as $student)
                                    <tbody>
                                       <tr>
                                          <td>{{$i}}</td>
                                          <td>{{ucfirst($student->student_firstname).' '.ucfirst($student->student_lastname)}}</td>
                                          <td>{{ucfirst($student->student_email)}}</td>
                                          <td>{{ucfirst($student->student_gender)}}</td>
                                             @if($information['parentGender']=='male')
                                                @php $parentFullname = 'Mr '.$information['parentNames'];
                                                @endphp
                                             @elseif($information['parentGender']=='female')
                                                @php $parentFullname = 'Mrs '.$information['parentNames'];
                                                @endphp
                                             @else
                                                @php $parentFullname = $information['parentNames'];
                                                @endphp
                                             @endif                                             
                                          <td>{{$information['className']}}</td>
                                          <td>{{$parentFullname}}</td>
                                          <td>{{$student->student_phone}}</td>
                                          <td>
                                             <a href="/deschool/edit-student/{{$student->id}}" class="btn btn-sm btn-info" title="Edit"><span class="fa fa-edit"></span></a>                                         
                                             <a href="" class="btn btn-sm btn-danger deleteStudent"  id='del {{$student->id}}' data-title="Delete" data-toggle="modal" data-target="#confirm-delete"><span class="fa fa-trash" title="Delete"></span></a>
                                             
                                          </td>  
                                       </tr>
                                    </tbody>
                                 @php$i++
                                 @endphp
                                 @endforeach
                            </table>
                              <div class="row col-md-12">
                                 @if( $paginator->hasPages())
                                    <div class="col-md-6  col-sm-6">
                                       <ul class="pagination">
                                          <li>{{'Showing '.$paginator->currentPage().' to '.$paginator->perPage().' of '.$paginator->total().' entries'}}</li>
                                       </ul>                          
                                    </div>
                                  @endif
                                 @if( $paginator->hasPages())
                                    <div class="offset-md-2 col-md-4 offset-sm-2 col-sm-4">
                                       @if( $paginator->lastPage() > 1)
                                       <ul class="pagination">
                                         <li class="{{ ( $paginator->currentPage() ==1 ) ? 'disabled': ''}}">
                                          <a href="{{ $paginator->url(1) }}" class="{{ ( $paginator->currentPage() ==1 ) ? 'disabled': ''}} btn btn-sm btn-info paginate-btn">Previous</a>
                                         </li>
                                          @for( $i = 1; $i <= $paginator->lastPage(); $i++ )
                                             <li class="{{ ($paginator->currentPage() == $i) ? 'active' : ''}}">
                                                <a href="{{ $paginator->url($i) }}" class="btn btn-sm btn-info paginate-btn">{{$i}}</a>
                                             </li>
                                          @endfor
                                          <li class="{{ ( $paginator->currentPage() ==$paginator->lastPage() ) ? 'disabled' : '' }}">
                                             <a href="{{ $paginator->url( $paginator->currentPage()+1) }}" class="{{ ( $paginator->currentPage() ==$paginator->lastPage() ) ? 'disabled' : '' }} btn btn-sm btn-info paginate-btn">Lastpage</a>
                                          </li>
                                       </ul>
                                       @endif
                                     </div>
                                 @endif                                 
                              </div>
                             @else
                                <div class='offset-md-1 col-md-10 offset-sm-1 col-sm-10 text-center'>
                                    {{'No record for Student '}}
                                </div>
                             @endif
                             <!-- modal for delete staff -->
                              <div class="modal col-md-10 offset-md-2  col-sm-10 offset-sm-2 " id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">                  
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title text-info" id="Heading">Delete this student</h4>
                                    </div>
                                    <div class="modal-body">
                                      <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span> Are you sure you want to delete this student?</div>
                                    </div>
                                    <div class="modal-footer">
                                      <button  class="btn btn-success del_student"><span class="fa fa-check-circle"></span> Yes</button>
                                      <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                               <!-- end of modal for delete staff -->
                          </div>
                        </div>
                    </div>                    
                </div>
              </div>
            </div>
          </div>
      <!-- End of Main Content -->
  @endsection
