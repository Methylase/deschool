
@extends('layouts.app')
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
                  <h6 class="m-0 font-weight-bold text-danger"> Assign Subject </h6>
                  <div class="float-right text-danger " id="subjectToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="subject-body">
                  <div class="col-lg-12 mb-4">                
                     <h6 class="m-0  text-danger"> Assign Subjects to Teacher</h6>                
                     <form class="form" action="" method="">
                        {{csrf_field()}}
                        <div class="row">
                         <div class="col-md-6 col-sm-6 ">
                           <div class="form-group">
                             <label for="teacher-name" class="control-label text-info"> Teacher Name</label>
                              <select class="form-control" id="teacher-name" name="teacher-name">
                                <option value="none">Select-Teacher-Name</option>
                              </select>
                           </div>
                         </div>
                         <div class="col-md-6 col-sm-6 ">
                           <div class="form-group">
                             <label for="subject-name" class="control-label text-info"> Subject Name</label>
                              <select class="form-control" id="subject-name" name="subject-name">
                                 <option value="none">Select-Subject-Name</option>
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
                  </div>
                  <hr>
                  <div class="col-lg-12 mb-4">
                     <h6 class="m-0  text-danger"> Create Classes For Students </h6>
                     <form class="form" action="" method="">
                        {{csrf_field()}}
                        <div class="row">
                         <div class="col-md-6 col-sm-6 ">
                           <div class="form-group">
                             <label for="class-name" class="control-label text-info"> Class Name</label>
                              <input type="text" id="class" name="class" class="form-control" placeholder="Enter Class Name">
                           </div>
                         </div>
                         <div class="col-md-6 col-sm-6">
                           <div class="form-group">
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
                </div>
              </div>
            </div>
          </div>
        <!-- /.container-fluid -->

@endsection