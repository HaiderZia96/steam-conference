@section('title', 'International Linkages Conference | Advance STEAM Education')
@section('description', 'TUF ICASE conference delves into Science, Technology, Engineering, Art & Mathematics. Join us for an international discourse on advanced STEAM education. Register now!')
@section('keywords', 'International Linkages Conference, Advance STEAM Education, ICASE')
@extends('front.layouts.app_home')
@section('content')

    <!-- info sec start -->
    <div class="info-sec">
        <div class="container">
            <div class="info-countdown" style="background-image: url(front/coreui/assets/img/banner/bg.png);">
                <ul class="counter-box d-flex justify-content-around" data-countdown="2023/12/05, 10:00:00">
                </ul>
                <div class="dots img-moving-anim2">
                    <img src="front/coreui/assets/img/dots/dots3.png" alt="Shadow Image">
                </div>
            </div>
            <div class="information-area">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="600">
                        <div class="mail">
                            <div class="icon"><img src="front/coreui/assets/img/icon/mail.svg" alt="Mail"></div>
                            <a href="#" class="mail-link">Internationalconference@tuf.edu.pk</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="800">
                        <div class="location">
                            <div class="icon"><img src="front/coreui/assets/img/icon/map-pin.svg" alt="Map"></div>
                            <a href="#" class="location-link">The University of Faisalabad</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="1000">
                        <div class="number">
                            <div class="icon"><img src="front/coreui/assets/img/icon/phone.svg" alt="Phone"></div>
                            <a href="#" class="number-link">+92 (330) 1980 662</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- info sec end -->

    <!-- video container start -->
    <div class="container mb-4">
        <div class="video-container">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/3cW6rGhKbt8?si=TcYtLxupgkSSWDCT" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
    </div>
    <!-- video container end -->


    <!-- about sec start -->
    <section id="about" class="about-sec">
        <div class="container">
            <div class="section-head col-xl-9 m-auto text-center mb-5">
                {{-- <span class="label">Welcome to International Conference 2023</span> --}}
                <h1 class="title mb-4">
                    Welcome to 1<sup>st</sup> International Conference 2023
                </h1>
                <p class="desc mx-3">
                    The 1<sup>st</sup> International Conference on Advanced STEAM Education: Challenges and
                    Opportunities, 2023 is orchestrated by The University of Faisalabad (TUF). This eminent conference
                    is primed to congregate forward-thinking pedagogues, pioneering scholars, dynamic implementors and
                    fervent devotees hailing from diverse corners of the planet to engage in profound discourse
                    concerning the pivotal matter of progressing STEAM pedagogy and to probe the multifaceted
                    complexities and prospects it offers.
                </p>
            </div>
            <div class="about-items-wrap" data-aos="fade-right" data-aos-duration="1000">
                <h1 class="title text-center mb-4">
                    Advisory Board
                </h1>
                <div class="row justify-content-center g-4">
                    <div class="owl-carousel" id="owl-about">

                        <div class="col-12" data-aos="fade-right" data-aos-duration="800">
                            <div class="about-item">
                                <div class="item-thumb">
                                    <div class="advisory-img">
                                        <img src="front/coreui/assets/img/advisory/patron-new.png" alt="About Images">
                                    </div>
                                    <div class="item-content">
                                        <div class="content-title text-white">
                                            <span class="date">Muhammad Haider Amin</span>
                                            <h5 class="title">Patron in chief</h5>
                                            <h5 class="title">Chairman Board of Governors</h5>
                                        </div>
                                        {{-- <div class="about-video">
                                           <a class="video-btn1 popup-video" data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="http://www.youtube.com/watch?v=0O2aH4XLbto"><span><i class="fas fa-play"></i></span></a>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-12" data-aos="fade-right" data-aos-duration="800">
                         <div class="about-item">
                            <div class="item-thumb">
                               <div class="advisory-img">
                               <img src="front/coreui/assets/img/advisory/copatron.png" alt="About Images">
                               </div>
                               <div class="item-content">
                                  <div class="content-title text-white">
                                     <span class="date">Prof. Dr. Muhammad Khaleeq-ur-Rahman</span>
                                     <h5 class="title">Co Patron</h5>
                                  </div>
                               </div>
                            </div>
                           </div>
                        </div> --}}

                        <div class="col-12" data-aos="fade-right" data-aos-duration="800">
                            <div class="about-item">
                                <div class="item-thumb">
                                    <div class="advisory-img">
                                        <img src="front/coreui/assets/img/advisory/chairperson-new.png"
                                             alt="About Images"></div>
                                    <div class="item-content">
                                        <div class="content-title text-white">
                            <span class="date">
                              Ms. Zahida Maqbool
                            </span>
                                            <h5 class="title">Additional Registrar</h5>
                                        </div>
                                        {{-- <div class="about-video">
                                           <a class="video-btn1 popup-video" data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="http://www.youtube.com/watch?v=0O2aH4XLbto"><span><i class="fas fa-play"></i></span></a>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12" data-aos="fade-right" data-aos-duration="800">
                            <div class="about-item">
                                <div class="item-thumb">
                                    <div class="advisory-img">
                                        <img src="front/coreui/assets/img/advisory/dr_majid_hussain.jpeg"
                                             alt="About Images">
                                    </div>
                                    <div class="item-content">
                                        <div class="content-title text-white">
                                            <span class="date">Prof. Dr. Majid Hussain</span>
                                            <h5 class="title">Head, Department of Computer Sciences</h5>
                                        </div>
                                        {{-- <div class="about-video">
                                           <a class="video-btn1 popup-video" data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="http://www.youtube.com/watch?v=0O2aH4XLbto"><span><i class="fas fa-play"></i></span></a>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="dots img-moving-anim5">
                        <img src="front/coreui/assets/img/dots/dots4.png" alt="Shape Images">
                    </div>
                </div>
            </div>
        </div>
        <div class="shape">
            <img src="front/coreui/assets/img/shape/1.svg" alt="Shadow">
        </div>
    </section>
    <!-- about sec end -->
    <div class="container mt-5">
        <hr>
    </div>

    <!-- schedule sec start -->
    <section id="schedule" class="schedule-sec">
        <div class="container">
            <div class="section-head text-center col-xl-8 m-auto mb-5">
                <span class="label mb-4">Our Conference Schedule 2023</span>
                <h2 class="title">
                    An environment where participants and experts
                    can exchange ideas and experiences
                </h2>
            </div>
            <div class="schedule-content-wrap">
                <ul class="nav nav-pills schedule-nav-tab mb-5" id="pills-tab" role="tablist">
                    <li class="nav-item schedule-nav-item" role="presentation">
                        <button class="nav-link active" id="pills-day-1-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-day-1" type="button" role="tab" aria-controls="pills-day-1"
                                aria-selected="true">Day 01
                        </button>
                    </li>
                    <li class="nav-item schedule-nav-item" role="presentation">
                        <button class="nav-link" id="pills-day-2-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-day-2" type="button" role="tab" aria-controls="pills-day-2"
                                aria-selected="false">Day 02
                        </button>
                    </li>
                    {{-- <li class="nav-item schedule-nav-item" role="presentation">
                       <button class="nav-link" id="pills-day-3-tab" data-bs-toggle="pill" data-bs-target="#pills-day-3" type="button" role="tab" aria-controls="pills-day-3" aria-selected="false">Day 03</button>
                    </li> --}}
                    {{-- <li class="nav-item schedule-nav-item" role="presentation">
                       <button class="nav-link" id="pills-day-4-tab" data-bs-toggle="pill" data-bs-target="#pills-day-4" type="button" role="tab" aria-controls="pills-day-4" aria-selected="true">Day 04</button>
                    </li>
                    <li class="nav-item schedule-nav-item" role="presentation">
                       <button class="nav-link" id="pills-day-5-tab" data-bs-toggle="pill" data-bs-target="#pills-day-5" type="button" role="tab" aria-controls="pills-day-5" aria-selected="false">Day 05</button>
                    </li>
                    <li class="nav-item schedule-nav-item" role="presentation">
                       <button class="nav-link" id="pills-day-6-tab" data-bs-toggle="pill" data-bs-target="#pills-day-6" type="button" role="tab" aria-controls="pills-day-6" aria-selected="false">Day 06</button>
                    </li>
                    <li class="nav-item schedule-nav-item" role="presentation">
                       <button class="nav-link" id="pills-day-7-tab" data-bs-toggle="pill" data-bs-target="#pills-day-7" type="button" role="tab" aria-controls="pills-day-7" aria-selected="false">Day 07</button>
                    </li> --}}

                </ul>
                {{-- <div class="tab-content schedule-tab-content" id="pills-tabContent">
                   <div class="tab-pane fade show active" id="pills-day-1" role="tabpanel" aria-labelledby="pills-day-1-tab" tabindex="0">
                      <div class="row schedule-item" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="1000" style="background-image: url(front/coreui/assets/img/banner/schedule1.png);">
                         <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-around">
                               <div class="card-thumb item-thumb">
                                  <img src="front/coreui/assets/img/profile1.png" alt="Profile 1">
                               </div>
                               <div class="card-description">
                                  <span class="name d-block">Stella Smith</span>
                                  <span class="date d-block">October2,2023</span>
                                  <span class="time d-block">08:00 - 08:45</span>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-8">
                            <div class=" d-flex align-items-center justify-content-between">
                               <div class="card-title-area col-7">
                                  <h4 class="title">Presentation and Keynotes</h4>
                                  <p class="title-desc">Discover the latest trends in creativity and get inspired by creative leaders.<a href="#">Read More</a></p>
                               </div>
                               <div class="card-button col-5">
                                  <button class="custom-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                               </div>
                            </div>
                         </div>
                      </div>
                      <div class="row schedule-item" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="1000" style="background-image: url(front/coreui/assets/img/banner/schedule2.png);">
                         <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-around">
                               <div class="card-thumb">
                                  <img src="front/coreui/assets/img/profile2.png" alt="Profile 2">
                               </div>
                               <div class="card-description">
                                  <span class="name d-block">Thomas Smith</span>
                                  <span class="date d-block">October 2, 2023</span>
                                  <span class="time d-block">09:00 - 09:45</span>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-8">
                            <div class=" d-flex align-items-center justify-content-between">
                               <div class="card-title-area col-7">
                                  <h4 class="title">Sessions and Labs</h4>
                                  <p class="title-desc">Discover the latest trends in creativity and get inspired by creative leaders.<a href="#">Read More</a></p>
                               </div>
                               <div class="card-button col-5">
                                  <button class="custom-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                               </div>
                            </div>
                         </div>
                      </div>
                      <div class="row schedule-item" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="1000" style="background-image: url(front/coreui/assets/img/banner/schedule1.png);">
                         <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-around">
                               <div class="card-thumb">
                                  <img src="front/coreui/assets/img/profile3.png" alt="Profile 3">
                               </div>
                               <div class="card-description">
                                  <span class="name d-block">Monica Smith</span>
                                  <span class="date d-block">October 2, 2023</span>
                                  <span class="time d-block">10:00 - 10:45</span>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-8">
                            <div class=" d-flex align-items-center justify-content-between">
                               <div class="card-title-area col-7">
                                  <h4 class="title">Events and Networking</h4>
                                  <p class="title-desc">Discover the latest trends in creativity and get inspired by creative leaders.<a href="#">Read More</a></p>
                               </div>
                               <div class="card-button col-5">
                                  <button class="custom-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                               </div>
                            </div>
                         </div>
                      </div>
                      <div class="row schedule-item" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="1000" style="background-image: url(front/coreui/assets/img/banner/schedule2.png);">
                         <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-around">
                               <div class="card-thumb">
                                  <img src="front/coreui/assets/img/profile4.png" alt="Profile 4">
                               </div>
                               <div class="card-description">
                                  <span class="name d-block">Stella Smith</span>
                                  <span class="date d-block">October2,2023</span>
                                  <span class="time d-block">08:00 - 08:45</span>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-8">
                            <div class=" d-flex align-items-center justify-content-between">
                               <div class="card-title-area col-7">
                                  <h4 class="title">Luminary Sessions</h4>
                                  <p class="title-desc">Discover the latest trends in creativity and get inspired by creative leaders.<a href="#">Read More</a></p>
                               </div>
                               <div class="card-button col-5">
                                  <button class="custom-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="tab-pane fade" id="pills-day-2" role="tabpanel" aria-labelledby="pills-day-2-tab" tabindex="0">
                      <div class="row schedule-item" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="1000" style="background-image: url(front/coreui/assets/img/banner/schedule2.png);">
                         <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-around">
                               <div class="card-thumb">
                                  <img src="front/coreui/assets/img/profile2.png" alt="Profile 2">
                               </div>
                               <div class="card-description">
                                  <span class="name d-block">Thomas Smith</span>
                                  <span class="date d-block">October 2, 2023</span>
                                  <span class="time d-block">09:00 - 09:45</span>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-8">
                            <div class="d-flex align-items-center justify-content-between">
                               <div class="card-title-area col-7">
                                  <h4 class="title">Sessions and Labs</h4>
                                  <p class="title-desc">Discover the latest trends in creativity and get inspired by creative leaders.<a href="#">Read More</a></p>
                               </div>
                               <div class="card-buttoncol-5">
                                  <button class="custom-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                               </div>
                            </div>
                         </div>
                      </div>

                      <div class="row schedule-item" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="1000" style="background-image: url(front/coreui/assets/img/banner/schedule1.png);">
                         <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-around">
                               <div class="card-thumb">
                                  <img src="front/coreui/assets/img/profile1.png" alt="Profile 1">
                               </div>
                               <div class="card-description">
                                  <span class="name d-block">Stella Smith</span>
                                  <span class="date d-block">October2,2023</span>
                                  <span class="time d-block">08:00 - 08:45</span>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-8">
                            <div class=" d-flex align-items-center justify-content-between">
                               <div class="card-title-area col-7">
                                  <h4 class="title">Presentation and Keynotes</h4>
                                  <p class="title-desc">Discover the latest trends in creativity and get inspired by creative leaders.<a href="#">Read More</a></p>
                               </div>
                               <div class="card-button col-5">
                                  <button class="custom-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                               </div>
                            </div>
                         </div>
                      </div>

                      <div class="row schedule-item" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="1000" style="background-image: url(front/coreui/assets/img/banner/schedule1.png);">
                         <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-around">
                               <div class="card-thumb">
                                  <img src="front/coreui/assets/img/profile3.png" alt="Profile 3">
                               </div>
                               <div class="card-description">
                                  <span class="name d-block">Monica Smith</span>
                                  <span class="date d-block">October 2, 2023</span>
                                  <span class="time d-block">10:00 - 10:45</span>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-8">
                            <div class=" d-flex align-items-center justify-content-between">
                               <div class="card-title-area col-7">
                                  <h4 class="title">Events and Networking</h4>
                                  <p class="title-desc">Discover the latest trends in creativity and get inspired by creative leaders.<a href="#">Read More</a></p>
                               </div>
                               <div class="card-button col-5">
                                  <button class="custom-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                               </div>
                            </div>
                         </div>
                      </div>
                      <div class="row schedule-item" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="1000" style="background-image: url(front/coreui/assets/img/banner/schedule2.png);">
                         <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-around">
                               <div class="card-thumb">
                                  <img src="front/coreui/assets/img/profile4.png" alt="Profile 4">
                               </div>
                               <div class="card-description">
                                  <span class="name d-block">Vincent Smith</span>
                                  <span class="date d-block">October2,2023</span>
                                  <span class="time d-block">08:00 - 08:45</span>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-8">
                            <div class=" d-flex align-items-center justify-content-between">
                               <div class="card-title-area col-7">
                                  <h4 class="title">Luminary Sessions</h4>
                                  <p class="title-desc">Discover the latest trends in creativity and get inspired by creative leaders.<a href="#">Read More</a></p>
                               </div>
                               <div class="card-button col-5">
                                  <button class="custom-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="tab-pane fade" id="pills-day-3" role="tabpanel" aria-labelledby="pills-day-3-tab" tabindex="0">
                      <div class="row schedule-item" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="1000" style="background-image: url(front/coreui/assets/img/banner/schedule1.png);">
                         <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-around">
                               <div class="card-thumb">
                                  <img src="front/coreui/assets/img/profile3.png" alt="Profile 3">
                               </div>
                               <div class="card-description">
                                  <span class="name d-block">Monica Smith</span>
                                  <span class="date d-block">October 2, 2023</span>
                                  <span class="time d-block">10:00 - 10:45</span>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-8">
                            <div class=" d-flex align-items-center justify-content-between">
                               <div class="card-title-area col-7">
                                  <h4 class="title">Events and Networking</h4>
                                  <p class="title-desc">Discover the latest trends in creativity and get inspired by creative leaders.<a href="#">Read More</a></p>
                               </div>
                               <div class="card-button col-5">
                                  <button class="custom-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                               </div>
                            </div>
                         </div>
                      </div>

                      <div class="row schedule-item" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="1000" style="background-image: url(front/coreui/assets/img/banner/schedule1.png);">
                         <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-around">
                               <div class="card-thumb">
                                  <img src="front/coreui/assets/img/profile1.png" alt="Profile 1">
                               </div>
                               <div class="card-description">
                                  <span class="name d-block">Stella Smith</span>
                                  <span class="date d-block">October2,2023</span>
                                  <span class="time d-block">08:00 - 08:45</span>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-8">
                            <div class=" d-flex align-items-center justify-content-between">
                               <div class="card-title-area col-7">
                                  <h4 class="title">Presentation and Keynotes</h4>
                                  <p class="title-desc">Discover the latest trends in creativity and get inspired by creative leaders.<a href="#">Read More</a></p>
                               </div>
                               <div class="card-button col-5">
                                  <button class="custom-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                               </div>
                            </div>
                         </div>
                      </div>
                      <div class="row schedule-item" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="1000" style="background-image: url(front/coreui/assets/img/banner/schedule2.png);">
                         <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-around">
                               <div class="card-thumb">
                                  <img src="front/coreui/assets/img/profile2.png" alt="Profile 2">
                               </div>
                               <div class="card-description">
                                  <span class="name d-block">Thomas Smith</span>
                                  <span class="date d-block">October 2, 2023</span>
                                  <span class="time d-block">09:00 - 09:45</span>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-8">
                            <div class=" d-flex align-items-center justify-content-between">
                               <div class="card-title-area col-7">
                                  <h4 class="title">Sessions and Labs</h4>
                                  <p class="title-desc">Discover the latest trends in creativity and get inspired by creative leaders.<a href="#">Read More</a></p>
                               </div>
                               <div class="card-button col-5">
                                  <button class="custom-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                               </div>
                            </div>
                         </div>
                      </div>

                      <div class="row schedule-item" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="1000" style="background-image: url(front/coreui/assets/img/banner/schedule2.png);">
                         <div class="col-md-4">
                            <div class="d-flex align-items-center justify-content-around">
                               <div class="card-thumb">
                                  <img src="front/coreui/assets/img/profile4.png" alt="Profile 4">
                               </div>
                               <div class="card-description">
                                  <span class="name d-block">Vincent Smith</span>
                                  <span class="date d-block">October2,2023</span>
                                  <span class="time d-block">08:00 - 08:45</span>
                               </div>
                            </div>
                         </div>
                         <div class="col-md-8">
                            <div class=" d-flex align-items-center justify-content-between">
                               <div class="card-title-area col-7">
                                  <h4 class="title">Luminary Sessions</h4>
                                  <p class="title-desc">Discover the latest trends in creativity and get inspired by creative leaders.<a href="#">Read More</a></p>
                               </div>
                               <div class="card-button col-5">
                                  <button class="custom-btn2" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>

                </div> --}}
                {{-- <div class=" text-center py-3">
                   <button class="custom-btn schedule-btn">Download</button>
                </div> --}}
                <div class="dots img-moving-anim1">
                    <img src="front/coreui/assets/img/dots/dots2.png" alt="Shadow Image">
                </div>
            </div>
        </div>
        <div class="shape">
            <img src="front/coreui/assets/img/shape/2.svg" alt="Shape">
        </div>
    </section>
    <!-- schedule sec end -->


    <div class="organizing-committee">
        <h1 class="title text-center mb-4">
            Organizing Committee
        </h1>
        <div class="container mt-5">
            <hr>
        </div>
    </div>
    <!-- brand sec start -->
    {{-- <div id="sponsors" class="brand-sec">
       <div class="container">
          <div class="brand-items-wrap d-md-flex text-center justify-content-around align-items-center" data-aos="fade-up" data-aos-duration="1000">
             <div class="brand-item mb-3">
                <div class="icon">
                   <img src="front/coreui/assets/img/brand/1.png" alt="Brand Image 1"> Logoipsum
                </div>
             </div>
             <div class="brand-item mb-3">
                <div class="icon">
                   <img src="front/coreui/assets/img/brand/brand2.png" alt="Brand Image 2">
                </div>
             </div>
             <div class="brand-item mb-3">
                <div class="icon">
                   <img src="front/coreui/assets/img/brand/3.png" alt="Brand Image 3"> Logoipsum
                </div>
             </div>
             <div class="brand-item mb-3">
                <div class="icon">
                   <img src="front/coreui/assets/img/brand/brand4.png" alt="Brand Image 4">
                </div>
             </div>
             <div class="brand-item mb-3">
                <div class="icon">
                   <img src="front/coreui/assets/img/brand/5.png" alt="Brand Image 5"> Logoipsum
                </div>
             </div>
          </div>
       </div>
    </div> --}}
    <!-- brand sec end -->

    <!-- video sec start -->
    <section class="video-sec" data-src="front/coreui/assets/img/banner/home-conference-video-bg.svg" data-parallax>
        <div class="container">
            {{-- <div class="row align-items-center">
               <div class="col-md-6">
                  <div class="video-wrap">
                     <div class="video-image img-moving-anim1">
                        <img src="front/coreui/assets/img/video/video1.jpg" alt="Video Image 1">
                     </div>
                     <div class="video-play">
                        <img src="front/coreui/assets/img/video/video2.jpg" alt="Video Image 2"  data-bs-backdrop="static">
                        <a class="video-btn1 popup-video" href="#"  data-bs-toggle="modal" data-bs-target="#staticBackdrop"><span><i class="fas fa-play"></i></span></a>
                     </div>
                     <div class="dots img-moving-anim2">
                        <img src="front/coreui/assets/img/dots/dots6.png" alt="Shadow Image">
                     </div>
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="video-content-wrap">
                     <h2 class="title">
                        Be inspired by expert speakers in design, video, and more
                     </h2>
                     <p class="desc">
                        Plan your week to make the most of all the sessions and labs, Community Eventor activities, and fun ways to connect with other creatives.
                        <br><br>
                        Join us in person or attend virtually for free. Register now, in-person attendance is limited.
                     </p>
                     <div class="management d-flex">
                        <h3 class="event count-block p-lg-5 p-3"><span>07</span>Days Event</h3>
                        <h3 class="speakers count-block p-lg-5 p-3"><span>20+</span>Speakers</h3>
                     </div>
                     <div class="dots img-moving-anim3">
                        <img src="front/coreui/assets/img/dots/dots7.png" alt="Shadow Image">
                     </div>
                     <button class="custom-btn2 video-btn">Register Now</button>
                  </div>
               </div>
            </div> --}}
        </div>
    </section>
    <!-- video sec end -->

    <!-- speakers sec start -->
    <section id="speakers" class="speakers-gallery-sec position-relative">
        <div class="container">
            <div class="section-head col-xl-8 m-auto text-center mb-5">
                {{-- <span class="label">Meet Our Experts, and Speakers</span> --}}
                <h2 class="title">
                    {{-- Meet our fantastic speakers from around the globe
                    and join in with live debates & events --}}
                    {{-- Meet our fantastic speakers from around the globe and join in with Hybrid Sessions --}}
                    Meet Our Chair Persons of the Session
                </h2>
            </div>
            <div class="speakers-gallery-items-wrap">

                <div class="row">
                    <div class="owl-carousel" id="owl-speakers">
                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="1000">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/dr_aslam_1.png" alt="Gallery Image 4">
                                </div>
                                {{-- <ul class="social-icons social">
                                   <li>
                                      <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                   </li>
                                </ul> --}}
                                <div class="item-content">
                                    <h3 class="title">Professor Dr. Asad Aslam
                                        Khan<span><h6>(Sitara-i-Imtiaz)</h6></span></h3>
                                    <span
                                        class="sub">WHO Coordinator for prevention and control of blindness, Pakistan</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="1000">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/sultan_shah_1.jpg">
                                </div>

                                {{-- <ul class="social-icons social">
                                   <li>
                                      <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                   </li>
                                </ul> --}}

                                <div class="item-content">
                                    <h3 class="title">Dr. Sultan Shah</h3>
                                    <span class="sub">Professor, Department of Islamic Studies (BS-21) GC University, Lahore
                           Dean, Faculty of Languages, Islamic and Oriental Learning
                           GC University, Lahore</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="600">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/samina_1.jpg">
                                </div>
                                {{-- <ul class="social-icons social">
                                   <li>
                                      <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                   </li>
                                </ul> --}}
                                <div class="item-content">
                                    <h3 class="title">Dr. Syeda Samina Tahira</h3>
                                    <span class="sub">Associate Professor Education in University of Agriculture, Faisalabad</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="800">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/mazhar.png">
                                </div>
                                {{-- <ul class="social-icons social">
                                   <li>
                                      <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                   </li>
                                </ul> --}}
                                <div class="item-content">
                                    <h3 class="title">Prof. Dr Mazhar Hayyat</h3>
                                    <span class="sub">Chairman Department of English Language & Literature
                           Government College University Faisalabad
                           </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="1000">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/saadullah.jpeg" alt="Gallery Image 4">
                                </div>
                                {{-- <ul class="social-icons social">
                                   <li>
                                      <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                   </li>
                                </ul> --}}
                                <div class="item-content">
                                    <h3 class="title">Dr. Malik Saadullah</h3>
                                    <span class="sub">Assistant Professor Department of Pharmaceutical Chemistry, Government College University, Faisalabad, Pakistan</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="dots img-moving-anim1">
                    <img src="front/coreui/assets/img/dots/dots8.png" alt="Shadow Image">
                </div>
            </div>
            {{-- <div class="d-flex justify-content-center mt-5">
               <button class="custom-btn custom-btn2">+ Speakers</button>
            </div> --}}
        </div>
        <div class="shape">
            <img src="front/coreui/assets/img/shape/3.svg" alt="">
        </div>
    </section>
    <!-- speakers sec end -->
    <div class="container">
        <hr>
    </div>

    <!-- speakers sec start -->
    <section id="speakers" class="speakers-gallery-sec position-relative">
        <div class="container">
            <div class="section-head col-xl-8 m-auto text-center mb-5">
                {{-- <span class="label">Meet Our Experts, and Speakers</span> --}}
                <h2 class="title">
                    {{-- Meet our fantastic speakers from around the globe
                    and join in with live debates & events --}}
                    {{-- Meet our fantastic speakers from around the globe and join in with Hybrid Sessions --}}
                    Speakers
                </h2>
            </div>
            <div class="speakers-gallery-items-wrap">

                <div class="row">
                    <div class="owl-carousel" id="owl-speakers-main">
                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="1000">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/dr_laila.jpeg">
                                </div>

                                {{-- <ul class="social-icons social">
                                   <li>
                                      <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                   </li>
                                </ul> --}}

                                <div class="item-content">
                                    <h3 class="title">Dr Laila Murtadha Baqer Mohebi</h3>
                                    <span class="sub">Assistant Professor,
                           Zayed University, Dubai, United Arab Emirates
                           Department of Education
                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="1000">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/sidra_sarwat.jpeg">
                                </div>

                                {{-- <ul class="social-icons social">
                                   <li>
                                      <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                   </li>
                                   <li>
                                      <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                   </li>
                                </ul> --}}

                                <div class="item-content">
                                    <h3 class="title">Sidra Sarwat</h3>
                                    <span class="sub">Assistant Lecturer,
                           School of Optometry and Vision Science, UNSW, Australia
                        </span>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-12">
                           <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1000">
                              <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                 <img src="front/coreui/assets/img/conference/dr_aslam_1.png">
                              </div>

                              <div class="item-content">
                                 <h3 class="title">Professor Dr. Asad Aslam Khan</h3>
                                 <span class="sub">(Sitara-i-Imtiaz) Principal, College of Ophthalmology and  Allied  Vision  Sciences  (COAVS), King  Edward  Medical  University (KEMU), Lahore, Pakistan
                                 </span>
                              </div>
                           </div>
                        </div> --}}

                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="1000">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/dilshad_1.jpg">
                                </div>

                                <div class="item-content">
                                    <h3 class="title">Prof. Dr. Rana Muhammad Dilshad</h3>
                                    <span class="sub">Chairman, Department of Education, Bahauddin Zakariya University Multan Pakistan
                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="1000">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/fateha.jpeg">
                                </div>

                                <div class="item-content">
                                    <h3 class="title">Dr. Fateha Mobeen</h3>
                                    <span class="sub">Deputy Chief Scientist, NIBGE, PAEC
                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="1000">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/faiz_1.jpg">
                                </div>

                                <div class="item-content">
                                    <h3 class="title">Dr Faiz Joya</h3>
                                    <span class="sub">Associate Professor, CABB
                        University of Agriculture, Faisalabad
                        </span>
                                </div>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="1000">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/majid_aziz.jpg">
                                </div>

                                <div class="item-content">
                                    <h3 class="title">Dr. Muhammad Majid Aziz</h3>
                                    <span class="sub">Assistant Professor at Xi'an Jiaotong University
                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="1000">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/s_mehmood.jpeg">
                                </div>

                                <div class="item-content">
                                    <h3 class="title">Prof. Dr. Shahid Mahmood Baig</h3>
                                    <span class="sub">Chairman PSF, H.I, S.I, FPAS
                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="1000">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/afraz.jpeg">
                                </div>

                                <div class="item-content">
                                    <h3 class="title">Dr. Afraz Gillani </h3>
                                    <span class="sub">Assistant professor,
                           Department of Public Administration GCUF
                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="1000">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/aashir.jpg">
                                </div>

                                <div class="item-content">
                                    <h3 class="title">Dr Aashir Waleed</h3>
                                    <span class="sub">Assistant Professor, Department Electrical Engineering UET, Faisalabad Campus
                        </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="speakers-gallery-item" data-aos="fade-up" data-aos-easing="linear"
                                 data-aos-duration="1000">
                                <div class="speakers-gallery-item-thumb overflow-hidden position-relative">
                                    <img src="front/coreui/assets/img/conference/samina_1.jpg">
                                </div>

                                <div class="item-content">
                                    <h3 class="title">Dr. Syeda Samina Tahira</h3>
                                    <span class="sub">Associate Professor Education in University of Agriculture, Faisalabad
                        </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="dots img-moving-anim1">
                    <img src="front/coreui/assets/img/dots/dots8.png" alt="Shadow Image">
                </div>
            </div>
            {{-- <div class="d-flex justify-content-center mt-5">
               <button class="custom-btn custom-btn2">+ Speakers</button>
            </div> --}}
        </div>
        <div class="shape">
            <img src="front/coreui/assets/img/shape/3.svg" alt="">
        </div>
    </section>
    <!-- speakers sec end -->
    <div class="container">
        <hr>
    </div>
    <!-- cta sec start-->
    <section class="cta-sec">
        <div class="container">
            <div class="cta-content-wrap text-center" data-aos="fade-right" data-aos-duration="1000">
                <h2 class="cta-title  m-auto mb-4 mx-5">
                    Join Us with Empowering Minds, Igniting Future, Exploring Challenges and Opportunities in Advanced
                    STEAM Education with in Real World Scenarios
                </h2>
                {{-- <p class="desc mb-5">
                   Join us for Eventor Collaborative: Virtual Sessions on October 2023
                </p>
                <form action="#">
                   <input type="text" name="email" class="form-control" placeholder="Enter Your Email">
                   <button class="custom-btn custom-btn2">Submit</button>
                </form> --}}
                <div class="dots">
                    <img src="front/coreui/assets/img/dots/dots9.png" alt="Shadow Image"
                         class="cta-dots-1 img-moving-anim1">
                    <img src="front/coreui/assets/img/dots/dots10.png" alt="Shadow Image"
                         class="cta-dots-2 img-moving-anim2">
                </div>
            </div>
        </div>
        <div class="shape">
            <img src="front/coreui/assets/img/shape/4.svg" alt="Shape">
        </div>
    </section>
    <!-- cta sec end-->

    <!-- review sec start -->
    {{-- <section class="review-sec" style="background-image: url(front/coreui/assets/img/banner/review.png);">
       <div class="container" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1000">
          <h2 class="review-title col-10 col-md-10 col-lg-8 col-xl-7 my-5">
             Join 3,500+ developers, engineers, designers and executives
          </h2>
          <div class="review-cards-wrap">
             <div class="review-card-items-wrap">
                <div class="review-card-item">
                   <p class="card-desc">
                      “Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”
                   </p>
                   <div class="profile">
                      <div class="thumb">
                         <img src="front/coreui/assets/img/review/img.png" alt="Review Image">
                      </div>
                      <div class="content">
                         <h5 class="name">Martha Smith</h5>
                         <span>San Francisco</span>
                      </div>
                   </div>
                   <ul class="rating-star list-unstyled d-flex">
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                   </ul>
                   <span>5/5 Rating</span>
                </div>
                <div class="review-card-item ">
                   <p class="card-desc">
                      “Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”
                   </p>
                   <div class="profile">
                      <div class="thumb">
                         <img src="front/coreui/assets/img/review/img2.png" alt="Review Image">
                      </div>
                      <div class="content">
                         <h5 class="name">Martha Smith</h5>
                         <span>San Francisco</span>
                      </div>
                   </div>
                   <ul class="rating-star list-unstyled d-flex">
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                   </ul>
                   <span>5/5 Rating</span>
                </div>
                <div class="review-card-item">
                   <p class="card-desc">
                      “Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”
                   </p>
                   <div class="profile">
                      <div class="thumb">
                         <img src="front/coreui/assets/img/review/img3.png" alt="Review Image">
                      </div>
                      <div class="content">
                         <h5 class="name">Martha Smith</h5>
                         <span>San Francisco</span>
                      </div>
                   </div>
                   <ul class="rating-star list-unstyled d-flex">
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                   </ul>
                   <span>5/5 Rating</span>
                </div>
                <div class="review-card-item">
                   <p class="card-desc">
                      “Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”
                   </p>
                   <div class="profile">
                      <div class="thumb">
                         <img src="front/coreui/assets/img/review/img2.png" alt="Review Image">
                      </div>
                      <div class="content">
                         <h5 class="name">Martha Smith</h5>
                         <span>San Francisco</span>
                      </div>
                   </div>
                   <ul class="rating-star list-unstyled d-flex">
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                   </ul>
                   <span>5/5 Rating</span>
                </div>
                <div class="review-card-item">
                   <p class="card-desc">
                      “Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”
                   </p>
                   <div class="profile">
                      <div class="thumb">
                         <img src="front/coreui/assets/img/review/img3.png" alt="Review Image">
                      </div>
                      <div class="content">
                         <h5 class="name">Martha Smith</h5>
                         <span>San Francisco</span>
                      </div>
                   </div>
                   <ul class="rating-star list-unstyled d-flex">
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                   </ul>
                   <span>5/5 Rating</span>
                </div>
                <div class="review-card-item">
                   <p class="card-desc">
                      “Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”
                   </p>
                   <div class="profile">
                      <div class="thumb">
                         <img src="front/coreui/assets/img/review/img.png" alt="Review Image">
                      </div>
                      <div class="content">
                         <h5 class="name">Martha Smith</h5>
                         <span>San Francisco</span>
                      </div>
                   </div>
                   <ul class="rating-star list-unstyled d-flex">
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                   </ul>
                   <span>5/5 Rating</span>
                </div>
                <div class="review-card-item">
                   <p class="card-desc">
                      “Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”
                   </p>
                   <div class="profile">
                      <div class="thumb">
                         <img src="front/coreui/assets/img/review/img2.png" alt="Review Image">
                      </div>
                      <div class="content">
                         <h5 class="name">Martha Smith</h5>
                         <span>San Francisco</span>
                      </div>
                   </div>
                   <ul class="rating-star list-unstyled d-flex">
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                   </ul>
                   <span>5/5 Rating</span>
                </div>
                <div class="review-card-item">
                   <p class="card-desc">
                      “Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”
                   </p>
                   <div class="profile">
                      <div class="thumb">
                         <img src="front/coreui/assets/img/review/img3.png" alt="Review Image">
                      </div>
                      <div class="content">
                         <h5 class="name">Martha Smith</h5>
                         <span>San Francisco</span>
                      </div>
                   </div>
                   <ul class="rating-star list-unstyled d-flex">
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                   </ul>
                   <span>5/5 Rating</span>
                </div>
                <div class="review-card-item">
                   <p class="card-desc">
                      “Thank you for running the event so smoothly – I had a great time, not only presenting, but also watching other sessions and interacting with attendees.”
                   </p>
                   <div class="profile">
                      <div class="thumb">
                         <img src="front/coreui/assets/img/review/img.png" alt="Review Image">
                      </div>
                      <div class="content">
                         <h5 class="name">Martha Smith</h5>
                         <span>San Francisco</span>
                      </div>
                   </div>
                   <ul class="rating-star list-unstyled d-flex">
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                      <li class="active"><i class="fas fa-star"></i></li>
                   </ul>
                   <span>5/5 Rating</span>
                </div>
             </div>
             <div class="carousel-nav">
                <button type="button" class="main-left-arrow"><i class="fa-solid fa-chevron-left"></i></button>
                <button type="button" class="main-right-arrow"><i class="fa-solid fa-chevron-right"></i></button>
             </div>
             <div class="dots">
                <img src="front/coreui/assets/img/dots/dots11.png" alt="Shadow Image">
             </div>
          </div>
       </div>
    </section> --}}
    <!-- review sec end -->

    <!-- pricing sec start -->
    {{-- <section id="pricing" class="pricing-sec">
       <div class="container">
          <div class="section-head col-xl-8 m-auto text-center px-5">
             <span class="label">Choose The Best Ticket For You</span>
             <h2 class="title mb-4">
                Event price list 2023. Buy your tickets now
                for Eventor Conference
             </h2>
             <p class="desc mb-5">
                Eventor is a 7-day conference with an extra day of workshops. There’s a mix of short
                45 minute talks and longer keynotes, giving you insights in a wide range of topics.
             </p>
          </div>
          <div class="pricing-cart-wrap">
             <div class="row row-cols-1 row-cols-lg-3 g-4">
                <div class="col col-md-6 col-lg-4">
                   <div class="card  h-100" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
                      <div class="card-body">
                         <span class="card-lable"><i class="fa-sharp fa-solid fa-circle"></i>Out of Pocket Discount</span>
                         <h3 class="price-pacage">$190 <span class="regular-price">/ regular price</span>
                         </h3>
                         <ul>
                            <li><a href="#"><i class="fa-solid fa-check"></i>Regular price: $190 until Sept 20</a></li>
                            <li><a href="#"><i class="fa-solid fa-check"></i>Last minute price: $490 until the end</a></li>
                         </ul>
                         <div class="card-btn">
                            <button class="custom-btn custom-btn2 mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                            <span class="card-footer-label">When you don't need a VAT invoice</span>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="col col-md-6 col-lg-4">
                   <div class="card h-100" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
                      <div class="card-body">
                         <span class="card-lable"><i class="fa-sharp fa-solid fa-circle"></i>Professional Discount</span>
                         <h3 class="price-pacage">$290 <span class="regular-price">/ regular price</span>
                         </h3>
                         <ul>
                            <li><a href="#"><i class="fa-solid fa-check"></i>Regular price: $190 until Sept 20</a></li>
                            <li><a href="#"><i class="fa-solid fa-check"></i>Last minute price: $490 until the end</a></li>
                         </ul>
                         <div class="card-btn">
                            <button class="custom-btn custom-btn2 mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                            <span class="card-footer-label">When you don't need a VAT invoice</span>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="col col-md-6 col-lg-4">
                   <div class="card h-100" data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
                      <div class="card-body">
                         <span class="card-lable"><i class="fa-sharp fa-solid fa-circle"></i>Company Discount</span>
                         <h3 class="price-pacage">$390 <span class="regular-price">/ regular price</span>
                         </h3>
                         <ul>
                            <li><a href="#"><i class="fa-solid fa-check"></i>Regular price: $190 until Sept 20</a></li>
                            <li><a href="#"><i class="fa-solid fa-check"></i>Last minute price: $490 until the end</a></li>
                         </ul>
                         <div class="card-btn">
                            <button class="custom-btn custom-btn2 mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Buy Tickets</button>
                            <span class="card-footer-label">When you don't need a VAT invoice</span>
                         </div>

                      </div>
                   </div>
                </div>
             </div>
             <div class="dots img-moving-anim1">
                <img src="front/coreui/assets/img/dots/dots12.png" alt="Shadow Image">
             </div>
          </div>
       </div>
       <div class="shape">
          <img src="front/coreui/assets/img/shape/5.svg" alt="Shape">
       </div>
    </section> --}}
    <!-- pricing sec end -->
    {{-- <div class="container">
       <hr>
    </div> --}}
    <!-- faq sec start -->
    {{-- <section class="faq-sec">
       <div class="container">
          <div class="row align-items-end">
             <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-duration="1000">
                <div class="title-area">
                   <h2 class="title mb-3">
                      Frequently asked questions,
                      about the conference
                   </h2>
                   <p class="desc mb-5">
                      Eventor Collaborative, brought to you by IBM, is where the most inventive and forward-thinking nonprofit leaders come together
                      to discover emerging trends in fundraising and technology.
                   </p>

                   <button class="faq-btn custom-btn">Learn More</button>
                </div>
             </div>
             <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                <div class="question-area">
                   <div class="accordion" id="accordionExample">
                      <div class="accordion-item">
                         <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button"          data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                               Is this Eventor Conference 2023 for me?
                            </button>
                         </h2>
                         <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               Are you a developer interested in building web applications and at the same time thinking about multiple parts of the stack needed to build them? Then this conference is for you. Many of the sessions either touch a specific concept or go about multiple parts of the stack.
                            </div>
                         </div>
                      </div>
                      <div class="accordion-item">
                         <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                               Can I change the attendee name on the ticket?
                            </button>
                         </h2>
                         <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               Are you a developer interested in building web applications and at the same time thinking about multiple parts of the stack needed to build them? Then this conference is for you. Many of the sessions either touch a specific concept or go about multiple parts of the stack.
                            </div>
                         </div>
                      </div>
                      <div class="accordion-item">
                         <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                               Can I change the attendee name on the ticket?
                            </button>
                         </h2>
                         <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               Are you a developer interested in building web applications and at the same time thinking about multiple parts of the stack needed to build them? Then this conference is for you. Many of the sessions either touch a specific concept or go about multiple parts of the stack.
                            </div>
                         </div>
                      </div>
                      <div class="accordion-item">
                         <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                               What is included in the ticket prices?
                            </button>
                         </h2>
                         <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                               Are you a developer interested in building web applications and at the same time thinking about multiple parts of the stack needed to build them? Then this conference is for you. Many of the sessions either touch a specific concept or go about multiple parts of the stack.
                            </div>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </section> --}}
    <!-- faq sec end -->
    {{-- <div class="container">
       <hr>
    </div> --}}
    <!-- gallery sec start -->
    {{-- <section class="gallery-sec" data-aos="fade-up" data-aos-duration="1200">
       <div class="container-fluid">
       <div class="col-xl-8 section-head text-center m-auto mb-5">
          <span class="label">Contact The Eventor Sales Team</span>
          <h2 class="title ">
             Relive the best moments from the Conference 2022
             through video and photos in our gallery
          </h2>
       </div>

       <div class="image-gallery-wrap zoom-gallery d-flex align-items-center">

          <div class="row g-4">
             <div class="col-md-6 col-lg-4">
                <div class="image-gallery-item" data-aos="fade-up" data-aos-duration="1000">
                   <a class="item-thumb" href="front/coreui/assets/img/gallery/img-gallery1.png">
                      <img src="front/coreui/assets/img/gallery/img-gallery1.png" alt="Image Gallery 1">
                      <span class="view">VIEW</span>
                   </a>

                </div>
             </div>
             <div class="col-md-6 col-lg-4">
                <div class="image-gallery-item" data-aos="fade-up" data-aos-duration="800">
                   <a class="item-thumb" href="front/coreui/assets/img/gallery/img-gallery2.png">
                      <img src="front/coreui/assets/img/gallery/img-gallery2.png" alt="Image Gallery 2">
                      <span class="view">VIEW</span>
                   </a>
                </div>
             </div>
             <div class="col-md-6 col-lg-4">
                <div class="image-gallery-item" data-aos="fade-up" data-aos-duration="600">
                   <a class="item-thumb" href="front/coreui/assets/img/gallery/img-gallery3.png">
                      <img src="front/coreui/assets/img/gallery/img-gallery3.png" alt="Image Gallery 3">
                      <span class="view">VIEW</span>
                   </a>
                </div>
             </div>
          </div>
       </div>
       <div class="shape">
          <img src="front/coreui/assets/img/shape/6.svg" alt="Shape">
       </div>
    </div>
    </section> --}}
    <!-- gallery sec end -->

    <!-- contact sec start -->
    {{-- <section class="contact-sec" data-aos="zoom-in" data-aos-duration="1000">
       <div class="container">
          <div class="col-xl-5 section-head text-center m-auto mb-5">
             <span class="label">Contact The Eventor Sales Team</span>
             <h2 class="title mx-2">
                We are here when you need us.
                Need immediate assistance?
             </h2>
          </div>
          <div class="contact-wrap bg-none p-0">
             <div class="dots">
                <img src="front/coreui/assets/img/dots/dots13.png" alt="Shadow Image" class="contact-dots-1 img-moving-anim2">
             </div>
             <div class="contact-wrap row py-4 px-3 contact align-items-center m-0">
                <div class="col-lg-4">
                   <div class="contact-thumb-wrap" style="background-image: url(front/coreui/assets/img/banner/contact-bg.png);">
                      <div class="contact-content">
                         <h5 class="title text-white">Contact Us</h5>
                         <p class="desc">
                            Get in touch and let us know how
                            we can help.
                         </p>
                         <div class="info">
                            <a class="icon d-block mb-3">
                               <img src="front/coreui/assets/img/icon/mail1.svg" alt="Mail" style="color: #fff;"> conference@eventor.com
                            </a>
                            <a class="location d-block mb-3">
                               <img src="front/coreui/assets/img/icon/map-pin2.svg" alt="Map"> conference@eventor.com
                            </a>
                            <a class="phone d-block">
                               <img src="front/coreui/assets/img/icon/phone3.svg" alt="Phone">
                               conference@eventor.com
                            </a>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="col-lg-8 mt-4 mt-lg-0">
                   <form class="contact-form">
                      <div class="row gy-3">
                         <div class="col-lg-6">
                            <label for="exampleFormControlInput1" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Your First Name" required>
                         </div>
                         <div class="col-lg-6">
                            <label for="exampleFormControlInput2" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="exampleFormControlInput2" placeholder="Your Last Name" required>
                         </div>
                         <div class="col-lg-6">
                            <label for="exampleFormControlInput3" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleFormControlInput3" placeholder="Enter Email" required>
                         </div>
                         <div class="col-lg-6">
                            <label for="exampleFormControlInput4" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="exampleFormControlInput4" placeholder="Enter Subject" required>
                         </div>
                      </div>
                      <div class="mb-3">

                      </div>
                      <div class="text-area col-12 mb-3">
                         <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
                         <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter Your Comment" ></textarea>
                      </div>
                      <button class=" custom-btn2" type="submit">Submit</button>
                   </form>
                </div>
             </div>

             <div class="dots">
                <img src="front/coreui/assets/img/dots/dots14.png" alt="Shadow Image" class="contact-dots-2 img-moving-anim3">
             </div>
          </div>
       </div>
    </section> --}}
    <!-- contact sec end -->
    {{-- <div class="container">
       <hr>
    </div> --}}

    <!-- blog sec start -->
    {{-- <section class="blog-sec" data-aos="fade-up" data-aos-duration="1000">
       <div class="container">
          <div class="section-head d-flex justify-content-between">
             <h2 class="blog-title">
                Conference news and event industry trends
             </h2>
             <button class="blog-btn custom-btn">Our Blog</button>
          </div>
          <div class="blog-cards-wrap zoom-gallery">
             <div class="dots img-moving-anim1">
                <img src="front/coreui/assets/img/dots/dots15.png" alt="Shadow Image" class="blog-dots-1">
             </div>
             <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="800">
                   <div class="card h-100 border-0">
                      <a class="card-thumb item-thumb overflow-hidden" href="front/coreui/assets/img/blog/1.jpg">
                         <img src="front/coreui/assets/img/blog/1.jpg" class="card-img-top" alt="image-not-found">
                         <span class="view">VIEW</span>
                      </a>
                      <div class="card-body">
                         <span class="label">Conference 2023</span>
                         <h5 class="card-title">
                            Event Technology Awards coveted People’s Choice Award voting open
                         </h5>
                         <p class="card-desc">Voting has opened today for #EventProfs to choose their favourite #EventTech supplier to win this year’s 10th anniversary edition of the People’s Choice Award.</p>
                         <a class="blog-btn">Read More</a>
                      </div>
                   </div>
                </div>
                <div class="col col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="600">
                   <div class="card h-100 border-0">
                      <a class="card-thumb item-thumb overflow-hidden" href="front/coreui/assets/img/blog/2.jpg">
                         <img src="front/coreui/assets/img/blog/2.jpg" class="card-img-top" alt="image-not-found">
                         <span class="view">VIEW</span>
                      </a>
                      <div class="card-body">
                         <span class="label">Conference 2023</span>
                         <h5 class="card-title">
                            Events Industry Council announces Recipients of 2022 Global Awards
                         </h5>
                         <p class="card-desc">The Events Industry Council (EIC), the global voice of the business events industry,has today announced the Recipients of its annual Global Awards.</p>
                         <a class="blog-btn">Read More</a>
                      </div>
                   </div>
                </div>
                <div class="col col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="400">
                   <div class="card h-100 border-0 position-relative">
                      <a class="card-thumb item-thumb overflow-hidden" href="front/coreui/assets/img/blog/3.jpg">
                         <img src="front/coreui/assets/img/blog/3.jpg" class="card-img-top" alt="image-not-found">
                         <span class="view">VIEW</span>
                      </a>
                      <div class="card-body">
                         <span class="label">Conference 2023</span>
                         <h5 class="card-title">
                            The Business of Events confirms ICC Wales as latest official partner
                         </h5>
                         <p class="card-desc">The Business of Events has confirmed ICC Wales as its latest official partner for its 2022 programme.  ICC Wales joins the Department for Digital, Culture, Media & Sport.</p>
                         <a class="blog-btn">Read More</a>
                      </div>
                      <img src="front/coreui/assets/img/dots/dots16.png" alt="Shadow Image" class="blog-dots-2 img-moving-anim1">
                   </div>
                </div>
             </div>

          </div>
       </div>
       <div class="shape">
          <img src="front/coreui/assets/img/shape/7.svg" alt="Shape">
       </div>
    </section> --}}
    <!-- blog sec end -->
    <!-- Modal -->
    {{-- <div class="modal fade popup-modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog modal-lg popup-dialogue modal-dialog-centered">
          <div class="modal-content popup-content p-4 bg-white">
             <button type="button" class="btn btn-secondary  ms-auto" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>

             <div class="modal-body popup-body">
                <iframe width="100%" height="400" src="https://www.youtube.com/embed/1dtzSRlfBDk" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
             </div>

          </div>
       </div>
    </div> --}}

    <!-- Button trigger modal -->

    <!-- Modal 2 -->
    {{-- <div class="modal  popup-box fade" id="exampleModal" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog popup-box-dialog modal-dialog-centered">
          <div class="modal-content popup-box-content">
             <div class="popup-card" style="width:100%">
                <button type="button" class="btn popup2-btn  ms-auto" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
                <img src="front/coreui/assets/img/popup.png" class="card-img-top" alt="popup-bg">
                <div class="card-body popup-card-body">
                   <div class="popup-title-area">
                      <p class="popup-sub">October 2, 2023</p>
                      <h5 class="card-title popup-title">Virtual sessions. Eventor Live@MAX</h5>
                   </div>
                   <a href="#" class="btn popup-play" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="fa-solid fa-play"></i></a>
                </div>
                <form action="#" class="popup-form">
                   <div class="row gy-3 mb-3">
                      <div class="col-lg-6">
                         <label for="exampleFormControlInput5" class="form-label">Full Name</label>
                         <input type="text" class="form-control" id="exampleFormControlInput5" placeholder="Your Full Name" required>
                      </div>
                      <div class="col-lg-6">
                         <label for="exampleFormControlInput6" class="form-label">Email</label>
                         <input type="email" class="form-control" id="exampleFormControlInput6" placeholder="Enter Email" required>
                      </div>
                      <div class="col-lg-6">
                         <label for="exampleFormControlInput7" class="form-label">Phone</label>
                         <input type="text" class="form-control" id="exampleFormControlInput7" placeholder="Enter Phone" required>
                      </div>
                      <div class="col-lg-6">
                         <label for="exampleFormControlInput8" class="form-label">Conference</label>
                         <select class="form-control bg-black-50" name="" id="">
                            <option value="">Early Bird ($10)</option>
                            <option value="">Regular ($20)</option>
                            <option value="">VIP ($50)</option>
                         </select>
                      </div>
                   </div>
                   <button class="custom-btn2">Buy Now</button>
                </form>
             </div>
          </div>
       </div>
    </div> --}}
@endsection
