@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Class Setup </h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">                
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold"> Class Setup </h6>
                  <div class="float-right text-danger" id="settingsToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="settings-body">
                  <div class="col-lg-12 mb-4">                
                     <h6 class="m-0 font-weight-bold"> Create Subject For All Classes </h6>                
                     <form class="form" action="" method="">
                        {{csrf_field()}}
                        <div class="row">
                         <div class="col-md-6 col-sm-6">
                           <div class="form-group class-subject-group">
                             <label for="subject-name" class="control-label text-info"> Subject Name</label>
                              <input type="text" id="subject" name="subject" class="form-control" placeholder="Enter Subject Name">
                           </div>
                         </div>
                         <div class="col-md-6 col-sm-6">
                           <div class="form-group date-group">
                              <label for="created-date" class="control-label text-info"> Created Date</label>
                              <input type="date" id="date" name="date" class="form-control" Placeholder="Select Created Date">
                           </div>
                         </div>                        
                       </div>
                       <div class="row">
                         <div class="col-md-6 offset-sm-6 col-sm-6">
                           <div class="form-group">
                              <button type="button"  id="createSubject"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Create Subject </button>
                           </div>
                         </div>
                       </div>  
                     </form>
                  </div>
                  <hr>
                  <div class="col-lg-12 mb-4">
                     <h6 class="m-0 font-weight-bold"> Create Classes For Students </h6>
                     <form class="form" action="" method="">
                        {{csrf_field()}}
                        <div class="row">
                         <div class="col-md-6 col-sm-6 ">
                           <div class="form-group class-group">
                             <label for="class-name" class="control-label text-info"> Class Name</label>
                              <input type="text" id="class" name="class" class="form-control" placeholder="Enter Class Name">
                           </div>
                         </div>
                         <div class="col-md-6 col-sm-6">
                           <div class="form-group class-date-group">
                              <label for="created-date" class="control-label text-info"> Created Date</label>
                              <input type="date" id="classDate" name="date" class="form-control">
                           </div>
                         </div>                        
                       </div>
                       <div class="row">
                         <div class="col-md-6 offset-sm-6 col-sm-6">
                           <div class="form-group">
                              <button type="button"  id="createClass"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Create Class </button>
                           </div>
                         </div>
                       </div>  
                     </form>                        
                  </div>
                  <hr>
                  <div class="col-lg-12 mb-4">
                     <h6 class="m-0  font-weight-bold"> Create Period For Subject </h6>
                     <form class="form" action="" method="">
                        {{csrf_field()}}
                        <div class="row">
                         <div class="col-md-6 col-sm-6 ">
                           <div class="form-group period-group ">
                             <label for="period-name" class="control-label text-info"> Period Name</label>
                              <input type="text" id="period" name="period" class="form-control" placeholder="Enter Period Name">
                           </div>
                         </div>
                         <div class="col-md-6 col-sm-6">
                           <div class="form-group period-date-group">
                              <label for="created-date" class="control-label text-info"> Created Date</label>
                              <input type="date" id="periodDate" name="date" class="form-control">
                           </div>
                         </div>                        
                       </div>
                       <div class="row">
                         <div class="col-md-6 offset-sm-6 col-sm-6">
                           <div class="form-group">
                              <button type="button"  id="createPeriod"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Create Period </button>
                           </div>
                         </div>
                       </div>  
                     </form>                        
                  </div>                  
                </div>
              </div>
            </div>
          </div>
      <!-- End of Main Content -->
  @endsection
 