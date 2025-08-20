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

  <div class="container-fluid">

    <!-- Outer Row -->
    <div class="adjust-container">

      @yield('content')
              
      </div>

    </div>

  </div>

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
  </body>
</html>
</html>
