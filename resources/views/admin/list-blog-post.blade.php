
@extends('layouts.admin')
  @section('content')        
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> View Blogs Table</h1>
          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school is a platform that help in providing solutions to school activities.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold"> View Blogs Table </h6>
                  <div class="float-right text-danger" id="viewStaffsToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="view-staffs-body">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                          <h6 class="m-0 font-weight-bold">Blogs Table</h6>
                           <a href="{{route('post')}}" class="btn btn-sm btn-info float-right">Create Blog</a>
                        </div>
                        <div class="card-body">
                          <div class="table-responsive">
                          <table class="table table-bordered border-bottom-info table-striped" id="dataTableStaff"  style="width:100%" cellspacing="0">
                           @if(isset($blogs) && $blogs != null)
                            
                              <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                              </thead>
                                @php$i=1
                                @endphp
                                <tbody>
                                    @foreach ($blogs as $blog )
                                    <tr>

                                        <td>{{$i }}</td>
                                        <td>{{$blog->type}}</td>
                                        <td>{{$blog->title}}</td>
                                        <td>{{$blog->description}}</td>
                                        <td>
                                            @if( $blog->status == NULL)
                                                <span>Active</span> 
                                            @elseif($blog->status !=NULL)
                                                <span>Inactive</span>
                                            @endif
                                        </td>
                                          <td>
                                             <a href="/edit-blog-post/{{$blog->id}}" class="btn btn-sm btn-info" title="Edit"><span class="fa fa-edit"></span></a>                                         
                                             <a href="" class="btn btn-sm btn-danger deleteBlog"  id='del {{$blog->id}}' data-title="Delete" data-toggle="modal" data-target="#confirm-delete"><span class="fa fa-trash" title="Delete"></span></a>
                                             
                                          </td>  
                                       </tr>
                                    
                                 @php$i++
                                 @endphp
                                 @endforeach
                             @endif
                             </tbody>
                             </table>
                             <!-- modal for delete staff -->
                              <div class="modal col-md-10 offset-md-2  col-sm-10 offset-sm-2 " id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">                  
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title text-info" id="Heading">Delete this blog post</h4>
                                    </div>
                                    <div class="modal-body">
                                      <div class="alert alert-danger  format"><span class="fa fa-warning text-danger"></span>Are you sure you want to delete this blog post?</div>
                                    </div>
                                    <div class="modal-footer">
                                      <button  class="btn btn-success del_blog"><span class="fa fa-check-circle"></span> Yes</button>
                                      <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-remove"></span> No</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                               <!-- end of modal for delete staff -->
                          </div>
                        </div>
                    </div>                    
                </div>
              </div>
            </div>
          </div>
      <!-- End of Main Content -->
  @endsection