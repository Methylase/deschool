@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Make Payment</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Make Payment</h6>
                        <div class="float-right text-danger " id="paymentToggle"><i class="fas fa-plus" id="close"></i></div>
                    </div>
                    <div class="card-body" id="payment-body">
                        <form class="form" action=""  method="">
                            {{csrf_field()}}                    
                            <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group class-name-group">
                                <label for="class" class="control-label text-info"> Class Name</label>
                                <select class="form-control" id="class-name" name="class-name">
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
                                <div class="form-group student-name-group">
                                <label for="student-name" class="control-label text-info"> Student Name</label>
                                <select class="form-control" id="student-name" name="student-name">
                                    <option value="">Select-Student-Name</option>                                
                                </select>
                                </div>
                            </div>                            
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group term-name-group">
                                        <label for="term" class="control-label text-info"> Term Of The Year</label>
                                        <select class="form-control" id="term-name" name="term-name">
                                            <option value="">Select-Term</option>
                                            <option value="first term">First Term</option>
                                            <option value="second-term">Second Term</option>
                                            <option value="third-term">Third Term</option>                               
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group year-group">
                                        <label for="year" class="control-label text-info">Session Year</label>
                                        <input class="form-control" value="{{date('Y').'-'.(date('Y')+1)}}" id="year"  name="year" readonly>
                                    </div>
                                </div>                            
                            </div> 
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group transaction-group">
                                        <label for="transaction" class="control-label text-info">Transaction Type</label>
                                        <select class="form-control" id="transaction-name" name="transaction-name">
                                            <option value="">Select-Transaction-type</option>
                                            <option value="schoolfees">School Fees</option>
                                            <option value="schoolbus">School Bus</option>
                                            <option value="schoolparty">Party & Excursion</option>                               
                                        </select>
                                    </div>
                                </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group amount-group">                       
                                    <label for="amount" class="control-label text-info">Amount</label>
                                    <input class="form-control"  id="amount"  name="amount" placeholder="Enter Amount">
                                </div>
                            </div>
                            </div>  
                            <div class="row">
                            <div class="offset-md-6 col-md-6 offset-sm-6 col-sm-6"><br>
                                <div class="form-group">                       
                                <button type="button"  id="savePayment"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Make Payment </button>
                                </div>
                            </div>
                            </div>  
                        </form>
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
      <!-- End of Main Content -->
  @endsection