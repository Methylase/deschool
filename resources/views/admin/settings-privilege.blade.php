@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Settings</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold"> Settings</h6>
                  <div class="float-right text-danger " id="settingsPrivilegeToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="settings-privilege-body">
                   <div class='offset-md-1 col-md-10 offset-sm-1 col-sm-10'>
                      
                     <form class="form">
                     {{csrf_field()}}
                     @if(isset($schoolInformation->school_enable) && $schoolInformation->school_enable !='' || $schoolInformation->school_enable !=null)
                        @php $checked ="checked";$dataTarget ="#enable";  
                        @endphp
                     @else
                        @php $checked =""; $dataTarget ="#disable";
                        @endphp                           
                     @endif                     
                     <div class="row">
                        <div class="col-sm-12 col-md-4">
                           <div class="form-group privilege-group">
                              <label for="privilege-type" class="label-control text-info">Privilege Type:</label>
                              <select class="form-control" id="privilegeType" name="privilegeType">
                                  <option value="none">Select-Privilege-Type</option>
                                  <option value="access">Access</option>  
                                  <option value="onhold">On Hold</option>
                                  <option value="remove">Remove</option>   
                              </select>
                           </div>                              
                        </div>
                        <div class="col-sm-12 col-md-4">
                           <div class="form-group staff-group">
                              <label for="staff-name" class="label-control text-info">Staff Name</label>
                              <select class="form-control" id="staffName" name="staffName">
                                  <option value="none">Select-Staff-Name</option>
                                    @foreach($staffInformation as $staff)
                                         @if($staff->staff_email != null)
                                          <option value="{{$staff->staff_email}}">{{ucfirst($staff->staff_firstname).' '.ucfirst($staff->staff_lastname)}}</option>
                                          @endif
                                    @endforeach
                              </select>
                           </div>                                  
                        </div>
                        <div class="col-sm-12 col-md-4">
                           <div class="form-group">                      
                              <label for="gender" class="checkbox-inline text-info">Enabled Settings  <input type="checkbox"  class="setRead" data-title="Setting Information" data-toggle="modal" data-target="{{$dataTarget}}"  name="read" {{$checked}} style="margin-left:10px"></label>
                              <button type="button" id="privilege" class="btn btn-success form-control" data-title="Register" data-toggle="modal" data-target="#privilegeRegister"><i class="fa fa-save"></i> Set Previlege</button>
                           </div>
                        </div>                           
                         
                     </div>
                     </form>
                     <hr> 
                     <div class="row" id="academic-session"></div>
                     <p class="lead">Session settings</p>
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group term-group">
                            <label for="status" class="control-label text-info">Session Term</label>
                            <select class="form-control"  id="term" name="term">
                                <option value="">Select-Term</option>
                                <option value="firstterm">First Term</option>
                                <option value="secondterm">Second Term</option>
                                <option value="thirdterm">Third Term</option>
                            </select>
                        </div>
                      </div>  
                      <div class="col-md-6 col-sm-12">
                        <div class="form-group session-group">
                            <label for="status" class="control-label text-info">Session Year</label>
                           <input  type="text" value="{{date('Y').'-'.(date('Y')+1)}}" name="session" id="session" class="form-control" readonly>
                        </div>
                      </div> 

                      <div class="col-sm-12 offset-md-6 col-md-6">
                        <div class="form-group">                      
                          <button type="button" id="createTerm" class="btn btn-success form-control" data-title="Session" data-toggle="modal" data-target="#academic_session"><i class="fa fa-save"></i> Save</button>
                        </div>
                      </div>                                                                
                    </div>                     
                  </div> 
                </div>
              </div>
            </div>
          </div>
        <!-- /.container-fluid -->

   <!-- modal for mark register -->
    <div class="modal col-md-10 offset-md-2  col-sm-10 offset-sm-2 " id="privilegeRegister" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">                  
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title text-info" id="Heading">Set privilege</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span> Are you sure you want to set this privilege?</div>
          </div>
          <div class="modal-footer">
            <button  class="btn btn-success yesPrivilege"><span class="fa fa-check-circle"></span> Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
          </div>
        </div>
      </div>
    </div>
     <!-- end of modal for register  -->
   <!-- modal for enabling information settings -->
    <div class="modal col-md-10 offset-md-2  col-sm-10 offset-sm-2 " id="enable" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">                  
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title text-info" id="Heading"> Enable Information Settings </h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span> Are you sure you want to set all Information settings to enable?</div>
          </div>
          <div class="modal-footer">
            <button  class="btn btn-success enable"><span class="fa fa-check-circle"></span> Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
          </div>
        </div>
      </div>
    </div>
     <!-- end of modal for enabling information settings -->
   <!-- modal for disabling information settings -->
    <div class="modal col-md-10 offset-md-2  col-sm-10 offset-sm-2 " id="disable" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">                  
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title text-info" id="Heading">Disable Information settings</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span> Are you sure you want to set all information settings to Disable?</div>
          </div>
          <div class="modal-footer">
            <button  class="btn btn-success disable"><span class="fa fa-check-circle"></span> Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
          </div>
        </div>
      </div>
    </div>
     <!-- end of modal for disabling information settings -->   
   <!-- modal for disabling information settings -->
   <div class="modal col-md-10 offset-md-2  col-sm-10 offset-sm-2 " id="academic_session" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">                  
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title text-info" id="Heading"> {{date('Y').'-'.(date('Y')+1)}} Academic Calender</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span> Are you sure you want to set term for {{date('Y').'-'.(date('Y')+1)}} academic calender?</div>
          </div>
          <div class="modal-footer">
            <button  class="btn btn-success yesTerm"><span class="fa fa-check-circle"></span> Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
          </div>
        </div>
      </div>
    </div>
     <!-- end of modal for disabling information settings -->      
     
      <!-- End of Main Content -->
  @endsection
