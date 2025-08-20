@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Staff - Register</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">

        
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold"> Register For The Time Staff Clock In </h6>
                  <div class="float-right text-danger " id="staffRegisterToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="staff-register-body">
                  <form class="form" action=""  method="">
                     {{csrf_field()}}
                    <div class="row">
                      <div class="col-md-4 col-sm-4 ">
                        <div class="form-group staff-group">
                           <label for="staff-name" class="control-label text-info"> Staff Name</label>
                           @if(Auth::user()->isAdmin()) 
                            <select class="form-control" id="staffName" name="staffName">
                              <option value="none">Select-Staff-Name</option>
                              @foreach($staffInformation as $staff)
                                  <option value="{{$staff->id}}">{{ucfirst($staff->staff_firstname).' '.ucfirst($staff->staff_lastname)}}</option>
                              @endforeach                                    
                           </select>
                           @elseif(Auth::user()->isAdmin())
                           <input type="text" id="staffName" name="staffName" class="form-control" readonly >
                            @endif    

                        </div>
                      </div>
                      <div class="col-md-4 col-sm-4">
                        <div class="form-group time-group">
                           <label for="staff-time" class="control-label text-info"> Resumption Time</label>
                             <input type="text" id="registerTime" name="time" class="form-control" >
                        </div>
                      </div>
                      <div class="col-md-4 col-sm-4">
                        <div class="form-group date-group">
                           <label for="register-date" class="control-label text-info"> Todays Date</label>
                          <input type="date" id="registerDate" name="registerDate" class="form-control" {{"readonly='readyonly'"}} value="{{date('Y-m-d')}}">
                        </div>
                      </div>                            
                    </div>
                    <div class="row">
                      <div class="offset-md-8 col-md-4 offset-sm-8 col-sm-4">
                        <div class="form-group">                       
                           <button type="submit"  id="registerStaff"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Save </button>
                        </div>
                      </div>
                    </div>  
                  </form>
                  <hr>
                  <div class="table-responsive">   
                    @if(isset($registerStaffInformation) && $registerStaffInformation !='')
                      <h6 class="m-4 font-weight-bold">Table showing the list of teachers that clock in</h6>        
                      <table class="table table-bordered  border-bottom-info display" id="dataTableStaffRegister" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                          <th>S/N</th>
                            <th>Staff Name</th>
                            <th> Resumption Time</th>
                            <th>Today's Date</th>
                              <th>
                                Status
                              </th>                               
                          </tr>
                        </thead>
                        @php$i=1
                        @endphp
                        <tbody>
                          @foreach($registerStaffInformation as $registerStaff) 
                          <tr>
                            <td>{{$i}}</td>
                            <td>
                              {{$registerStaff['staffName']}}
                            </td>
                            <td>
                              {{$registerStaff['registerTime']}}                   
                            </td>
                            <td>
                              {{date('D d F  Y',strtotime($registerStaff['registerDate']))}}
                            </td>

                              <td>
                              @if(isset($registerStaff['resumptionStatus']) && $registerStaff['resumptionStatus'] == 'on-time')
                                  <span class="btn btn-success btn-sm col-sm-8 col-xs-12">{{ucfirst($registerStaff['resumptionStatus'])}}</span>
                              @elseif(isset($registerStaff['resumptionStatus']) && $registerStaff['resumptionStatus'] == 'late')
                              <span class="btn btn-danger btn-sm col-sm-8 col-xs-12">{{ucfirst($registerStaff['resumptionStatus'])}}</span>
                              @endif
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