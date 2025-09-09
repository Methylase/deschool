@extends('layouts.app')
  @section('content')

    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
      <div
        class="d-flex flex-column align-items-center justify-content-center"
        style="min-height: 400px"
      >
        <h3 class="display-3 font-weight-bold text-white">Contact Us</h3>
        <div class="d-inline-flex text-white">
          <p class="m-0"><a class="text-white" href="{{route('home')}}">Home</a></p>
          <p class="m-0 px-2">/</p>
          <p class="m-0">Contact Us</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

    <!-- Contact Start -->
    <div class="container-fluid pt-5">
      <div class="container">
        <div class="text-center pb-2">
          <p class="section-title px-5">
            <span class="px-2">Get In Touch</span>
          </p>
          <h1 class="mb-4">Contact Us For Any Query</h1>
        </div>
        <div class="row">
          <div class="col-lg-7 mb-5">
            <div class="contact-form">
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
              @endif               <div id="success"></div>
              <form method="POST" action="/contact" >
                {{csrf_field()}}
                <div class="control-group mb-2">
                  <input
                    type="text"
                    class="form-control"
                    name="name"
                    id="name"
                    placeholder="Your Name"
                    
                    data-validation-required-message="Please enter your name"
                  />
                  @if($errors->has('name'))
                     <p class="help-block text-danger">
                          {{ $name= $errors->first('name')}}
                      </p>
                  @else
                      {{$name=''}}
                  @endif
                </div>
                <div class="control-group mb-2">
                  <input
                    type="email"
                    name="email"
                    class="form-control"
                    id="email"
                    placeholder="Your Email"
                   
                    data-validation-required-message="Please enter your email"
                  />
                  @if($errors->has('email'))
                      <p class="help-block text-danger">
                          {{ $email= $errors->first('email')}}
                      </p>
                  @else
                      {{$email=''}}
                  @endif                   
                </div>
                <div class="control-group mb-2">
                  <input
                    type="text"
                    name="subject"
                    class="form-control"
                    id="subject"
                    placeholder="Subject"
                    
                    data-validation-required-message="Please enter a subject"
                  />
                  @if($errors->has('subject'))
                     <p class="help-block text-danger">
                          {{ $subject= $errors->first('subject')}}
                      </p>
                  @else
                      {{$subject=''}}
                  @endif                    
                  
                </div>
                <div class="control-group mb-4">
                  <textarea
                    name="message"
                    class="form-control"
                    rows="6"
                    id="message"
                    placeholder="Message"
                  
                    data-validation-required-message="Please enter your message"
                  ></textarea>
                  @if($errors->has('message'))
                     <p class="help-block text-danger">
                          {{ $message= $errors->first('message')}}
                      </p>
                  @else
                      {{$message=''}}
                  @endif                    
                
                </div>
                <div>
                  <button
                    class="btn btn-primary py-2 px-4"
                    type="submit"
                    name="contact"
                    value="Contact Us"
                  >
                    Send Message
                  </button>
                </div>
              </form>
            </div>
          </div>
          <div class="col-lg-5 mb-5">
            <p>
             Looking for a school that puts your child first? At The School, 
             we offer a safe, nurturing environment with quality education and personalized support.
              Contact us today to learn how we can help your child thrive.
            </p>
            <div class="d-flex">
              <i
                class="fa fa-map-marker-alt d-inline-flex align-items-center justify-content-center bg-primary text-secondary rounded-circle"
                style="width: 45px; height: 45px"
              ></i>
              <div class="pl-3">
                <h5>Address</h5>
                <p>Lekki Phase 1—like Adebayo Doherty Road, Admiralty Way</p>
              </div>
            </div>
            <div class="d-flex">
              <i
                class="fa fa-envelope d-inline-flex align-items-center justify-content-center bg-primary text-secondary rounded-circle"
                style="width: 45px; height: 45px"
              ></i>
              <div class="pl-3">
                <h5>Email</h5>
                <p>mail@theschool.com</p>
              </div>
            </div>
            <div class="d-flex">
              <i
                class="fa fa-phone-alt d-inline-flex align-items-center justify-content-center bg-primary text-secondary rounded-circle"
                style="width: 45px; height: 45px"
              ></i>
              <div class="pl-3">
                <h5>Phone</h5>
                <p>09036561101</p>
              </div>
            </div>
            <div class="d-flex">
              <i
                class="far fa-clock d-inline-flex align-items-center justify-content-center bg-primary text-secondary rounded-circle"
                style="width: 45px; height: 45px"
              ></i>
              <div class="pl-3">
                <h5>Opening Hours</h5>
                <strong>Monday - Friday:</strong>
                <p class="m-0">8:00 AM - 4:00 PM</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Contact End -->

 @endsection