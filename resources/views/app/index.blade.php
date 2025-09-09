
@extends('layouts.app')
  @section('content')
  <!-- Header Start -->
  <div class="container-fluid bg-primary px-0 px-md-5 mb-5">
    <div class="row align-items-center px-3">
      <div class="col-lg-6 text-center text-lg-left">
        <h4 class="text-white mb-4 mt-5 mt-lg-0">Education Made Easy</h4>
        <h1 class="display-3 font-weight-bold text-white">
          Secure Your Child Future Now!!!
        </h1>
        <p class="text-white mb-4">
          Give your child the best start with a nurturing environment that inspires excellence and creativity.
          Our experienced teachers, modern facilities, and holistic curriculum set the foundation for lifelong success.
          Enroll now and watch your child grow in confidence, knowledge, and character every day.
        </p>
        <a href="#register-now" class="btn btn-secondary mt-1 py-3 px-5">Register Now</a>
      </div>
      <div class="col-lg-6 text-center text-lg-right">
        <img class="img-fluid mt-5" src="{{asset('app/img/header.png')}}" alt="" />
      </div>
    </div>
  </div>
  <!-- Header End -->

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
            <div class="pl-4" style="height:160px">
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
            <div class="pl-4" style="height:160px">
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
            <div class="pl-4" style="height:160px">
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
            <div class="pl-4" style="height:160px">
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
            <div class="pl-4" style="height:160px">
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

  <!-- About Start -->
  <div class="container-fluid py-5">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-5">
          <img
            class="img-fluid rounded mb-5 mb-lg-0"
            src="{{asset('app/img/about-1.jpg')}}"
            alt=""
          />
        </div>
        <div class="col-lg-7">
          <p class="section-title pr-5">
            <span class="pr-2">Learn About Us</span>
          </p>
          <h1 class="mb-4">Best School For Your Kids</h1>
          <p>
            Our school offers a perfect blend of academic excellence, creativity, and care tailored for young minds.
            With experienced teachers and a nurturing environment, every child is supported to thrive and succeed.
            From early learning to strong values, we provide the best start for your child’s bright future.
          </p>
          <a href="{{route('about')}}" class="btn btn-primary mt-2 py-2 px-4">Learn More</a>
        </div>
      </div>
    </div>
  </div>
  <!-- About End -->

  <!-- Class Start -->
  <div class="container-fluid pt-5">
    <div class="container">
      <div class="text-center pb-2">
        <p class="section-title px-5">
          <span class="px-2">Popular Classes</span>
        </p>
        <h1 class="mb-4">Classes for Your Kids</h1>
      </div>
      <div class="row">
        <div class="col-lg-4 mb-5">
          <div class="card border-0 bg-light shadow-sm pb-2">
            <img class="card-img-top mb-2" src="{{asset('app/img/class-image-1.jpg')}}" height="250px" alt="" />
            <div class="card-body text-center">
              <h4 class="card-title"> Pre-Nursery Class</h4>
              <p class="card-text">
                Our Pre-Nursery class provides a warm, stimulating environment where little
                learners begin their educational journey through play and exploration.
              </p>
            </div>
            <div class="card-footer bg-transparent py-4 px-5">
              <div class="row border-bottom">
                <div class="col-6 py-1 text-right border-right">
                  <strong>Age of Child</strong>
                </div>
                <div class="col-6 py-1">3 - 4 Years</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-right border-right">
                  <strong>Total Seats</strong>
                </div>
                <div class="col-6 py-1">15 Seats</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-right border-right">
                  <strong>Class Time</strong>
                </div>
                <div class="col-6 py-1">08:00 - 2:00</div>
              </div>
              <div class="row">
                <div class="col-6 py-1 text-right border-right">
                  <strong>Tution Fee</strong>
                </div>
                <div class="col-6 py-1">{{'&#8358;'.number_format(2500000,2)}} <br> Per Term</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-5">
          <div class="card border-0 bg-light shadow-sm pb-2">
            <img class="card-img-top mb-2" src="{{asset('app/img/class-image-2.jpg')}}" height="250px" alt="" />
            <div class="card-body text-center">
              <h4 class="card-title">Nursery/Primary</h4>
              <p class="card-text">
                Our classes offer a solid foundation in academics, creativity, and character development.
                We help children grow into confident, independent learners.
              </p>
            </div>
            <div class="card-footer bg-transparent py-4 px-5">
              <div class="row border-bottom">
                <div class="col-6 py-1 text-right border-right">
                  <strong>Age of Child</strong>
                </div>
                <div class="col-6 py-1">4 - 10 Years</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-right border-right">
                  <strong>Total Seats</strong>
                </div>
                <div class="col-6 py-1">20 Seats</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-right border-right">
                  <strong>Class Time</strong>
                </div>
                <div class="col-6 py-1">08:00 - 2:00</div>
              </div>
              <div class="row">
                <div class="col-6 py-1 text-right border-right">
                  <strong>Tution Fee</strong>
                </div>
                <div class="col-6 py-1">{{'&#8358;'.number_format(4500000,2)}} <br> Per Term</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-5">
          <div class="card border-0 bg-light shadow-sm pb-2">
            <img class="card-img-top mb-2" src="{{asset('app/img/class-image-3.jpg')}}" height="250px" alt="" />
            <div class="card-body text-center">
              <h4 class="card-title">Secondary</h4>
              <p class="card-text">
                Our Secondary class equips students with critical thinking skills, academic excellence,
                and real-world readiness. We foster leadership in higher education and beyond.
              </p>
            </div>
            <div class="card-footer bg-transparent py-4 px-5">
              <div class="row border-bottom">
                <div class="col-6 py-1 text-right border-right">
                  <strong>Age of Child</strong>
                </div>
                <div class="col-6 py-1">10 - 16 Years</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-right border-right">
                  <strong>Total Seats</strong>
                </div>
                <div class="col-6 py-1">25/40 Seats</div>
              </div>
              <div class="row border-bottom">
                <div class="col-6 py-1 text-right border-right">
                  <strong>Class Time</strong>
                </div>
                <div class="col-6 py-1">08:00 - 2:00</div>
              </div>
              <div class="row">
                <div class="col-6 py-1 text-right border-right">
                  <strong>Tution Fee</strong>
                </div>
                <div class="col-6 py-1">{{'&#8358;'.number_format(600000,2)}} <br> Per Term</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Class End -->

  <!-- Registration Start -->
  <div class="container-fluid py-5" id="register-now">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7 mb-5 mb-lg-0">
          <p class="section-title pr-5">
            <span class="pr-2">Book A Seat</span>
          </p>
          <h1 class="mb-4">Book A Seat For Your Kid</h1>
          <p>
            Booking a class seat ensures your child secures a spot in a safe, supportive learning environment
            tailored to their needs. It helps us maintain optimal class sizes for personalized attention and
            effective teaching. Early booking also guarantees access to our quality curriculum and experienced
             educators.
          </p>
          <ul class="list-inline m-0">

            <li class="py-2">
              <i class="fa fa-check text-success mr-3"></i>
              Auto alert when your child clock-in/out of the school premises.
            </li>
            <li class="py-2">
              <i class="fa fa-check text-success mr-3"></i>
              Get real time update on the academic performance of your child.
            </li>
            <li class="py-2">
              <i class="fa fa-check text-success mr-3"></i>
              Guides and tips from our update post on how you can handle your child 
                  study performance at home.
            </li>
          </ul>
        </div>
        <div class="col-lg-5">
          <div class="card border-0">
            <div class="card-header bg-secondary text-center p-4">
              <h1 class="text-white m-0">Book A Seat</h1>
            </div>
            <div class="card-body rounded-bottom bg-primary p-5">
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
              <form method="POST" action="/booked">
                 {{csrf_field()}}
                <div class="form-group">
                  <input
                    type="text"
                    name="name"
                    class="form-control border-0 p-4"
                    placeholder="Your Name"
                    required="required"
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
                    class="form-control border-0 p-4"
                    placeholder="Your Email"
                    required="required"
                  />
                  @if($errors->has('email'))
                      <p class="help-block text-danger">
                          {{ $email= $errors->first('email')}}
                      </p>
                  @else
                      {{$email=''}}
                  @endif                    
                </div>
                <div class="form-group">
                  <select
                    class="custom-select border-0 px-4"
                    name="class"
                    style="height: 47px"
                  >
                   <option value="">Select-Class</option>
                  @if(isset($classes) && $classes !="")
                      @foreach($classes as $class) 
                        <option value="{{$class->id}}">{{ucfirst($class->class_name)}}</option>
                      @endforeach
                  @endif 
                  </select>
                  @if($errors->has('class'))
                      <p class="help-block text-danger">
                          {{ $class= $errors->first('class')}}
                      </p>
                  @else
                      {{$class=''}}
                  @endif                    
                </div>
                <div>
                  <button
                    class="btn btn-secondary btn-block border-0 py-3"
                    type="submit"
                  >
                    Book Now
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Registration End -->

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

  <!-- Testimonial Start -->
  <div class="container-fluid py-5">
    <div class="container p-0">
      <div class="text-center pb-2">
        <p class="section-title px-5">
          <span class="px-2">Testimonial</span>
        </p>
        <h1 class="mb-4">What Parents Say!</h1>
      </div>
      <div class="owl-carousel testimonial-carousel">
        <div class="testimonial-item px-3">
          <div class="bg-light shadow-sm rounded mb-4 p-4">
            <h3 class="fas fa-quote-left text-primary mr-3"></h3>
            The school feels like a second home—safe, supportive, and nurturing.
          </div>
          <div class="d-flex align-items-center">
            <img
              class="rounded-circle"
              src="{{asset('app/img/parent-1.jpg')}}"
              style="width: 70px; height: 70px"
              alt="Image"
            />
            <div class="pl-3">
              <h5>Jayeola Aderikola</h5>
              <i>Medical Doctor</i>
            </div>
          </div>
        </div>
        <div class="testimonial-item px-3">
          <div class="bg-light shadow-sm rounded mb-4 p-4">
            <h3 class="fas fa-quote-left text-primary mr-3"></h3>
            Since enrolling, my child has become more confident and excited about learning
          </div>
          <div class="d-flex align-items-center">
            <img
              class="rounded-circle"
              src="{{asset('app/img/parent-2.jpg')}}"
              style="width: 70px; height: 70px"
              alt="Image"
            />
            <div class="pl-3">
              <h5>Philip Andrew</h5>
              <i>Civil Servant</i>
            </div>
          </div>
        </div>
        <div class="testimonial-item px-3">
          <div class="bg-light shadow-sm rounded mb-4 p-4">
            <h3 class="fas fa-quote-left text-primary mr-3"></h3>
            The teachers genuinely care and it shows in my child's progress every term
          </div>
          <div class="d-flex align-items-center">
            <img
              class="rounded-circle"
              src="{{asset('app/img/parent-3.jpg')}}"
              style="width: 70px; height: 70px"
              alt="Image"
            />
            <div class="pl-3">
              <h5>Diekola Farogbon</h5>
              <i>Software Engineer</i>
            </div>
          </div>
        </div>
        <div class="testimonial-item px-3">
          <div class="bg-light shadow-sm rounded mb-4 p-4">
            <h3 class="fas fa-quote-left text-primary mr-3"></h3>
            I love the balance of academics, creativity, and moral values in the curriculum.
          </div>
          <div class="d-flex align-items-center">
            <img
              class="rounded-circle"
              src="{{asset('app/img/parent-4.jpg')}}"
              style="width: 70px; height: 70px"
              alt="Image"
            />
            <div class="pl-3">
              <h5> John Lawrence</h5>
              <i>Fitness Trainer</i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Testimonial End -->

  <!-- Blog Start -->
  <div class="container-fluid pt-5">
    <div class="container">
      <div class="text-center pb-2">
        <p class="section-title px-5">
          <span class="px-2">Latest Blog</span>
        </p>
        <h1 class="mb-4">Latest Articles From Blog</h1>
      </div>
      <div class="row pb-3">
        @foreach ($blogs as $blog)
          <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm mb-2">
              <img class="card-img-top mb-2" src="{{asset('/blog_images/'.$blog->id.'/'.$blog->image)}}" alt="" />
              <div class="card-body bg-light text-center p-4">
                <h4 class="">{{$blog->title}}</h4>
                <div class="d-flex justify-content-center mb-3">
                  <small class="mr-3"
                    ><i class="fa fa-user text-primary"></i> Admin</small
                  >
                  <small class="mr-3"
                    ><i class="fa fa-folder text-primary"></i> {{($blog->updated_at != NULL ?  'old' : 'new')}}</small
                  >
                  <small class="mr-3"
                    ><i class="fa fa-comments text-primary"></i>{{date('d M. Y', strtotime($blog->created_at))}}</small
                  >
                </div>
                <p>
                  {{($blog->description)}}
                </p>
                <a href="{{route('blog-post',$blog->id)}}" class="btn btn-primary px-4 mx-auto my-2"
                  >Read More</a
                >
              </div>
            </div>
          </div>
        @endforeach
        <div class="col-md-12 mb-4">
          {{$blogs->links()}}
        </div>
      </div>
    </div>
  </div>
 @endsection