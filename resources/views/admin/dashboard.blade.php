@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800 earning-monthly">&#8358; 0.000</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annually)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800 earning-annually">&#8358; 0.000</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-money-check fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Stationeries Sales</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800 stationeries-sales">&#8358; 0.000</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Recovered School Fees</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800 recovered-fees">&#8358; 0.000</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-building fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->

          <!-- Content Row -->
          <div class="row">

            <!-- Total Staff Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Staffs</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$staff_count}}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Teachers Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Teachers</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$teacher_count}}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total parents Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Parents</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$parent_count}}</div>
                    </div>
                    <div class="col-auto">
                      <i class="fa fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Students Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Students</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$student_count}}</div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fa fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->          

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold">Sales Overview</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold">Revenue Sources</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">Dropdown Header:</div>
                      <a class="dropdown-item" href="#">Action</a>
                      <a class="dropdown-item" href="#">Another action</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div class="mt-4 text-center small">
                    <span class="mr-2">
                      <i class="fas fa-circle text-primary"></i> School Fees
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-success"></i> Stationary
                    </span>
                    <span class="mr-2">
                      <i class="fas fa-circle text-info"></i> Party & Excursion
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->          

          <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12 col-sm-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold">Stationaries</h6>
                    <a href="{{route('stationeries')}}" class="btn btn-sm btn-info float-right">Add Stationaries</a>
                </div>
                <div class="card-body" id="stationary-body">
                  <div class="col-lg-12 mb-4">                             

                    <div class="table-responsive">   
                      @if(isset($stationeries) && $stationeries !=null)
                        <h6 class="m-4  font-weight-bold">Table For All The Stationeries In The Store</h6>        
                        <table class="table table-bordered  border-bottom-info display" id="dataTableStationary" width="100%" cellspacing="0">                 
                          <thead>
                            <tr>
                              <th>S/N</th>
                              <th>Stationeries Name</th>
                              <th>Status</th>
                              <th>Quantity</th>
                              <th>Amount</th>                  
                            </tr>
                          </thead>
                          @php$i=1
                          @endphp
                          <tbody>
                            @foreach($stationeries as $stationary)
                              <tr>
                                  <td>{{$i}}</td>
                                <td>
                                {{ucwords($stationary->stationary_name)}}
                                </td>
                                <td>   
                                {{ucwords($stationary->stationary_status)}}                           
                                </td>
                                <td>
                                {{$stationary->stationary_quantity}}
                                </td>
                                <td>   
                                {{$stationary->stationary_amount}}                           
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
          </div> 
          
          <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12 col-sm-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold">Make Payment</h6>
                    <a href="{{route('payments')}}" class="btn btn-sm btn-info float-right">Make Payment</a>
                </div>
                <div class="card-body">
                  <div class="col-lg-12 mb-4">                             
                    <div class="table-responsive">   
                        @if(isset($payments) && $payments !='')
                        <hr>
                        <h6 class="m-4 font-weight-bold">Table showing the list of payments</h6>        
                        <table class="table table-bordered  border-bottom-info" id="dataTableRecordSales" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Class Name</th>
                                <th>Student Name</th>
                                <th>Term</th>
                                <th> Year</th>                        
                                <th>Amount</th>  
                                <th>Transaction Type</th>  
                                <th>Transaction Time</th> 
                                <th>Transaction Date</th> 
                            </tr>
                            </thead>
                            @php$i=1
                            @endphp
                            @foreach($payments as $payment)
                            <tbody>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{ucwords($payment['class_name'])}}</td>
                                    <td>{{ucwords($payment['student_name'])}}</td>
                                    <td>{{ucwords($payment['term'])}}</td>
                                    <td>{{$payment['year']}}</td>
                                    <td>{{'&#8358;'.number_format($payment['amount'],2, ',', '.')}}</td>
                                    <td>
                                        @if($payment['transaction_type'] == 'schoolfees')
                                            School Fees
                                        @elseif($payment['transaction_type'] == 'schoolbus')
                                            School Bus
                                        @elseif($payment['transaction_type'] == 'schoolparty')
                                            Party & Excursion
                                        @endif
                                    </td>
                                    <td>{{($payment['time'] == NULL ? 'Not yet' : date('H:i:s a',strtotime($payment['time'])))}}</td>
                                    <td>{{date('d/m/Y',strtotime($payment['date']))}}</td>
                                </tr>
                            </tbody>
                            @php$i++
                            @endphp
                            @endforeach
                        </table>

                        @endif
                    </div>  
                  </div>                
                </div>
              </div>                     
            </div>
          </div>  
          
          <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-12 col-lg-12 col-sm-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold">Assign Book</h6>
                    <a href="{{route('assign-book')}}" class="btn btn-sm btn-info float-right">Assign Book</a>
                </div>
                <div class="card-body">
                  <div class="col-lg-12 mb-4">                             
                    <div class="table-responsive book">      
                      @if(isset($assignedBooks) && $assignedBooks !='')
                        <h6 class="m-4  font-weight-bold">Table For Books Assigned To Student In Library</h6>  
                        <table class="table table-bordered border-bottom-info display" id="dataTableAssignBook" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                            <th>S/N</th>
                              <th>Student Name</th>
                              <th>Class Name</th>
                              <th>Book Name</th>
                              <th>Book Condition</th>
                              <th>Status</th>
                              <th>Assigned Time</th>
                              <th>Returned Time </th>
                              <th>Date</th>
                            </tr>
                          </thead>
                            @php$i=1
                            @endphp
                            <tbody>
                              @foreach($assignedBooks as $assignedBooks)
                                <tr>
                                  <td>{{$i}}</td>
                                  <td>
                                  {{ucfirst($assignedBooks['fullname'])}}
                                  </td>
                                  <td>{{ucfirst($assignedBooks['class_name'])}}</td>  
                                  <td id="{{'name-'.$assignedBooks['id']}}">   
                                  {{ucfirst($assignedBooks['book'])}}                           
                                  </td>
                                  <td class="book-condition">   
                                  @if($assignedBooks['status'] == "returned")
                                    {{ucfirst($assignedBooks['condition'])}}
                                  @else
                                  <input type="text" class="form-control" id="{{'assign-'.$assignedBooks['id']}}" value="{{ucfirst($assignedBooks['condition'])}}" style="display:none">
                                    <span id="{{'condition-'.$assignedBooks['id']}}" style="display:block">{{ucfirst($assignedBooks['condition'])}} </span>                   
                                  @endif                           
                                  </td>                      
                                  <td>
                                  <select class="form-control book-status" id="{{$assignedBooks['id']}}">
                                    @if($assignedBooks['status'] == "assigned")
                                        <option value="">Select Book Status</option>
                                        <option value="{{$assignedBooks['status']}}" selected>{{ucfirst($assignedBooks['status'])}}</option>
                                        <option value="returned">Returned</option>
                                    @elseif($assignedBooks['status'] == "returned")    
                                        <option value="">Select Book Status</option>
                                        <option value="assigned">Assigned</option>
                                        <option value="{{$assignedBooks['status']}}" selected>{{ucfirst($assignedBooks['status'])}}</option>
                                    @else
                                        <option value="">Select Book Status</option>
                                        <option value="assigned">Assigned</option>
                                        <option value="returned">Returned</option>                                
                                    @endif    
                                  </select>      
                                </td>
                                <td>{{date('H:i:s a',strtotime($assignedBooks['time_assigned']))}}</td>
                                <td>{{($assignedBooks['time_returned'] == NULL ? 'Not yet' : date('H:i:s a',strtotime($assignedBooks['time_returned'])))}}</td>
                                <td>{{date('d/m/Y',strtotime($assignedBooks['date']))}}</td>
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
          </div>           
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
  @endsection
 