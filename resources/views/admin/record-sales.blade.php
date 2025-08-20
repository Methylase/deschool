@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Record Sales</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold"> Record sales </h6>
                  <div class="float-right text-danger" id="recordSalesToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="record-sales-body">
                    <form class="form" action=""  method="">
                     {{csrf_field()}}
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group student-group">
                           <label for="student-name" class="control-label text-info"> Student Name</label>
                            <select class="form-control" id="student" name="student">
                              <option value="">Select-Student-Name</option>
                              @foreach($students as $student)
                                  <option value="{{$student->id}}">{{ucfirst($student->student_firstname).' '.ucfirst($student->student_lastname)}}</option>
                              @endforeach                                    
                           </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group stationary-group">
                           <label for="stationary-name" class="control-label text-info">Stationary Name</label>
                           <select class="form-control" id="stationary" name="stationary">
                              <option value="">Select-Stationary-Name</option>
                              @foreach($stationeries as $stationary)
                                  <option value="{{$stationary->id}}">{{ucfirst($stationary->stationary_name)}}</option>
                              @endforeach                                    
                           </select>
                        </div>
                      </div>                            
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group quantity-group">
                            <label for="register-date" class="control-label text-info"> Quantity</label>
                            <input type="text" id="quantity" name="quantity" class="form-control" placeholder="Enter Stationary quantity">
                            </div>
                        </div>                        
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group transaction-group">
                                <label for="transaction-type" class="control-label text-info"> Transaction Type</label>
                                <select  id="transaction-type" name="transaction-type" class="form-control">
                                    <option value="">Select-Transaction Type</option>
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="teller">Bank Teller</option>
                                    <option value="toschoolfees">Add To School Fees</option>
                                </select>
                            </div>
                        </div>
                    </div>  
                    <div class="row">                        
                        <div class="col-md-6 offset-sm-6 col-sm-6">
                            <div class="form-group">
                                <button type="button"  id="record-sales"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Save </button>
                            </div>
                        </div>
                    </div> 
                  </form>
                  <div class="table-responsive">   
                    @if(isset($sales_record) && $sales_record !='')
                      <hr>
                      <h6 class="m-4 font-weight-bold">Table showing the list of stationary sales</h6>        
                      <table class="table table-bordered  border-bottom-info" id="dataTableRecordSales" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>S/N</th>
                            <th>Student Name</th>
                            <th> Stationary Name</th>
                            <th>Quantity</th>
                            <th>Amount</th>  
                            <th>Transaction Type</th>  
                            <th>Transaction Time</th> 
                            <th>Transaction Date</th> 
                          </tr>
                        </thead>
                        @php$i=1
                        @endphp
                        @foreach($sales_record as $sales)
                        <tbody>
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{ucwords($sales['student'])}}</td>
                                <td>{{$sales['stationary']}}</td>
                                <td>{{$sales['quantity']}}</td>
                                <td>{{'&#8358;'.number_format($sales['amount'],2, ',', '.')}}</td>
                                <td>{{$sales['transaction_type']}}</td>
                                <td>{{($sales['time'] == NULL ? 'Not yet' : date('H:i:s a',strtotime($sales['time'])))}}</td>
                                <td>{{date('d/m/Y',strtotime($sales['date']))}}</td>
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

      <!-- End of Main Content -->
  @endsection