@section('title', 'International Linkages Conference')
@extends('front.layouts.app')
@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('manager/select2/dist/css/select2.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('manager/select2/dist/css/select2-bootstrap5.min.css') }}" rel="stylesheet"/>
@endpush
@section('content')
<div class="section-registration" style="background-color:#f8f9fa ">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="left-content">
                    <h1 class="mb-4">Registration</h1>
                    <div class="registration-form">
                        <form class="mt-5" action="{{ route('registration-store') }}" method="POST"
                        enctype="multipart/form-data">
                            @csrf
                            <div class="row {{ isset($registered) ? 'disables-from-fields' : '' }}">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title *</label>
                                        <select class="form-control" id="title" name="title">
                                            <option value="Mr">Mr.</option>
                                            <option value="Ms">Ms.</option>
                                            <option value="Dr">Dr.</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Full Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               name="name"
                                               value="{{(isset($registered->name))?$registered->name:old('name')}}" placeholder="Enter Name">
                                        @error('name')
                                        <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                               name="email"
                                               value="{{(isset($registered->email))?$registered->email:old('email')}}" placeholder="Enter Email">
                                        @error('email')
                                        <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password *</label>
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" placeholder="Enter Password">
                                        @error('password')
                                        <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="contact_no" class="form-label">Contact No *</label>
                                        <input type="text"
                                               class="form-control @error('contact_no') is-invalid @enderror"
                                               name="contact_no"
                                               value="{{(isset($registered->contact_no))?$registered->contact_no:old('contact_no')}}" placeholder="Enter Contact No.">
                                        @error('contact_no')
                                        <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="qualification" class="form-label">Qualification *</label>
                                    <input type="text" class="form-control" id="qualification"
                                           aria-describedby="emailHelp" placeholder="Enter Qualification"
                                           name="qualification">
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="country">Country *</label>
                                        <select
                                            class="form-control select2-options-country-id  @error('country') is-invalid @enderror"
                                            name="country"></select>
                                        @error('country')
                                        <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="state">State *</label>
                                        <select
                                            class="form-control select2-options-state-id  @error('state') is-invalid @enderror"
                                            name="state"></select>
                                        @error('state')
                                        <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="city">City *</label>
                                        <select
                                            class="form-control select2-options-city-id  @error('city') is-invalid @enderror"
                                            name="city"></select>
                                        @error('city')
                                        <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="registration">Registration Type *</label>
                                        <select
                                            class="form-control select2-options-registration-id  @error('registration') is-invalid @enderror"
                                            name="registration" id="registration"></select>
                                        @error('registration')
                                        <strong class="text-danger">{{ $message }}</strong>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="payment">Payment Type *</label>
                                        <select
                                            class="form-control select2-options-payment-id  @error('payment') is-invalid @enderror"
                                            name="payment" id="payment"></select>
                                        @error('payment')
                                        <strong class="text-danger">{{ $message }}</strong>
                                        @enderror

                                    </div>
                                </div>




                                <div class="col-md-6 ">
                                    <div class="my-4 py-2">
                                        @if(!isset($registered))
                                            <button type="submit" class="btn btn-primary float-end submit-info-btn">
                                                Register Now
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                         <!-- popup 2 -->
                         <div class="modal fade" id="popup-modal-2" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header" style="background: linear-gradient(97.14deg, #7579FF 7.11%, #B224EF 97.04%);height: 50px">
                                </div>
                                <div class="modal-body" style="padding: 0px">
                                    <div id="carouselExampleSlidesOnly" class="carousel Model_slide"
                                         data-ride="carousel">
                                        <div class="carousel-inner">
                                            <div class="carousel-item active py-5 px-3">
                                                <p style="font-family: Outfit-Regular"><b class="text-danger">Note:</b> You can register as a Walk-in
                                                    candidate on Conference
                                                    day.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    {{-- <div class="table-responsive">
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="3">1st DAY OF CONFERENCE</th>
                            </tr>
                            <tr>
                                <th class="fee-width" scope="col">Registration Fee</th>
                                <th scope="col">Earlybird<br> Registration</th>
                                <th scope="col">On-sight<br> Registration</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row">TUF Students</td>
                                <td>PKR 1000</td>
                                <td>PKR 2000</td>
                            </tr>
                            <tr>
                                <td scope="row">External Attendees (Online)</td>
                                <td>PKR 2000</td>
                                <td>PKR 3000</td>
                            </tr>
                            <tr>
                                <td scope="row">External Attendees (On-sight)</td>
                                <td>PKR 3000</td>
                                <td>PKR 4000</td>
                            </tr>
                            <tr>
                                <td scope="row">Emerging Scientists/Researchers/Scholars</td>
                                <td>PKR 5000</td>
                                <td>PKR 6000</td>
                            </tr>
                        </tbody>
                    </table>
                    </div> --}}
                    <div class="table-responsive mt-5">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th class="text-center" colspan="3">Bank Details</th>
                                </tr>
                                <tr>
                                    <th class="fee-width" scope="col" >Title</th>
                                    <th scope="col">Details</th>
                                    {{-- <th scope="col">On-sight<br> Registration</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Branch Name</th>
                                    <td>University Faisalabad Branch</td>
                                    {{-- <td>PKR 2000</td> --}}
                                </tr>
                                <tr>
                                    <th scope="row">Account Number</th>
                                    <td>6-12-08-20311-714-100031</td>
                                    {{-- <td>PKR 3500</td> --}}
                                </tr>
                                <tr>
                                    <th scope="row">IBAN</th>
                                    <td>PK32MPBL1208027140100031</td>
                                    {{-- <td>PKR 4500</td> --}}
                                </tr>
                            </tbody>
                        </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="section-fee col-xl-12 m-2 mb-5">
           {{-- <span class="label">Welcome to International Conference 2023</span> --}}

           <h4 class="title my-4">
           Registration Fee Includes:
           </h4>
           <ul>
            <li>Conference badges to attend the entire day conference</li>
            <li>Conference bag with abstract book and all the required stationary item</li>
            <li>Certificates for participation</li>
           </ul>

        </div>
     </div>
     <div class="container">
        <div class="section-fee col-xl-12 m-2 mb-5">
           {{-- <span class="label">Welcome to International Conference 2023</span> --}}
           <h4 class="title my-4">
            Paper Submission:
           </h4>
           <p style="font-size: 18px;font-family: Outfit-Regular;
           color: #797979;">For paper submission, go to this link:</p>
           <a href="https://easychair.org/conferences/?conf=icase2023" style="font-size: 18px;font-family: Outfit-Bold;
           color: #797979;">https://easychair.org/conferences/?conf=icase2023</a>

        </div>
     </div>
</div>

@endsection
@push('footer-scripts')

    <script src="{{ asset('manager/select2/dist/js/select2.js') }}"></script>

    <script>
        $(document).ready(function () {

            $('.select2-options-title').select2({
                theme: "bootstrap5",
                placeholder: 'Select Title',
            });


            // Select Registration Type
        $('.select2-options-registration-id').select2({
        theme: "bootstrap5",
        placeholder: 'Select Registration Type',
        allowClear: true,
        ajax: {
        url: '{{ route('get.registration-type-select') }}',
        dataType: 'json',
        delay: 250,
        type: 'GET',
        data: function (params) {
            var query = {
                q: params.term,
                type: 'public',
                _token: '{{ csrf_token() }}'
            }
            return query;
        },
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name
                    }
                })
            };
        },
        cache: true
        }
        }).trigger('change.select2');

        //By Default Shows Select Payment Type
        $('.select2-options-payment-id').select2({
                        theme: "bootstrap5",
                        placeholder: 'Select Payment Type',
                    });

        $('.select2-options-registration-id').change(function () {
                let registrationId = $(this).val();
                $('.select2-options-payment-id').empty()
        // Select Payment Type
        $('.select2-options-payment-id').select2({
        theme: "bootstrap5",
        placeholder: 'Select Payment Type',
        allowClear: true,
        ajax: {
        url: '{{ route('get.payment-type-select') }}',
        dataType: 'json',
        delay: 250,
        type: 'GET',
        data: function (params) {
            var query = {
                q: params.term,
                type: 'public',
                registration_type: $('.select2-options-registration-id').val(), // Assuming you have an input with the registration type ID
                _token: '{{ csrf_token() }}',
                registrationId: registrationId,
            }
            return query;
        },
        processResults: function (data) {
            // Filter payment types based on registration type 1
            if ($('.select2-options-registration-id').val() === '2') {
                data = data.filter(function (item) {
                    return item.id === 1; // Display only payment type ID 1
                });
            }

            return {
                results: $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.name
                    }
                })
            };
        },
        cache: true
        }
        }).trigger('change.select2');});


            //Select Country
            $('.select2-options-country-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Country',
                allowClear: true,
                ajax: {
                    url: '{{route('get.countries-select')}}',
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    data: function (params) {
                        var query = {
                            q: params.term,
                            type: 'public',
                            _token: '{{csrf_token()}}'
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            })
                        };
                    },
                    cache: true
                }
            }).trigger('change.select2')

            //By Default Shows Select States
            $('.select2-options-state-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select States',
            });

            //On Changing Country Populates States
            $('.select2-options-country-id').change(function () {
                let countryId = $(this).val();
                $('.select2-options-state-id').empty()
                //Select States
                $('.select2-options-state-id').select2({
                    theme: "bootstrap5",
                    placeholder: 'Select States',
                    allowClear: true,
                    ajax: {
                        url: '{{route('get.states-select')}}',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            var query = {
                                q: params.term,
                                type: 'public',
                                _token: '{{csrf_token()}}',
                                countryId: countryId,
                            }
                            return query;
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        id: item.id,
                                        text: item.name
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                }).trigger('change.select2');

                // $(".select2-options-state-id").on("select2:unselecting", function (e) {
                //     selectRange()
                // })
            });

            //By Default Shows Select Cities
            $('.select2-options-city-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select City',
            });

            //On Changing Country and States Populates Cities
            $('.select2-options-country-id,.select2-options-state-id').change(function () {
                let countryId = $('.select2-options-country-id').val();
                let stateId = $('.select2-options-state-id').val();


                $('.select2-options-city-id').empty()

                //Select States
                $('.select2-options-city-id').select2({
                    theme: "bootstrap5",
                    placeholder: 'Select City',
                    allowClear: true,
                    ajax: {
                        url: '{{route('get.cities-select')}}',
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            var query = {
                                q: params.term,
                                type: 'public',
                                _token: '{{csrf_token()}}',
                                countryId: countryId,
                                stateId: stateId,
                            }


                            return query;
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        id: item.id,
                                        text: item.name
                                    }
                                })
                            };
                        },
                        cache: true
                    }
                }).trigger('change.select2');

                // $(".select2-options-city-id").on("select2:unselecting", function (e) {
                //     selectRange()
                // })
            });


            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });
        });
    </script>
    {{-- <script>
        $(document).ready(function () {
            $('#payment').change(function () {
                let data = $(this).val();
                if (data === "2") {
                    $(document).ready(function () {
                        $("#popup-modal-2").modal('show');
                        $('.submit-info-btn').addClass('d-none')
                    });
                } else {
                    $('.submit-info-btn').removeClass('d-none')
                }

            });
        });
    </script> --}}
    <script>
        $(document).ready(function () {
            // Assuming registration field has ID 'registration' and payment field has ID 'payment'
            $('#registration, #payment').change(function () {
                let registrationValue = $('#registration').val();
                let paymentValue = $('#payment').val();

                if (registrationValue === "1" && paymentValue === "2") {
                    $("#popup-modal-2").modal('show');
                    $('.submit-info-btn').addClass('d-none');
                } else {
                    $("#popup-modal-2").modal('hide'); // Hide the modal if conditions are not met
                    $('.submit-info-btn').removeClass('d-none');
                }
            });
        });
    </script>


    {{-- Toastr : Script : Start --}}
    @if(Session::has('messages'))
        <script>
            noti({!! json_encode((Session::get('messages'))) !!});
        </script>
    @endif

    {{-- Toastr : Script : End --}}
@endpush
