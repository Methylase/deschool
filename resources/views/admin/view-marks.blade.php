
@extends('layouts.admin')
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
                          <th>Actions</th>
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
                              <td>
                                <a href="/edit-mark/{{$result_aggregator['id']}}" class="btn btn-sm btn-info" title="Edit"><span class="fa fa-edit"></span></a>                                         
                                <a href="" class="btn btn-sm btn-danger deleteStudent"  id='del {{$result_aggregator["id"]}}' data-title="Delete" data-toggle="modal" data-target="#confirm-delete"><span class="fa fa-trash" title="Delete"></span></a>
                                  
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
        <!-- /.container-fluid -->
  @endsection
