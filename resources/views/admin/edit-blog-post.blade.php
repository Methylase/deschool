@extends('layouts.admin')
  @section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit {{$blog->title}}</h1>

          </div>
            <marquee class="mb-0 text-center text-info" style="font-size:small;font-weight:300;font-style:italic">The school a platform that help in providing solutions to school activities.....</marquee>
        </div>
            <!-- Content Column -->
            <div class="col-lg-12 mb-4">
                  @if(session()->has('message'))
                     <div class="offset-md-1 col-md-10 offset-sm-1 col-sm-10 alert
                     alert-danger alert-dismissable text-center" style="margin-top:20px">
                        <a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a>
                        <strong>
                           Danger
                        </strong>
                        {{session('message')}}
                     </div>
                  @endif
                  @if(session()->has('messageSuccess'))
                     <div class="offset-md-1 col-md-10 offset-sm-1 col-sm-10 alert
                     alert-success alert-dismissable text-center" style="margin-top:20px">
                        <a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a>
                        <strong>
                           Success
                        </strong>
                        {{session('messageSuccess')}}
                     </div>
                  @endif
        
              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold">Edit {{$blog->title}}</h6>
                  <div class="float-right text-danger " id="editBlogToggle"><i class="fas fa-plus" id="close"></i></div>
                </div>
                <div class="card-body" id="edit-blog-body">
                    <form class="form-sample" action="/update-blog-post" enctype="multipart/form-data" method="POST">
                        {{method_field('PUT')}}
                        <input type="hidden" name="userId" value="{{$userId}}">
                         <input type="hidden" name="id" value="{{old('id', $blog->id)}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="blog-image" class="control-label">Upload image</label>
                                    <div class="file-drop-area">
                                        <span class="choose-file-button">Choose files</span>
                                        <span class="file-message">or drag and drop blog post image here</span>
                                        <input type="file" name="image" class="form-control file-input">

                                    </div>
                                    @if($errors->has('image'))
                                        <span class="text-danger">
                                            {{ $blogImage= $errors->first('image')}}
                                        </span>
                                    @else
                                        {{$blogImage=''}}
                                    @endif

                                    @if(session()->has('image_error'))
                                        <span class="text-danger">
                                            {{session('image_error')}}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <div class="col-sm-12 mb-2">
                                        <label class="control-label">Type</label>
                                        <select name="type" class="form-control">

                                            @if(  $blog->type ==="none" || $blog->type =='Travel')
                                                <option value="">Select blog Type</option>
                                                <option selected value="Travel">Travel</option>
                                                <option value="Food">Food</option>
                                                <option value="Lifestyle">Lifestyle</option>
                                                <option value="beautification">Beautification</option>
                                                <option value="Business Talk">Business Talk</option>
                                                
                                            @elseif( $blog->type ==="Food")
                                                <option value="">Select blog Type</option>
                                                <option value="Travel">Travel</option>
                                                <option selected value="Food">Food</option>
                                                <option value="Lifestyle">Lifestyle</option>
                                                <option value="Beautification">Beautification</option>
                                                <option value="Business Talk">Business Talk</option>                              
                                               
                                            @elseif($blog->type ==="Lifestyle")
                                                <option value="">Select blog Type</option>
                                                <option value="Travel">Travel</option>
                                                <option value="Food">Food</option>
                                                <option selected value="Lifestyle">Lifestyle</option>
                                                <option value="Beautification">Beautification</option>
                                                <option value="Business Talk">Business Talk</option>      

                                            @elseif($blog->type ==="Beautification")
                                                <option value="">Select blog Type</option>
                                                <option value="Travel">Travel</option>
                                                <option value="Food">Food</option>
                                                <option value="Lifestyle">Lifestyle</option>
                                                <option selected value="Beautification">Beautification</option>
                                                <option value="Business Talk">Business Talk</option>
                                            @elseif($blog->type ==="Business Talk")
                                                <option value="">Select blog Type</option>
                                                <option value="Travel">Travel</option>
                                                <option value="Food">Food</option>
                                                <option value="Lifestyle">Lifestyle</option>
                                                <option value="Beautification">Beautification</option>
                                                <option selected value="Business Talk">Business Talk</option>                                                
                                            @endif 
                                            
                                        </select>
                                        @if($errors->has('type'))
                                            <span class="text-danger">
                                                {{ $type= $errors->first('type')}}
                                            </span>
                                        @else
                                            {{$type=''}}
                                        @endif
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <label class="control-label">Title</label>
                                        <input type="text"  name="title" value="{{ $blog->title !== null ? $blog->title :old('title', $blog->title) }}" class="form-control" placeholder="Enter blog title" />
                                        @if($errors->has('title'))
                                            <span class="text-danger">
                                                {{ $title= $errors->first('title')}}
                                            </span>   
                                        @else
                                            {{$title=''}}
                                        @endif
                                    </div>                                    
                                </div>
                            </div>                            
                        </div>                         
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="Blog description" class="control-label">Description</label>
                                        <textarea name="description" id="description" class="form-control" placeholder="Enter blog description" rows="10" >{{ $blog->description !== null ? $blog->description :old('description', $blog->description) }}</textarea>
                                        @if($errors->has('description'))
                                            <span class="text-danger">
                                                {{ $description=$errors->first('description')}}
                                            </span>
                                        @else
                                            {{$description=''}}
                                        @endif
                                    </div>
                                </div>
                            </div>                            
                        </div>                                              
                        <div class="row">
                            <div class="col-md-12">
                            <div class="form-group d-flex justify-content-end">
                                 <button type="submit"   class="btn btn-success" ><i class="fa fa-save"></i> Save Blog Post </button>
                            </div>
                            </div>
                        </div>  
                  </form>
                </div>
              </div>
            </div>
          </div>

        <!-- /.container-fluid -->
      <!-- End of Main Content -->
@endsection
