@extends('layouts.app')
  @section('content')

    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
      <div
        class="d-flex flex-column align-items-center justify-content-center"
        style="min-height: 400px"
      >
        <h3 class="display-3 font-weight-bold text-white">Privacy Policy</h3>
        <div class="d-inline-flex text-white">
          <p class="m-0"><a class="text-white" href="{{route('home')}}">Home</a></p>
          <p class="m-0 px-2">/</p>
          <p class="m-0">Privacy Policy</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- Contact Start -->
    <div class="container-fluid pt-5">
      <div class="container">
        <div class="text-center pb-2">
          <p class="section-title px-5">
            <span class="px-2">Take A Look At Our Privacy Policy</span>
          </p>
        </div>
        <div class="row">

          <div class="col-lg-12">
            <div>
              <ul>

                <li>We respect the privacy of all students, parents, and staff.</li>

                <li>Personal information is collected only for educational and administrative purposes.</li>

                <li>All data is stored securely and accessed only by authorized personnel.</li>

                <li>We do not sell or rent personal information to third parties.</li>

                <li>Information may be shared with third parties only with consent or when legally required.</li>

                <li>We use secure technology to protect online communications and records.</li>

                <li>Parents and guardians have the right to access and update their child's information.</li>

                <li>We retain personal data only as long as necessary for school operations.</li>

                <li>Our website may collect limited data through cookies to enhance user experience.</li>

                <li>By interacting with us, you agree to the terms of this privacy policy.</li>

              </ul>
            </div>

          </div>
        </div>
      </div>
    </div>
    <!-- Contact End -->

 @endsection