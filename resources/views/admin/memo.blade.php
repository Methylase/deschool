@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">
        
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Send Memo</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
            
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold"> Send memo </h6>
                  <div class="float-right text-danger " id="memoToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="memo-body">
                    <div class="memo-message"></div>

                  <form class="form"><br><br>
                     {{csrf_field()}}                        
                     <div class="form-group row">
                      <label for="staticSubject" class="col-sm-2 col-form-label text-info">Sender:</label>
                      <div class="col-sm-8">
                          <input type="text" id="sender" name="sender" class="form-control" placeholder="Enter the sender's email" >
                          <div class="sender-group text-danger"></div>
                      </div>
                   </div>

                   <div class="form-group row">
                      <label for="staticSubject" class="col-sm-2 col-form-label text-info">Subject:</label>
                      <div class="col-sm-8">
                          <input type="text" id="subject" name="subject" class="form-control" placeholder="Enter Subject Of Your Message" >
                          <div class="subject-group text-danger"></div>
                      </div>
                   </div>

                   <div class="form-group row">
                     <label for="staticEmail" class="col-sm-2 col-form-label text-info">Select Receiver(s):</label>
                      <div class="col-sm-8">
                            <select class="form-control" id="staffEmail" name="staffEmail" multiple="multiple">
                              @foreach($staffInformation as $staff)
                                  <option value="{{$staff->staff_email}}">{{ucfirst($staff->staff_firstname).' '.ucfirst($staff->staff_lastname)}}</option>
                              @endforeach                                    
                            </select>
                         <div class="email-group text-danger"></div>
                        </div>                                 
                    </div>
                     <div class="row">
                       <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                        <textarea  id="message" name="message" style="height:200px" class="form-control" placeholder="Enter Description of your message" ></textarea>
                        <div class="message-group text-danger"></div>                          
                      </div>
            
                      </div>                                               
                     </div>
                    <div class="row">
                      <div class="col-md-6 offset-sm-6 col-sm-6">
                        <div class="form-group">
                           <button type="button"  id="send-memo"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Send </button>
                        </div>
                      </div>
                    </div>  
                  </form>
                </div>
              </div>
            </div>
          </div>
      <!-- End of Main Content -->
  @endsection