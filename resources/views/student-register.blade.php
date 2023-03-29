@extends('layouts.app')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Student - Register</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold"> Register For The Time Student Clock In </h6>
                  <div class="float-right text-danger " id="studentRegisterToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="student-register-body">
                    <form class="form" action=""  method="">
                     {{csrf_field()}}
                    <div class="row">
                      <div class="col-md-4 col-sm-4 ">
                        <div class="form-group student-group">
                           <label for="student-name" class="control-label text-info"> Student Name</label>
                            <select class="form-control" id="studentName" name="studentName">
                              <option value="none">Select-Student-Name</option>
                              @foreach($studentInformation as $student)
                                  <option value="{{$student['id']}}">{{$student['student_fullname']}}</option>
                              @endforeach                                    
                           </select>
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-4">
                        <div class="form-group time-group">
                           <label for="student-time" class="control-label text-info"> Resumption Time</label>
                             <input type="text" id="registerTime" name="time" class="form-control" >
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-4">
                        <div class="form-group date-group">
                           <label for="register-date" class="control-label text-info"> Todays Date</label>
                          <input type="date" id="registerDate" name="registerDate" class="form-control" readonly="readyonly" value="{{date('Y-m-d')}}">
                        </div>
                      </div>                            
                    </div>
                    <div class="row">
                      <div class="offset-md-8 col-md-4 offset-sm-8 col-sm-4">
                        <div class="form-group">                       
                           <button type="submit"  id="registerStudent"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Save </button>
                        </div>
                      </div>
                    </div>  
                  </form>
                     <div class="card-body">
                        <div class="table-responsive">   
                         @if(isset($registerStudentInformation) && $registerStudentInformation !='')
                          <hr>
                          <h6 class="m-4 font-weight-bold text-danger">Table showing the list of students that clock in</h6>        
                          <table class="table table-bordered  border-bottom-info" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                              <tr>
                              <th>S/N</th>
                                <th>Student Name</th>
                                <th> Resumption Time</th>
                                <th>Today's Date</th>
                                 <th>
                                   Status
                                 </th>                               
                              </tr>
                            </thead>
                              @php$i=1
                              @endphp
                               @foreach($registerStudentInformation as $registerStudent)
                                  <tbody>
                                     <tr>
                                        <td>{{$i}}</td>
                                        <td>
                                          {{$registerStudent['studentName']}}
                                        </td>
                                        <td>
                                         {{$registerStudent['registerTime']}}                   
                                        </td>
                                        <td>
                                          {{date('D d F  Y',strtotime($registerStudent['registerDate']))}}
                                        </td>

                                          <td>
                                          @if(isset($registerStudent['resumptionStatus']) && $registerStudent['resumptionStatus'] == 'on-time')
                                             <span class="btn btn-success btn-sm col-sm-10 col-xs-12">{{ucfirst($registerStudent['resumptionStatus'])}}</span>
                                          @elseif(isset($registerStudent['resumptionStatus']) && $registerStudent['resumptionStatus'] == 'late')
                                          <span class="btn btn-danger btn-sm col-sm-10 col-xs-12">{{ucfirst($registerStudent['resumptionStatus'])}}</span>
                                          @endif
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
                     </div>
                </div>
              </div>
            </div>
          </div>

      <!-- End of Main Content -->
  @endsection