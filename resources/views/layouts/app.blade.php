<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>The School - {{$title}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Free HTML Templates" name="keywords" />
    <meta content="Free HTML Templates" name="description" />

    <!-- Favicon -->
    <link href="{{asset('app/img/favicon.ico')}}" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
      href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap"
      rel="stylesheet"
    />

    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
      rel="stylesheet"
    />

    <!-- Flaticon Font -->
    <link href="{{asset('app/lib/flaticon/font/flaticon.css')}}" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="{{asset('app/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet" />
    <link href="{{asset('app/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('app/css/style.css')}}" rel="stylesheet" />
  </head>

  <body>
    <!-- Navbar Start -->
    <div class="container-fluid bg-light position-relative shadow">
      <nav
        class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5"
      >
        <a
          href="{{route('home')}}"
          class="navbar-brand font-weight-bold text-secondary"
          style="font-size: 50px"
        >
        <img src="{{asset('app/img/graduation-cap.png')}}" width="64" height="64">
        <span class="text-info">Theschool</span>
        </a>
        <button
          type="button"
          class="navbar-toggler"
          data-toggle="collapse"
          data-target="#navbarCollapse"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div
          class="collapse navbar-collapse justify-content-between"
          id="navbarCollapse"
        >
          <div class="navbar-nav font-weight-bold mx-auto py-0">
            <a href="{{route('home')}}" class="nav-item nav-link active">Home</a>
            <a href="{{route('about')}}" class="nav-item nav-link">About Us</a>
            <a href="{{route('vision')}}" class="nav-item nav-link">Vision</a>
            <a href="{{route('mission')}}" class="nav-item nav-link">Mission</a>
            <a href="{{route('blog')}}" class="nav-item nav-link">Blog</a>
            <a href="{{route('contact')}}" class="nav-item nav-link">Contact Us</a>
          </div>
          <a href="{{route('login')}}" class="btn btn-primary px-4">Login</a>
        </div>
      </nav>
    </div>
    <!-- Navbar End -->

    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-white mt-5 py-5 px-sm-3 px-md-5">
      <div class="row pt-5">
        <div class="col-lg-3 col-md-6 mb-5">
          <a
            href=""
            class="navbar-brand font-weight-bold text-primary m-0 mb-4 p-0"
            style="font-size: 40px; line-height: 40px"
          >
            <img src="{{asset('app/img/graduation-cap.png')}}" width="64" height="64">
            <span class="text-white">Theschool</span>
          </a>
          <p>
            Located at the heart of a vibrant learning community, this institution fosters curiosity,
            creativity, and critical thinking. With dedicated educators and a dynamic curriculum, 
            it empowers students to excel both academically and personally. Its commitment to holistic development
            ensures every learner thrives
          </p>
          <div class="d-flex justify-content-start mt-4">
            <a
              class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
              style="width: 38px; height: 38px"
              href="#"
              ><i class="fab fa-twitter"></i
            ></a>
            <a
              class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
              style="width: 38px; height: 38px"
              href="#"
              ><i class="fab fa-facebook-f"></i
            ></a>
            <a
              class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
              style="width: 38px; height: 38px"
              href="#"
              ><i class="fab fa-linkedin-in"></i
            ></a>
            <a
              class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
              style="width: 38px; height: 38px"
              href="#"
              ><i class="fab fa-instagram"></i
            ></a>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
          <h3 class="text-primary mb-4">Get In Touch</h3>
          <div class="d-flex">
            <h4 class="fa fa-map-marker-alt text-primary"></h4>
            <div class="pl-3">
              <h5 class="text-white">Address</h5>
              <p>Lekki Phase 1—like Adebayo Doherty Road, Admiralty Way</p>
            </div>
          </div>
          <div class="d-flex">
            <h4 class="fa fa-envelope text-primary"></h4>
            <div class="pl-3">
              <h5 class="text-white">Email</h5>
              <p>mail@theschool.com</p>
            </div>
          </div>
          <div class="d-flex">
            <h4 class="fa fa-phone-alt text-primary"></h4>
            <div class="pl-3">
              <h5 class="text-white">Phone</h5>
              <p>09036561101</p>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
          <h3 class="text-primary mb-4">Quick Links</h3>
          <div class="d-flex flex-column justify-content-start">
            <a class="text-white mb-2" href="{{route('home')}}"
              ><i class="fa fa-angle-right mr-2"></i>Home</a
            >
            <a class="text-white mb-2" href="{{route('about')}}"
              ><i class="fa fa-angle-right mr-2"></i>About Us</a
            >
            <a class="text-white mb-2" href="{{route('blog')}}"
              ><i class="fa fa-angle-right mr-2"></i>Our Blog</a
            >
            <a class="text-white" href="{{route('contact')}}"
              ><i class="fa fa-angle-right mr-2"></i>Contact Us</a
            >
            <a class="text-white" href="{{route('privacy-policy')}}"
              ><i class="fa fa-angle-right mr-2"></i>Privacy Policy</a
            >
            <a class="text-white" href="{{route('vision')}}"
              ><i class="fa fa-angle-right mr-2"></i>Vision</a
            >
            <a class="text-white" href="{{route('mission')}}"
              ><i class="fa fa-angle-right mr-2"></i>Vision</a
            >            
          </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-5">
          @if(session()->has('successMessage'))
              <div class="col-md-12 col-sm-12 alert
              alert-success alert-dismissable text-center text-small" style="margin-top:20px">
                <a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a>
                <strong>
                    Success
                </strong>
                {{session('successMessage')}}
              </div>
          @endif
          @if(session()->has('errorMessage'))
              <div class="offset-md-1 col-md-10 offset-sm-1 col-sm-10 alert
              alert-danger alert-dismissable text-center text-small" style="margin-top:20px">
                <a href='' class='close' data-dismiss='alert' aria-label='close'> &times</a>
                <strong>
                    Danger
                </strong>
                {{session('errorMessage')}}
              </div>
            @endif            
          <h3 class="text-primary mb-4">Newsletter</h3>
          <form action="/newsletter" method="POST">
            {{csrf_field()}}
            <div class="form-group">
              <input
                type="text"
                class="form-control border-0 py-4"
                name="name"
                placeholder="Your Name"
                
              />
              @if($errors->has('name'))
                  <p class="help-block text-danger">
                      {{ $name= $errors->first('name')}}
                  </p>
              @else
                  {{$name=''}}
              @endif
            </div>
            <div class="form-group">
              <input
                type="email"
                name="email"
                class="form-control border-0 py-4"
                placeholder="Your Email"
                
              />
              @if($errors->has('email'))
                  <p class="help-block text-danger">
                      {{ $email= $errors->first('email')}}
                  </p>
              @else
                  {{$email=''}}
              @endif              
            </div>
            <div>
              <button
                class="btn btn-primary btn-block border-0 py-3"
                type="submit"
              >
                Submit Now
              </button>
            </div>
          </form>
        </div>
      </div>
      <div
        class="container-fluid pt-5"
        style="border-top: 1px solid rgba(23, 162, 184, 0.2) ;"
      >
        <p class="m-0 text-center text-white">
          &copy;
          <a class="text-primary font-weight-bold" href="{{route('home')}}">The school</a>.
          All Rights Reserved.

          <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
          Designed by
          <a class="text-primary font-weight-bold" href="https://codeden.com"
            >Codeden</a
          >
        </p>
      </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary p-3 back-to-top"
      ><i class="fa fa-angle-double-up"></i
    ></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('app/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('app/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('app/lib/isotope/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('app/lib/lightbox/js/lightbox.min.js')}}"></script>

    <!-- Contact Javascript File -->
    <script src="{{asset('app/mail/jqBootstrapValidation.min.js')}}"></script>
    <script src="{{asset('app/mail/contact.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('app/js/main.js')}}"></script>
    <script>
      $('.reply-form').hide();
      $('.reply').on('click',function(){

      var id = $(this).attr('id');

      $('#reply'+id).toggle();


       

    });
    </script>
  </body>
</html>
