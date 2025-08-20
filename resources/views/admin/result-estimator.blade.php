@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Result Estimator</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Result Estimator</h6>
                  <div class="float-right text-danger " id="resultEstimatorToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="result-estimator-body">
                    <form class="form" action=""  method="">
                     {{csrf_field()}}                    
                    <div class="row">
                      <div class="col-md-6 col-sm-6">
                        <div class="form-group estimator-group">
                           <label for="estimator-type" class="control-label text-info"> Estimator Type </label>
                           <select class="form-control" id="estimator-type" name="estimator-type">
                                <option value="">Select-Estimator-Type</option>
                                <option value="first test">First Test</option>
                                <option value="second test">Second Test</option>
                                <option value="note">Note Evaluation</option>  
                                <option value="assignment">Assignment</option>  
                                <option value="test total">Test Total</option>  
                                <option value="examination">Examination</option>                            
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6">
                            <div class="form-group value-group">
                                <label for="value" class="control-label text-info"> Estimator Value</label>
                                <input type="text" id="estimator-value" name="estimator-value" class="form-control" Placeholder="Enter Estimator Value">
                            </div>
                        </div>                           
                    </div>                    
                    <div class="row">
                      <div class="offset-md-6 col-md-6 offset-sm-6 col-sm-6">
                        <div class="form-group">                       
                           <button type="button"  id="add-estimator"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Save </button>
                        </div>
                      </div>
                    </div>  
                  </form>
                  <hr>
                  <div class="table-responsive">  
                    <div class="teacher-update"></div>    
                    @if(isset($estimators) && $estimators !='')
                      <h6 class="m-4  font-weight-bold">Table For The Result Estimator</h6>        
                    <table class="table table-bordered border-bottom-info display" id="dataTableResultEstimator" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Estimator Type</th>
                          <th>Estimator Value</th>                 
                        </tr>
                      </thead>
                        @php$i=1
                        @endphp
                        <tbody>
                          @foreach($estimators as $estimator)
                            <tr>
                              <td>{{$i}}</td>
                              <td>
                              {{ucwords($estimator['estimator_type'])}}
                              </td>
                              <td>   
                              {{$estimator['estimator_value']}}                           
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
      <!-- End of Main Content -->
  @endsection