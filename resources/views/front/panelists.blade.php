@section('title', 'International Linkages Conference')
@extends('front.layouts.app')
@section('content')

    <section class="mb-4">
        <div class="container" >
            <div class="section-conference-chair m-2 " >
                <div class="conference-chair-wrap" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="title mb-4">
                        Panelists
                    </h1>

                    {{-- <h3 class="title-dept text-center mb-4">
                       Department of Arabic & Islamic Studies
                      </h3> --}}
                    <div class="row justify-content-center">
                        <div class="col-sm-12" data-aos="fade-right" data-aos-duration="800">
                            <div class="conference-chair-item">

                                <div class="card mb-3">
                                    <div class="row g-0">
                                        <div class="col-md-12">
                                            <div class="name-designation text-center">
                                                <img src="front/coreui/assets/img/conference/azeem.jpeg" class="img-fluid avatar">
                                                <h5 class="card-title mt-3">Muhammad Fauz ul Azeem</h5>
                                                <p class="card-text">General Manager,
                                                    Corporate Sustainability & Chemical Management
                                                    Interloop Pvt Ltd</p></div>
                                        </div>
                                        {{-- <div class="col-md-6">

                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

{{--                <div class="shape">--}}
{{--                    <img src="front/coreui/assets/img/shape/1.svg" alt="Shadow">--}}
{{--                </div>--}}

            </div>
        </div>
    </section>
@endsection
