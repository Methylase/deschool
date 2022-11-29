
@extends('layouts.app')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Students Register</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  @if(Auth::user()->isMember())
                 <h6 class="m-0 font-weight-bold text-danger"> Mark Students Register </h6>
                  @elseif(Auth::user()->isAdmin())
                  <h6 class="m-0 font-weight-bold text-danger"> View Table For Students Register </h6>
                  @endif                
 
                  <div class="float-right text-danger " id="updateToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="update-body">
                  @if(Auth::user()->isAdmin())
                     
                  @elseif(Auth::user()->isMember())
                  <form class="form" action="" method="">
                     {{csrf_field()}}      
                    <div class="row">
                      <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                           <label for="class-name" class="control-label text-info" > Class Teacher</label>
                              <select class="form-control" id="teacherName" name="teacherName">
                                 <option value="none">Select-Class-Teacher's-Name</option>
                                 @foreach($staffs as $staff)
                                    @if( $staff->staff_gender==='male')
                                      @php $fullname = 'Mr '.ucfirst($staff->staff_firstname).' '.ucfirst($staff->staff_lastname)
                                      @endphp
                                    @elseif( $staff->staff_gender ==='female')
                                      @php $fullname = 'Mrs '.ucfirst($staff->staff_firstname).' '.ucfirst($staff->staff_lastname)
                                      @endphp
                                    @else
                                      @php $fullname = ucfirst($staff->staff_firstname).' '.ucfirst($staff->staff_lastname)
                                      @endphp
                                    @endif
                                      <option value="{{$staff->id}}">{{$fullname}}</option>
                                 @endforeach
                              </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                           <label for="class-name" class="control-label text-info" >Class</label>
                                <select class="form-control" id="className" name="className">
                                   <option value="none">Select-Class-Name</option>
                                    @foreach($classes as $class)
                                        <option value="{{$class->id}}">{{ucfirst($class->class_name)}}</option>
                                    @endforeach
                                </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                           <label for="class-name" class="control-label text-info" >Week Of The Term</label>
                                <select class="form-control" id="week" name="week">
                                   <option value="none">Select-Week</option>
                                    @for($i=1; $i < 15; $i++)
                                        <option value="{{$i}}">{{ucfirst('week-'.$i)}}</option>
                                    @endfor
                                </select>
                        </div>
                      </div>                        
                    </div>                        
                    <div class="row">
                      <div class="offset-md-8 col-md-4 offset-sm-8 col-sm-4">
                        <div class="form-group">
                           <button type="button"  id="markRegister"  class="btn btn-success form-control" data-title="Register" data-toggle="modal" data-target="#register"><i class="fa fa-save"></i> Save </button>
                        </div>
                      </div>
                    </div>  
                  </form>
                    <div class="table-responsive">
                     @if(isset($studentInformation) && $studentInformation != null )
                      <table class="table table-bordered  border-bottom-info" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                           <tr>
                           <th>S/N</th>
                            <th>Student Name</th>
                             <th>Monday</th>
                             <th>Tuesday</th>
                             <th>Wednesday</th>
                             <th>Thurday</th>
                             <th>Friday</th>
                           </tr>
                        </thead>
                          @php$i=1
                          @endphp
                           @foreach($studentInformation as $student)
                              <tbody>
                                 <tr>
                                    <td>{{$i}}</td>
                                    <td>{{ucfirst($student->student_firstname).' '.ucfirst($student->student_lastname)}}</td>
                                     <td>
                                       <label for="gender" class="checkbox-inline text-info">M</label>
                                       <input type="checkbox" class="register" id="mon_mon" name="gender" >
                                       <label for="gender" class="checkbox-inline text-info">A</label>                                                                     
                                       <input type="checkbox" class="register" id="mon_aft" name="gender">
                                     </td>
                                     <td>
                                       <label for="gender" class="checkbox-inline text-info">M</label>
                                       <input type="checkbox" id="tue_mon" name="gender" value="male">
                                       <label for="gender" class="checkbox-inline text-info">A</label>                                                                     
                                       <input type="checkbox" id="tue_aft" name="gender">
                                     </td>
                                     <td>
                                       <label for="gender" class="checkbox-inline text-info">M</label>
                                       <input type="checkbox" id="wed_mon" name="gender" value="male">
                                       <label for="gender" class="checkbox-inline text-info">A</label>                                                                     
                                       <input type="checkbox" id="wed_aft" name="gender">
                                     </td>
                                     <td>
                                       <label for="gender" class="checkbox-inline text-info">M</label>
                                       <input type="checkbox" id="thur_mon" name="gender" value="male">
                                       <label for="gender" class="checkbox-inline text-info">A</label>                                                                     
                                       <input type="checkbox" id="thur_aft" name="gender">
                                     </td>
                                     <td>
                                       <label for="gender" class="checkbox-inline text-info">M</label>
                                       <input type="checkbox" id="fri_mon" name="gender" value="male">
                                       <label for="gender" class="checkbox-inline text-info">A</label>                                                                     
                                       <input type="checkbox" id="fri_aft" name="gender">
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
                    </div>   
                  @endif                               
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->
      <!-- modal for mark register -->
      <div class="modal col-md-10 offset-md-2  col-sm-10 offset-sm-2 " id="register" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">                  
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
              <h4 class="modal-title text-info" id="Heading">Mark register</h4>
              </div>
              <div class="modal-body">
                <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span> Are you sure you want to mark today's register?</div>
              </div>
              <div class="modal-footer">
                <button  class="btn btn-success yesRegister"><span class="fa fa-check-circle"></span> Yes</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
              </div>
            </div>
          </div>
        </div>
        <!-- end of modal for mark register -->
      </div>
      <!-- End of Main Content -->
  @endsection      