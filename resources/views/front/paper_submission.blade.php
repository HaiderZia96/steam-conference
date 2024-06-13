@section('title', 'Paper Submission Dates | TUF STEAM Education')
@section('description', 'Explore TUF STEAM Education\'s paper submission dates. Elevate your research journey with precision and deadlines that align seamlessly with academic excellence.')
@section('keywords', 'Paper Submission Dates')
@extends('front.layouts.app')
@section('content')
<div class="section-submission-date" style="background-color:#f8f9fa ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="left-content">
                    <h1 class="mb-4">Paper Submission Dates:</h1>
                    <div class="table-responsive">
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Event</th>
                                <th scope="col">Last Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Full-Paper Submission</td>
                                <td>November 1<sup>st</sup>, 2023</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Full-Paper Acceptance Notification</td>
                                <td>November 15<sup>th</sup>, 2023</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Registration Last Date</td>
                                <td>November 20<sup>th</sup>, 2023</td>
                            </tr>

                        </tbody>
                    </table>  </div>

                    {{-- <h2 class="mb-2">Science</h2> --}}

                </div>

            </div>
        </div>
    </div>


    {{-- Paper Submission Tabs --}}

       <!-- schedule sec start -->
       <div class="container schedule-sec-paper">
        <div class="row g-0">
           <div class="col-12">
        {{-- <div class="section-head text-center col-xl-8 m-auto mb-5">
           <span class="label mb-4">Our Conference Schedule 2023</span>
           <h2 class="title">
              An environment where participants and experts
              can exchange ideas and experiences
           </h2>
        </div> --}}
        <div class="left-content ">
        <h1 class="mb-4 ms-2">Themes for Paper Submissions:</h1></div>
        <p class="ms-2" style="font-family: Outfit-Regular;">Themes for Paper Submissions (but not limited to):</p>
        <div class="schedule-content-wrap px-0">
           <ul class="nav nav-pills schedule-nav-tab mb-5" id="pills-tab" role="tablist">
              <li class="nav-item schedule-nav-item" role="presentation">
                 <button class="nav-link active" id="pills-day-1-tab" data-bs-toggle="pill" data-bs-target="#pills-day-1" type="button" role="tab" aria-controls="pills-day-1" aria-selected="true">Science</button>
              </li>
              <li class="nav-item schedule-nav-item" role="presentation">
                 <button class="nav-link" id="pills-day-2-tab" data-bs-toggle="pill" data-bs-target="#pills-day-2" type="button" role="tab" aria-controls="pills-day-2" aria-selected="false">Technology</button>
              </li>
              <li class="nav-item schedule-nav-item" role="presentation">
                 <button class="nav-link" id="pills-day-3-tab" data-bs-toggle="pill" data-bs-target="#pills-day-3" type="button" role="tab" aria-controls="pills-day-3" aria-selected="false">Engineering</button>
              </li>
              <li class="nav-item schedule-nav-item" role="presentation">
                 <button class="nav-link" id="pills-day-4-tab" data-bs-toggle="pill" data-bs-target="#pills-day-4" type="button" role="tab" aria-controls="pills-day-4" aria-selected="false">Arts</button>
              </li>
              <li class="nav-item schedule-nav-item" role="presentation">
                 <button class="nav-link" id="pills-day-5-tab" data-bs-toggle="pill" data-bs-target="#pills-day-5" type="button" role="tab" aria-controls="pills-day-5" aria-selected="false">Mathematics</button>
              </li>

           </ul>
           <div class="container" style="background-color:#f8f9fa">
              <hr>
           </div>
           <div class="tab-content schedule-tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-day-1" role="tabpanel" aria-labelledby="pills-day-1-tab" tabindex="0">

                 <section>
                    <div class="container" >
                        <div class="section-science col-xl-12 m-2 " >
                           {{-- <span class="label">Welcome to International Conference 2023</span> --}}
                           <h4 class="mb-2">Department of Pharmacy</h4>
                    <ul style="list-style-type: decimal">
                        <li>Natural Products and Traditional Medicine:</li>
                        <ul style="list-style-type: disc">
                            <li>Research on natural compounds as potential pharmaceuticals</li>
                            <li>Integration of traditional medicine with modern pharmaceuticals</li>
                            <li>Ethno pharmacology and herbal medicine studies</li>
                        </ul>
                        <li>Pharmacology and Toxicology:</li>
                        <ul style="list-style-type: disc">
                            <li>Preclinical and clinical pharmacology studies</li>
                            <li>Drug-drug interactions and adverse drug reactions</li>
                            <li>Toxicology assessments and safety studies</li>
                        </ul>
                        <li>Pharmaceutical Formulation and Delivery:</li>
                        <ul style="list-style-type: disc">
                            <li>Novel drug delivery systems (e.g. nanoparticles, liposomes)</li>
                            <li>Controlled release formulations</li>
                            <li>Biopharmaceutical approaches to enhance drug bioavailability</li>
                            <li>Formulation stability and shelf life studies</li>
                        </ul>
                    </ul>
                    <h4 class="mb-2">Department of Optometry</h4>
                    <ul style="list-style-type: disc">
                        <li>Innovation in health and wellness; challenges and opportunities</li>
                        <li>Shaping the future in healthcare; challenges and opportunities</li>
                    </ul>
                    <h4 class="mb-2">Department of Physical Therapy</h4>
                    <h4 class="mb-2">Department of Bio Technology</h4>
                    <ul style="list-style-type: disc">
                        <li>Industrial Biotechnology</li>
                        <li>Environmental Biotechnology</li>
                        <li>Medical Biotechnology</li>
                    </ul>

                        </div>
                     </div></section>
              </div>
             <div class="tab-pane fade" id="pills-day-2" role="tabpanel" aria-labelledby="pills-day-2-tab" tabindex="0">
              <section>
              <div class="container">
                <div class="section-technology col-xl-12 m-2 " >
                    <h4 class="mb-2">Department of Computer Sciences</h4>
                    <ul style="list-style-type: decimal">
                     <li>Artificial Intelligence (AI):</li>
                     <ul style="list-style-type: disc">
                         <li>Machine Learning</li>
                         <li>Natural Language Processing</li>
                         <li>Computer Vision</li>
                         <li>Robotics</li>
                         <li>AI Ethics</li>
                     </ul>
                     <li>Computer Vision and Pattern Recognition:</li>
                     <ul style="list-style-type: disc">
                         <li>Image Processing</li>
                         <li>Object Recognition</li>
                         <li>Computer Graphics</li>
                     </ul>
                     <li>Data Science and Big Data:</li>
                     <ul style="list-style-type: disc">
                         <li>Data Mining</li>
                         <li>Data Analytics</li>
                         <li>Big Data Technologies</li>
                         <li>Data Visualization</li>
                     </ul>
                     <li>Human-Computer Interaction (HCI):</li>
                     <ul style="list-style-type: disc">
                         <li>User Experience (UX) Design</li>
                         <li>Usability</li>
                         <li>Interaction Design</li>
                     </ul>
                     <li>Computer Networks and Communications:</li>
                     <ul style="list-style-type: disc">
                         <li>Network Protocols</li>
                         <li>Wireless Networks</li>
                         <li>Internet of Things (IoT)</li>
                     </ul>
                     <li>Software Engineering:</li>
                     <ul style="list-style-type: disc">
                         <li>Software Development Methodologies</li>
                         <li>Software Testing</li>
                         <li>Agile and DevOps Practices</li>
                     </ul>
                     <li>Cybersecurity:</li>
                     <ul style="list-style-type: disc">
                         <li>Network Security</li>
                         <li>Cryptography</li>
                         <li>Cyber Threat Intelligence</li>
                         <li>Cryptocurrency system</li>
                         <li>Block chain</li>
                     </ul>
                     <li>Databases and Information Systems:</li>
                     <ul style="list-style-type: disc">
                         <li>Database Management</li>
                         <li>Information Retrieval</li>
                         <li>Data Warehousing</li>
                     </ul>
                     <li>Algorithms and Data Structures:</li>
                     <ul style="list-style-type: disc">
                         <li>Algorithm Design and Analysis</li>
                         <li>Computational Complexity</li>
                         <li>Graph Theory</li>
                     </ul>
                     <li>Computer Architecture and Systems:</li>
                     <ul style="list-style-type: disc">
                         <li>Microprocessors</li>
                         <li>Distributed Systems</li>
                         <li>Cloud Computing</li>
                     </ul>
                     <li>Computer Graphics and Visualization:</li>
                     <ul style="list-style-type: disc">
                         <li>3D Rendering</li>
                         <li>Virtual Reality (VR)</li>
                         <li>Augmented Reality (AR)</li>
                     </ul>
                     <li>Bioinformatics:</li>
                     <ul style="list-style-type: disc">
                         <li>Computational Biology</li>
                         <li>Genomics</li>
                         <li>Proteomics</li>
                     </ul>
                     <li>Theoretical Computer Science:</li>
                     <ul style="list-style-type: disc">
                         <li>Automata Theory</li>
                         <li>Formal Languages</li>
                         <li>Computability Theory</li>
                     </ul>
                     <li>Quantum Computing:</li>
                     <ul style="list-style-type: disc">
                         <li>Quantum Algorithms</li>
                         <li>Quantum Cryptography</li>
                         <li>Quantum Hardware</li>
                     </ul>
                     <li>Educational Technology:</li>
                     <ul style="list-style-type: disc">
                         <li>E-Learning</li>
                         <li>Online Education</li>
                         <li>Learning Analytics</li>
                     </ul>
                 </ul>
              </div>

              </section>


           </div>
           <div class="tab-pane fade" id="pills-day-3" role="tabpanel" aria-labelledby="pills-day-3-tab" tabindex="0">
            <section>
            <div class="container">
              <div class="section-engineering col-xl-12 m-2 " >
                  <h4 class="mb-2">Department of Electrical and Civil Engineering</h4>
                  <ul style="list-style-type: disc">
                    <li>Energy Forecasting, Peer-to-peer Energy Trading and Transactive Energy Management</li>
                    <li>Planning, Operation and Control of Energy Internets</li>
                    <li>Grid Planning, Operation and Management</li>
                    <li>Smart Homes, Buildings and Cities and Cyber Security</li>
                    <li>Smart Condition Monitoring and Fault Diagnosis Techniques</li>
                    <li>Active Distribution Networks and DC Distribution Networks</li>
                    <li>Integrated Energy System</li>
                    <li>HVDC Transmission</li>
                    <li>Microgrids, Standalone Power Systems and Virtual Power Plants</li>
                    <li>FACTs</li>
                    <li>Renewable Generation and Distributed Energy Resources</li>
                    <li>Computational Intelligence, Big Data, ICT and Blockchain Applications in Smart Grids</li>
                    <li>Grid Resiliency, Security, Reliability, Stability and Protection</li>
                    <li>IoT Enabled Energy Systems</li>
                    <li>High Voltage Technology</li>
                    <li>Key Equipment in Energy Internet</li>
                  </ul>
            </div>

            </section>


         </div>
         <div class="tab-pane fade" id="pills-day-4" role="tabpanel" aria-labelledby="pills-day-4-tab" tabindex="0">
            <section>
            <div class="container">
              <div class="section-arts col-xl-12 m-2 " >
                  <h4 class="mb-2">Department of English</h4>
                  <ul style="list-style-type: disc">
                     <li>Post-Colonial Studies</li>
                     <li>Post 9/11 Literature</li>
                     <li>Religion and War on Terror</li>
                     <li>The role of Religion in Poetry and Literature</li>
                     <li>Religion and Morality</li>
                   </ul>
                  {{-- <ul style="list-style-type: disc">
                    <li>Religion, Culture and Education</li>
                  </ul> --}}
                  <h4 class="mb-2">Department of Education</h4>
                  <ul style="list-style-type: disc">
                    <li>STEAM Education and its applications</li>
                    <li>Challenges in application of digital tools</li>
                    <li>Assessment in online/distance learning </li>
                    <li>E-Learning</li>
                    <li>Hybrid Learning</li>
                    <li>Distance Learning</li>
                    <li>Digital Learning</li>
                  </ul>
                  <h4 class="mb-2">Department of Islamic and Arabic Studies</h4>
                  <ul style="list-style-type: disc">
                     <li>The Social Impacts of Religion</li>
                     <li>Religion and Gender Studies</li>
                     <li>Religion and Social Tolerance</li>
                     <li>Islam is a religion for Peace</li>
                     <li>Inter-faith Dialogue: Needs and Importance</li>
                     <li>Relationship between Religion and Science</li>
                     <li>Function of Religion and Education</li>
                   </ul>
            </div>

            </section>


         </div>

         <div class="tab-pane fade" id="pills-day-5" role="tabpanel" aria-labelledby="pills-day-5-tab" tabindex="0">
            <section>
            <div class="container">
              <div class="section-math col-xl-12 m-2 " >
                  <h4 class="mb-2">Department of Mathematics</h4>
                  <ul style="list-style-type: disc">
                    <li>Fluid Dynamics</li>
                    <li>Numerical Analysis</li>
                    <li>Mathematical Modelling in Fuzzy Logic</li>
                    <li>Fractional Differential Equation</li>
                    <li>Hybrid Nano Fluids</li>
                  </ul>
            </div>

            </section>


         </div>

        </div></div></div></div></div>
           {{-- <div class=" text-center py-3">
              <button class="custom-btn schedule-btn">Download</button>
           </div> --}}
           {{-- <div class="dots img-moving-anim1">
              <img src="front/coreui/assets/img/dots/dots2.png" alt="Shadow Image">
           </div> --}}
        </div>
     </div>
        </div>
     </div>
</div>

@endsection
