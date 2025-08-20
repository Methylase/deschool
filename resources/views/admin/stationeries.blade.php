@extends('layouts.admin')
  @section('content')
  <!-- Begin Page Content -->
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Stationeries</h1>
    </div>
      <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
  </div>
  <!-- Content Column -->
  <div class="col-lg-12 mb-4">
    <!-- Approach -->
    <div class="card shadow mb-4">                
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold"> Add Stationeries To Store </h6>
        <div class="float-right text-danger" id="stationaryToggle"><i class="fas fa-plus" id="close"></i></div>
      </div>
      <div class="card-body" id="stationary-body">
        <div class="col-lg-12 mb-4">                             
          <form class="form" action="" method="">
            {{csrf_field()}}
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <div class="form-group stationary-group">
                  <label for="stationary-name" class="control-label text-info"> Stationary Name</label>
                  <input type="text" id="stationary" name="stationary" class="form-control" placeholder="Enter Stationary Name">
                </div>
              </div>
              <div class="col-md-6 col-sm-6">
                <div class="form-group status-group">
                    <label for="status" class="control-label text-info"> Status</label>
                    <select  id="status" name="status" class="form-control">
                        <option value="">Select-Status</option>
                        <option value="for-sale">For-Sale</option>
                        <option value="library">Library</option>
                    </select>
                </div>
              </div>                        
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group quantity-group">
                        <label for="quantity" class="control-label text-info"> Quantity</label>
                        <input type="text" id="quantity" name="quantity" class="form-control" Placeholder="Enter Quantity">
                    </div>
                </div>                        
                <div class="col-md-6 col-sm-6">
                    <div class="form-group amount-group">
                        <label for="amount" class="control-label text-info"> Amount</label>
                        <input type="text" id="amount" name="amount" class="form-control" Placeholder="Enter Amount">
                    </div>
                </div>                         
            </div>
            <div class="row">                        
                <div class="col-md-6 offset-sm-6 col-sm-6">
                    <div class="form-group">
                        <button type="button"  id="addStationary"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Add Stationary</button>
                    </div>
                </div>
            </div>  
          </form>
          <div class="table-responsive">   
            @if(isset($stationeries) && $stationeries !=null)
              <hr>
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
  <!-- End of Main Content -->
  @endsection
 