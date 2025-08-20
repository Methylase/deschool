@extends('layouts.app')
  @section('content')

    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
      <div
        class="d-flex flex-column align-items-center justify-content-center"
        style="min-height: 400px"
      >
        <h3 class="display-3 font-weight-bold text-white">Our Mission</h3>
        <div class="d-inline-flex text-white">
          <p class="m-0"><a class="text-white" href="{{route('home')}}">Home</a></p>
          <p class="m-0 px-2">/</p>
          <p class="m-0">Mision</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- Contact Start -->
    <div class="container-fluid pt-5">
      <div class="container">
        <div class="text-center pb-2">
          <p class="section-title px-5">
            <span class="px-2">Our stated Mission</span>
          </p>
        </div>
        <div class="row">

          <div class="col-lg-12">
            <div>
              <ul>
                <li>To deliver high-quality education that meets the diverse needs of all students.</li>
                <li>To cultivate a safe, inclusive, and supportive learning environment.</li>
                <li>To inspire curiosity, creativity, and a passion for lifelong learning.</li>
                <li>To develop strong character, leadership, and social responsibility.</li>
                <li>To engage families and the community in the educational journey.</li>
              </ul>  
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Contact End -->

 @endsection