@extends('layouts.app')
  @section('content')

    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
      <div
        class="d-flex flex-column align-items-center justify-content-center"
        style="min-height: 400px"
      >
        <h3 class="display-3 font-weight-bold text-white">Our Vision</h3>
        <div class="d-inline-flex text-white">
          <p class="m-0"><a class="text-white" href="{{route('home')}}">Home</a></p>
          <p class="m-0 px-2">/</p>
          <p class="m-0">Vision</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- Contact Start -->
    <div class="container-fluid pt-5">
      <div class="container">
        <div class="text-center pb-2">
          <p class="section-title px-5">
            <span class="px-2">Our stated Vision</span>
          </p>
        </div>
        <div class="row">
          <div class="col-lg-12 mb-5">
            <div>

              <ul>
                <li>To inspire a lifelong love for learning in every student.</li>
                <li>To nurture confident, compassionate, and creative individuals.</li>
                <li>To provide a safe and inclusive environment for growth.</li>
                <li>To foster innovation, critical thinking, and global awareness.</li>
                <li>To shape future leaders with integrity and purpose.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Contact End -->

 @endsection