@extends('layouts.admin')
  @section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"> Assign Book From Library</h1>
      </div>
        <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The register is a platform that help in providing solution to schools.....</marquee>
    </div>
        <!-- Content Column -->
      <div class="col-lg-12 mb-4">
        <!-- Approach -->
        <div class="card shadow mb-4">
          <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold">Assign Book From Library</h6>
            <div class="float-right text-danger " id="assignBookToggle"><i class="fas fa-plus" id="close"></i></div>
          </div>
          <div class="card-body" id="assign-book-body">
            <form class="form" action=""  method="">
                {{csrf_field()}}
              <div class="row">
                <div class="col-md-6 col-sm-6">
                  <div class="form-group student-name-group">
                      <label for="student-name" class="control-label text-info"> Student Name</label>
                      <select class="form-control" id="student-name" name="student-name">
                        <option value="">Select-Student-Name</option>
                        @if(isset($students) && $students !="")
                        @foreach($students as $student) 
                          <option value="{{$student->id}}">{{ucfirst($student->student_firstname." ".$student->student_lastname)}}</option>
                        @endforeach
                      @endif                                  
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <div class="form-group book-name-group">
                    <label for="book-name" class="control-label text-info"> Book Name</label>
                    <select class="form-control" id="book-name" name="book-name">
                        <option value="">Select-Library-Book</option>
                        @if(isset($books) && $books !="")
                        @foreach($books as $book) 
                          <option value="{{$book->id}}">{{ucfirst($book->stationary_name)}}</option>
                        @endforeach
                      @endif                                  
                    </select>
                  </div>
                </div>                            
              </div>
              <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group condition-group">
                        <label for="book-condition" class="control-label text-info"> Book Condition</label>
                        <textarea  id="book-condition" name="book-condition" class="form-control" Placeholder="Write a note to state the present condition of the book before issuing out"></textarea>
                    </div>
                </div>                 
                <div class="col-md-6 col-sm-6">
                  <br><br>
                  <div class="form-group">                       
                      <button type="button"  id="assignBook"  class="btn btn-success form-control" ><i class="fa fa-save"></i> Assign Book </button>
                  </div>
                </div>
              </div>  
            </form>
            <hr>
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
      <!-- End of Main Content -->
  @endsection