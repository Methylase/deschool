
@extends('layouts.app')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> All Student Subject Marks </h1> 
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                   <h6 class="m-0 font-weight-bold"> All Student Subject Marks </h6>                       
                  <div class="float-right text-danger " id="viewResultsToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="view-results-body" style="height:800px;">
                 <!-- <form class="form" action=""  method="">
                    {{csrf_field()}}                    
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group class-name-group">
                          <label for="class-name" class="control-label text-info"> Class Name</label>
                          <select class="form-control class_name" id="class_name" name="class-name">
                            <option value="">Select-Class</option>
                            @if(isset($classes) && $classes !="")
                                @foreach($classes as $class) 
                                    <option value="{{$class->id}}">{{ucfirst($class->class_name)}}</option>
                                @endforeach
                            @endif                                
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">                       
                        <div class="form-group duration-name-group">
                          <label for="duration" class="control-label text-info">Duration</label>
                          <select class="form-control class_name" id="duration_name" name="duration-name">
                            <option value="">Select-Duration</option>
                            <option value="present">Present</option>
                            <option value="previous">Previous</option>                              
                          </select>
                        </div>
                      </div>                           
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group year-group">
                          <label for="year" class="control-label text-info">Session Year</label>
                          <select class="form-control class_name" id="year" name="year">
                            <option value="">Select-Academic-Year</option>
                            @if(isset($years) && $years !="")
                                @foreach($years as $year) 
                                    <option value="{{$year->session}}">{{$year->session}}</option>
                                @endforeach
                            @endif                                
                          </select>
                        </div>
                      </div>                          
                      <div class="col-md-6 col-sm-6">                       
                        <div class="form-group term-name-group">
                          <label for="term" class="control-label text-info"> Term Of The Year</label>
                          <select class="form-control class_name" id="term_name" name="term-name">
                            <option value="">Select-Class</option>
                            <option value="first term">First Term</option>
                            <option value="second-term">Second Term</option>
                            <option value="third-term">Third Term</option>                               
                          </select>
                        </div>
                      </div>                                                                                                
                    </div>                      
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group student-name-group">
                          <label for="student-name" class="control-label text-info"> Student Name</label>
                          <select class="form-control" id="student_name" name="student-name">
                              <option value="">Select-Student-Name</option>                                
                          </select>
                        </div>
                      </div>                        
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group result-type-group">
                          <label for="result-type" class="control-label text-info"> Result Type</label>
                          <select class="form-control" id="result_type" name="result-type">
                            <option value="">Select-Result-Type</option>
                            <option value="test">Test</option>
                            <option value="total">Test & Examination</option> 
                          </select>
                        </div>
                      </div>                                                 
                    </div>  
                    <div class="row">
                      <div class="col-md-6 offset-sm-6 col-sm-6">
                        <div class="form-group ">
                          <br>
                        <button type="button"  id="sendResult"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Send</button>
                              
                        </div>
                      </div>                                               
                    </div> 
                                    
                  </form>  -->                
                  <div class="table-responsive mark-result">      
                      @if(isset($result_aggregators) && $result_aggregators !='')
                      <h6 class="m-4  font-weight-bold">Table For All Student Subject Marks</h6>        
                      <table class="table table-bordered border-bottom-info display" id="dataTableResultAggregator" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                          <th>S/N</th>
                          <th>Student Name</th>
                          <th>Class</th>   
                          <th>Subject</th> 
                          <th>Mark Type</th>
                          <th>Mark</th>    
                          <th>Term</th>
                          <th>Academic Year</th>   
                          <th>Time</th>    
                          <th>Date</th>
                          </tr>
                      </thead>
                          @php$i=1
                          @endphp
                          <tbody>
                          @foreach($result_aggregators as $result_aggregator)
                              <tr>
                              <td>{{$i}}</td>
                              <td>
                              {{ucwords($result_aggregator['fullname'])}}
                              </td>
                              <td>   
                              {{$result_aggregator['class']}}                           
                              </td>  
                              <td>
                              {{ucwords($result_aggregator['subject'])}}
                              </td>
                              <td>   
                              {{$result_aggregator['mark_type']}}                           
                              </td>
                              <td class="mark bg-white">
                                  @if($result_aggregator['status'] != "open" || $result_aggregator['status'] != "" )
                                  <span id="{{'condition-'.$result_aggregator['id']}}" style="display:block">{{$result_aggregator['mark']}} </span> 
                                  <input type="text" class="form-control" id="{{'mark-'.$result_aggregator['id']}}" value="{{$result_aggregator['mark']}}" style="display:none">         
                                  @else
                                  <input type="text" class="form-control" id="{{'mark-'.$result_aggregator['id']}}" value="{{$result_aggregator['mark']}}" style="display:none">
                                  <span id="{{'condition-'.$result_aggregator['id']}}" style="display:block;">{{$result_aggregator['mark']}} </span>                   
                                  @endif                                 
                              </td>
                              <td>   
                              {{$result_aggregator['term']}}                           
                              </td> 
                              <td>
                              {{$result_aggregator['year']}}
                              </td>                                                                                          
                              <td>{{date('H:i:s a',strtotime($result_aggregator['time']))}}</td>
                              <td>{{date('d/m/Y',strtotime($result_aggregator['date']))}}</td>                                     
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
        <!-- /.container-fluid -->
  @endsection
