@extends('layouts.app')
  @section('content')

    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
      <div
        class="d-flex flex-column align-items-center justify-content-center"
        style="min-height: 400px"
      >
        <h3 class="display-3 font-weight-bold text-white">Blog Detail</h3>
        <div class="d-inline-flex text-white">
          <p class="m-0"><a class="text-white" href="{{route('home')}}">Home</a></p>
          <p class="m-0 px-2">/</p>
          <p class="m-0">Blog Detail</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- Detail Start -->
    <div class="container py-5">
      <div class="row pt-5">
        <div class="col-lg-8">
          <div class="d-flex flex-column text-left mb-3">
            <p class="section-title pr-5">
              <span class="pr-2">Blog Detail Page</span>
            </p>
            <h1 class="mb-3">{{$blog->title}}</h1>
            <div class="d-flex">
              <p class="mr-3"><i class="fa fa-user text-primary"></i> Admin</p>
              <p class="mr-3">
                <i class="fa fa-folder text-primary"></i> {{($blog->updated_at != NULL ?  'old' : 'new')}}
              </p>
              <p class="mr-3"><i class="fa fa-comments text-primary"></i> {{date('d M. Y', strtotime($blog->created_at))}}</p>
            </div>
          </div>
          <div class="mb-5">
            <img
              class="img-fluid rounded w-100 mb-4"
              src="{{asset('/blog_images/'.$blog->id.'/'.$blog->image)}}"
              alt="Image"
            />
            <p>
              {{($blog->description)}}
            </p>
           
          </div>
          <!-- Comment Form -->
          <div class="bg-light p-5">
            @if(session()->has('success'))
                <div class="col-md-12 col-sm-12 alert
                alert-success alert-dismissable text-center text-small" style="margin-top:20px">
                  <a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a>
                  <strong>
                      Success
                  </strong>
                  {{session('success')}}
                </div>
            @endif            
            <h2 class="mb-4">Leave a comment</h2>
            <form method="POST" action="/comment">
              {{csrf_field()}}
              <input type="hidden"  name="blog_id" value="{{$blog->id}}">
              <input type="hidden" name="parent_id"  value="">
              <div class="form-group">
                <label for="name">Name *</label>
                <input type="text" name="name" class="form-control" id="name" />
                  @if($errors->has('name'))
                     <p class="help-block text-danger">
                          {{ $name= $errors->first('name')}}
                      </p>
                  @else
                      {{$name=''}}
                  @endif
              </div>
              <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" name="email" class="form-control" id="email" />
                  @if($errors->has('emaik'))
                     <p class="help-block text-danger">
                          {{ $email= $errors->first('email')}}
                      </p>
                  @else
                      {{$email=''}}
                  @endif
              </div>
              <div class="form-group">
                <label for="message">Message *</label>
                <textarea
                  id="message"
                  name="message"
                  cols="30"
                  rows="5"
                  class="form-control"
                ></textarea>
                  @if($errors->has('message'))
                    <p class="help-block text-danger">
                        {{ $message= $errors->first('message')}}
                    </p>
                  @else
                      {{$message=''}}
                  @endif  
              </div>
              <div class="form-group mb-0">
                <input
                  type="submit"
                  value="Leave Comment"
                  class="btn btn-primary px-3"
                />
              </div>
            </form>
          </div>
          <!-- Comment List -->
          <div class="mb-5 mt-5">
            <h2 class="mb-4">{{count($blog->comments()->whereNull('parent_id')->latest()->get())}} Comments</h2>
            @foreach ($blog->comments()->whereNull('parent_id')->with('replies')->latest()->get() as $comment)
                @include('app._comment', ['comment' => $comment, 'level' => 0])
            @endforeach

          </div>

        </div>
      </div>
    </div>
    <!-- Detail End -->
 @endsection