
@extends('layouts.app')
  @section('content')
    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
      <div
        class="d-flex flex-column align-items-center justify-content-center"
        style="min-height: 400px"
      >
        <h3 class="display-3 font-weight-bold text-white">About Us</h3>
        <div class="d-inline-flex text-white">
          <p class="m-0"><a class="text-white" href="{{route('home')}}">Home</a></p>
          <p class="m-0 px-2">/</p>
          <p class="m-0">About Us</p>
        </div>
      </div>
    </div>
    <!-- Header End -->

  <!-- About Start -->
  <div class="container-fluid py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-12">
          <img
            class="img-fluid rounded mb-5 mb-lg-0"
            src="{{asset('app/img/about-1.jpg')}}"
            alt=""
          />
        </div>

      <div class="row align-items-center mt-3">
        <div class="col-lg-12">
          <p class="section-title pr-5 mt-2">
            <span class="pr-2">Learn About Us</span>
          </p>
          <h1 class="mb-4">Best School For Your Kids</h1>
          <p>
            Our school offers a perfect blend of academic excellence, creativity, and care tailored for young minds.
            With experienced teachers and a nurturing environment, every child is supported to thrive and succeed.
            From early learning to strong values, we provide the best start for your child’s bright future.
          </p>
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->

  <!-- Facilities Start -->
  <div class="container-fluid pt-5">
    <div class="container pb-3">
      <div class="row">
        <div class="col-lg-4 col-md-6 pb-1">
          <div
            class="d-flex bg-light shadow-sm border-top rounded mb-4"
            style="padding: 30px"
          >
            <i
              class="flaticon-050-fence h1 font-weight-normal text-primary mb-3"
            ></i>
            <div class="pl-4">
              <h4>Play Ground</h4>
              <p class="m-0">
                We Offer a safe and fun space where children can play, explore, and grow.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 pb-1">
          <div
            class="d-flex bg-light shadow-sm border-top rounded mb-4"
            style="padding: 30px"
          >
            <i
              class="flaticon-022-drum h1 font-weight-normal text-primary mb-3"
            ></i>
            <div class="pl-4">
              <h4>Music and Dance</h4>
              <p class="m-0">
                Our music and sound program nurtures creativity and rhythm, helping children express
                themselves through joyful, hands-on musical experiences.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 pb-1">
          <div
            class="d-flex bg-light shadow-sm border-top rounded mb-4"
            style="padding: 30px"
          >
            <i
              class="flaticon-030-crayons h1 font-weight-normal text-primary mb-3"
            ></i>
            <div class="pl-4">
              <h4>Arts and Crafts</h4>
              <p class="m-0">
                Our arts and crafts sessions inspire creativity and self-expression through fun,
                hands-on activities tailored for young learners.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 pb-1">
          <div
            class="d-flex bg-light shadow-sm border-top rounded mb-4"
            style="padding: 30px"
          >
            <i
              class="flaticon-017-toy-car h1 font-weight-normal text-primary mb-3"
            ></i>
            <div class="pl-4">
              <h4>Safe Transportation</h4>
              <p class="m-0">
               Our transportation system ensures safe, reliable, and comfortable travel for children to and from school.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 pb-1">
          <div
            class="d-flex bg-light shadow-sm border-top rounded mb-4"
            style="padding: 30px"
          >
            <i
              class="flaticon-025-sandwich h1 font-weight-normal text-primary mb-3"
            ></i>
            <div class="pl-4">
              <h4>Healthy food</h4>
              <p class="m-0">
                We provide healthy, balanced, and child-friendly meals that support growth and learning.
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 pb-1">
          <div
            class="d-flex bg-light shadow-sm border-top rounded mb-4"
            style="padding: 30px"
          >
            <i
              class="flaticon-047-backpack h1 font-weight-normal text-primary mb-3"
            ></i>
            <div class="pl-4">
              <h4>Educational Tour</h4>
              <p class="m-0">
                Our dedicated teachers nurture each child’s potential with care, expertise, and a passion for learning.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Facilities Start -->

  <!-- Team Start -->
  <div class="container-fluid pt-5">
    <div class="container">
      <div class="text-center pb-2">
        <p class="section-title px-5">
          <span class="px-2">Our Management</span>
        </p>
        <h1 class="mb-4">Meet Our Management</h1>
      </div>
      <div class="row">
        <div class="col-md-6 col-lg-3 text-center team mb-5">
          <div
            class="position-relative overflow-hidden mb-4"
            style="border-radius: 100%"
          >
            <img class="img-fluid w-100" src="{{asset('app/img/head-of-management.jpeg')}}" height="250px" alt="" />
            <div
              class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute"
            >
              <a
                class="btn btn-outline-light text-center mr-2 px-0"
                style="width: 38px; height: 38px"
                href="#"
                ><i class="fab fa-twitter"></i
              ></a>
              <a
                class="btn btn-outline-light text-center mr-2 px-0"
                style="width: 38px; height: 38px"
                href="#"
                ><i class="fab fa-facebook-f"></i
              ></a>
              <a
                class="btn btn-outline-light text-center px-0"
                style="width: 38px; height: 38px"
                href="#"
                ><i class="fab fa-linkedin-in"></i
              ></a>
            </div>
          </div>
          <h4>Korede Smith</h4>
          <i>Head Of Departments</i>
        </div>
        <div class="col-md-6 col-lg-3 text-center team mb-5">
          <div
            class="position-relative overflow-hidden mb-4"
            style="border-radius: 100%"
          >
            <img class="img-fluid w-100" src="{{asset('app/img/head-of-science.jpeg')}}" height="250px"  alt="" />
            <div
              class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute"
            >
              <a
                class="btn btn-outline-light text-center mr-2 px-0"
                style="width: 38px; height: 38px"
                href="#"
                ><i class="fab fa-twitter"></i
              ></a>
              <a
                class="btn btn-outline-light text-center mr-2 px-0"
                style="width: 38px; height: 38px"
                href="#"
                ><i class="fab fa-facebook-f"></i
              ></a>
              <a
                class="btn btn-outline-light text-center px-0"
                style="width: 38px; height: 38px"
                href="#"
                ><i class="fab fa-linkedin-in"></i
              ></a>
            </div>
          </div>
          <h4>Janet Akinlade</h4>
          <i>Head Of Science Dept</i>
        </div>
        <div class="col-md-6 col-lg-3 text-center team mb-5">
          <div
            class="position-relative overflow-hidden mb-4"
            style="border-radius: 100%"
          >
            <img class="w-100" src="{{asset('app/img/head-of-art.jpg')}}" height="250px"  alt="" />
            <div
              class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute"
            >
              <a
                class="btn btn-outline-light text-center mr-2 px-0"
                style="width: 38px; height: 38px"
                href="#"
                ><i class="fab fa-twitter"></i
              ></a>
              <a
                class="btn btn-outline-light text-center mr-2 px-0"
                style="width: 38px; height: 38px"
                href="#"
                ><i class="fab fa-facebook-f"></i
              ></a>
              <a
                class="btn btn-outline-light text-center px-0"
                style="width: 38px; height: 38px"
                href="#"
                ><i class="fab fa-linkedin-in"></i
              ></a>
            </div>
          </div>
          <h4>Bimbo Aderibigbe</h4>
          <i>Head Of Art Dept</i>
        </div>
        <div class="col-md-6 col-lg-3 text-center team mb-5">
          <div
            class="position-relative overflow-hidden mb-4"
            style="border-radius: 100%"
          >
            <img class="w-100" src="{{asset('app/img/head-of-commercial.jpg')}}" height="250px"  alt="" />
            <div
              class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute"
            >
              <a
                class="btn btn-outline-light text-center mr-2 px-0"
                style="width: 38px; height: 38px"
                href="#"
                ><i class="fab fa-twitter"></i
              ></a>
              <a
                class="btn btn-outline-light text-center mr-2 px-0"
                style="width: 38px; height: 38px"
                href="#"
                ><i class="fab fa-facebook-f"></i
              ></a>
              <a
                class="btn btn-outline-light text-center px-0"
                style="width: 38px; height: 38px"
                href="#"
                ><i class="fab fa-linkedin-in"></i
              ></a>
            </div>
          </div>
          <h4>Dele Olalere</h4>
          <i>Head Of Commercial Dept</i>
        </div>
      </div>
    </div>
  </div>
  <!-- Team End -->
 @endsection