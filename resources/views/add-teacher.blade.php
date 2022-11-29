
@extends('layouts.app')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            @if(Auth::user()->isMember())
                <h1 class="h3 mb-0 text-gray-800"> Teacher Register </h1>
            @elseif(Auth::user()->isAdmin())
                <h1 class="h3 mb-0 text-gray-800"> Add Teacher </h1>
            @endif                
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                @if(Auth::user()->isMember())
                  <h6 class="m-0 font-weight-bold text-danger">Teacher Register </h6>
                @elseif(Auth::user()->isAdmin())
                   <h6 class="m-0 font-weight-bold text-danger"> Add Teacher </h6>
                @endif                          
                  <div class="float-right text-danger " id="teacherToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="teacher-body">
                  <div class="col-lg-12 mb-4">
                    @if(Auth::user()->isMember())
                        <h6 class="m-0  text-danger"> Teacher Present For The Day should Clock In</h6>                          
                    @elseif(Auth::user()->isAdmin())    
                        <h6 class="m-0  text-danger"> Assign A Staff To Teacher Role</h6>                
                        <form class="form" action="" method="">
                           {{csrf_field()}}
                           <div class="row">
                            <div class="col-md-4 col-sm-4 ">
                              <div class="form-group staffName-group">
                                <label for="staff-name" class="control-label text-info"> Staff Name</label>
                                 <select class="form-control" id="staffName" name="staffName">
                                   <option value="none">Select-Staff-Name</option>
                                   @foreach($staffInformation as $staff)
                                       <option value="{{$staff->id}}">{{ucfirst($staff->staff_firstname).' '.ucfirst($staff->staff_lastname)}}</option>
                                   @endforeach                                    
                                 </select>
                              </div>
                            </div>
                            <div class="col-md-4 col-sm-4 ">
                              <div class="form-group teacherRole-group">
                                <label for="teacher-role" class="control-label text-info"> Teacher Role</label>
                                 <select class="form-control" id="teacherRole" name="teacherRole">
                                   <option value="none">Select-Teacher-Role</option>
                                   <option value="subjectteacher">Subject-Teacher</option>
                                     <option value="classteacher">Class-Teacher</option>    
                                 </select>
                              </div>
                            </div>
                            <div class="col-md-4 col-sm-4 ">
                              <div class="form-group className-group">
                                <label for="class-name" class="control-label text-info"> Class Name</label>
                                 <select class="form-control" id="className" name="className">
                                    <option value="none">Select-Class-Name</option>
                                  
                                   @foreach($classes as $class)
                                       <option value="{{$class->id}}">{{ucfirst($class->class_name)}}</option>
                                   @endforeach
                                 </select>
                              </div>
                            </div>                              
                          </div>
                          <div class="row">
                            <div class="offset-md-8 col-md-4 offset-sm-8 col-sm-4">
                              <div class="form-group">
                                 <button type="button"  id="assignTeacher"  class="btn btn-success form-control" ><i class="fa fa-save"></i>   Assign Subject </button>
                              </div>
                            </div>
                          </div>  
                        </form>
                          <div class="table-responsive">
                                          
                           @if(isset($teacherInformation) && $teacherInformation !='')
                              <h6 class="m-4  text-danger">Edit Table For Teacher</h6>        
                            <table class="table table-bordered  border-bottom-info" id="dataTable" width="100%" cellspacing="0">
                              <thead>
                                <tr>
                                <th>S/N</th>
                                  <th>Staff Name</th>
                                  <th>Teacher Role</th>
                                  <th>Class Name</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                                @php$i=1
                                @endphp
                                 @foreach($teacherInformation as $teacher)
                                    <tbody>
                                       <tr>
                                          <td>{{$i}}</td>
                                          <td id="staffId" val-id="{{$staff->id}}">
                                            @foreach($staffs as $staff)
                                              @if($staff->staff_firstname.' '.$staff->staff_lastname == $teacher['staffName'])
                                               {{ucfirst($staff->staff_firstname).' '.ucfirst($staff->staff_lastname)}}

                                              @endif   
                                            @endforeach
                                          </td>
                                          <td>
                                            <select class="form-control teacherRole"  name="classNameA">
                                             <option value="none">Select-Class-Name</option>
                                                    @if($teacher['teacherRole'] == 'subjectteacher')
                                                      <option value="{{$teacher['teacherRole']}}" selected>Subject-Teacher</option>
                                                      <option value="classteacher">Class-Teacher</option>  
                                                    @elseif($teacher['teacherRole'] == 'subjectteacher,classteacher')
                                                      @php $teacherRole = explode(',',$teacher['teacherRole']);
                                                      @endphp
                                                        <option value="{{$teacherRole[0]}}" selected>Subject-Teacher</option>
                                                        <option value="{{$teacherRole[1]}}" selected>Class-Teacher</option>  
                                                    @elseif($teacher['teacherRole'] == 'classteacher')
                                                      <option value="subjectteacher">Subject-Teacher</option>                                                      
                                                      <option value="{{$teacher['teacherRole']}}" selected>Class-Teacher</option>                                                      
                                                    @endif   
                                                 
                                             </select>                                           
                                          </td>
                                          <td>
                                            <select class="form-control classNameA" id="classNameA" name="classNameA">
                                             <option value="none">Select-Class-Name</option>
                                                  @foreach($classes as $class)
                                                    @if($class->class_name == $teacher['className'])
                                                      <option value="{{$class->id}}" selected>{{ucfirst($class->class_name)}}</option>
                                                    @else
                                                      <option value="{{$class->id}}">{{ucfirst($class->class_name)}}</option>
                                                    @endif   
                                                  @endforeach
                                             </select>    
                                          </td>
                                          <td>
                                             <a href=""  class="btn btn-sm btn-info updateTeacher" id="updat {{$teacher["id"]}}" data-title="Update" data-toggle="modal" data-target="#confirm-update" title="update"><span class="fa fa-save"></span></a>                                         
                                             <a href="" class="btn btn-sm btn-danger deleteTeacher"  id="del {{$teacher["id"]}}" data-title="Delete" data-toggle="modal" data-target="#confirm-delete" title="delete"><span class="fa fa-trash" ></span></a>
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
                             @endif
                          </div>                          
                    @endif      
                  </div>                
                </div>
              </div>
            </div>
          </div>
        <!-- modal for delete teacher -->
         <div class="modal col-md-10 offset-md-2  col-sm-10 offset-sm-2 " id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">                  
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
               <h4 class="modal-title text-info" id="Heading">Delete this Teacher</h4>
               </div>
               <div class="modal-body">
                 <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span> Are you sure you want to delete this information teacher?</div>
               </div>
               <div class="modal-footer">
                 <button  class="btn btn-success del_teacher"><span class="fa fa-check-circle"></span> Yes</button>
                 <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
               </div>
             </div>
           </div>
         </div>
          <!-- end of modal for delete teacher -->
        <!-- modal for update teacher -->
         <div class="modal col-md-10 offset-md-2  col-sm-10 offset-sm-2 " id="confirm-update" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">                  
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
               <h4 class="modal-title text-info" id="Heading">Update this Teacher</h4>
               </div>
               <div class="modal-body">
                 <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span> Are you sure you want to update information this teacher?</div>
               </div>
               <div class="modal-footer">
                 <button  class="btn btn-success updat_teacher"><span class="fa fa-check-circle"></span> Yes</button>
                 <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
               </div>
             </div>
           </div>
         </div>
        <!-- /.container-fluid -->
  @endsection
