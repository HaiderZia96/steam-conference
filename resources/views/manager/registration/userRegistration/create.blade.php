@extends('manager.layouts.app')
@section('page_title')
    {{(!empty($page_title) && isset($page_title)) ? $page_title : ''}}
@endsection
@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('manager/select2/dist/css/select2.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('manager/select2/dist/css/select2-bootstrap5.min.css') }}" rel="stylesheet"/>
@endpush
@section('content')
    <div class="card mt-3">
        <div class="card-body">
            {{-- Start: Page Content --}}
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">{{(!empty($p_title) && isset($p_title)) ? $p_title : ''}}</h4>
                    <div
                        class="small text-medium-emphasis">{{(!empty($p_summary) && isset($p_summary)) ? $p_summary : ''}}</div>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    @can('manager_registration_user-registration-list')
                        <a href="{{(!empty($url) && isset($url)) ? $url : ''}}"
                           class="btn btn-sm btn-primary">{{(!empty($url_text) && isset($url_text)) ? $url_text : ''}}</a>
                    @endcan
                </div>
            </div>
            <hr>
            {{-- Start: Form --}}
            <form method="{{$method}}" action="{{$action}}" enctype="{{$enctype}}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="title">Title *</label>
                    <select class="select2-options-title form-control @error('title') is-invalid @enderror"
                            name="title">
                        <option value="">Please Select</option>
                        <option value="Mr">Mr.</option>
                        <option value="Ms">Ms.</option>
                        <option value="Dr">Dr.</option>
                    </select>
                    @error('title')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="name">Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                           placeholder="Name" value="{{old('name')}}">
                    @error('name')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email *</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                           id="email" placeholder="Email" value="{{old('email')}}">
                    @error('email')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password *</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                           id="password" placeholder="Password" value="{{old('password')}}">
                    @error('password')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="contact_no">Contact No *</label>
                    <input type="text" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no"
                           id="contact_no"
                           placeholder="Contact No" value="{{old('contact_no')}}">
                    @error('contact_no')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="qualification">Qualification *</label>
                    <input type="text" class="form-control @error('qualification') is-invalid @enderror"
                           name="qualification" id="qualification" placeholder="Qualification"
                           value="{{old('qualification')}}">
                    @error('qualification')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="payment">Payment Type *</label>
                    <select class="form-control select2-options-payment-id  @error('payment') is-invalid @enderror"
                            name="payment"></select>
                    @error('payment')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="registration">Registration Type *</label>
                    <select
                        class="form-control select2-options-registration-id  @error('registration') is-invalid @enderror"
                        name="registration"></select>
                    @error('registration')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="country">Country *</label>
                    <select class="form-control select2-options-country-id  @error('country') is-invalid @enderror"
                            name="country"></select>
                    @error('country')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="state">State *</label>
                    <select class="form-control select2-options-state-id @error('state') is-invalid @enderror"
                            name="state"></select>
                    @error('state')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="city">City *</label>
                    <select class="form-control select2-options-city-id @error('city') is-invalid @enderror"
                            name="city"></select>
                    @error('city')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <button type="submit" class="btn btn-sm btn-success">Submit</button>
            </form>
            {{-- End: Form --}}
            {{-- Page Description : Start --}}
            @if(!empty($p_description) && isset($p_description))
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 mb-sm-2 mb-0">
                            <p>{{(!empty($p_description) && isset($p_description)) ? $p_description : ''}}</p>
                        </div>
                    </div>
                </div>
            @endif
            {{-- Page Description : End --}}
            {{-- End: Page Content --}}
        </div>
    </div>
@endsection
@push('footer-scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('manager/select2/dist/js/select2.js') }}"></script>

    <script>
        //Slugify
        function slugify(text) {
            return text
                .normalize('NFD')           // The normalize() method returns the Unicode Normalization Form of a given string.
                .toLowerCase()              // Convert the string to lowercase letters
                .toString()                 // Cast to string
                .trim()                     // Remove whitespace from both sides of a string
                .replace(/ /g, '-')         // Replace space with -
                .replace(/[^\w-]+/g, '')    // Remove all non-word chars
                .replace(/\-\-+/g, '-')     // Replace multiple - with single -
                .replace(/_+/g, '');           // Replace multiple _ with single empty space
        }

        function listingslug(text) {
            $('#slug').val(slugify(text));
        }

        $(document).ready(function () {

            $('.select2-options-title').select2({
                theme: "bootstrap5",
                placeholder: 'Select Title',
            });


            //Select Registration Type
            $('.select2-options-registration-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Registration Type',
                allowClear: true,
                ajax: {
                    url: '{{route('manager.get.registration-type-select')}}',
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

            //Select Payment Type
            $('.select2-options-payment-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Payment Type',
                allowClear: true,
                ajax: {
                    url: '{{route('manager.get.payment-type-select')}}',
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
            //Select Country
            $('.select2-options-country-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Country',
                allowClear: true,
                ajax: {
                    url: '{{route('manager.get.country-select')}}',
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

            //By Default Shows Select State
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
                    ajax: {
                        url: '{{route('manager.get.state-select')}}',
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

                $(".select2-options-state-id").on("select2:unselecting", function (e) {
                    selectRange()
                })
            });

            //By Default Shows Select City
            $('.select2-options-city-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select City',
            });
            //On Changing Country Populates States
            $('.select2-options-country-id, .select2-options-state-id').change(function () {
                let countryId = $('.select2-options-country-id').val(); // Get the selected country ID
                let stateId = $('.select2-options-state-id').val(); // Get the selected state ID

                if (countryId && stateId) {
                    // Both country and state are selected, proceed to fetch cities
                    $('.select2-options-city-id').empty();

                    // Select City
                    $('.select2-options-city-id').select2({
                        theme: "bootstrap5",
                        placeholder: 'Select City',
                        ajax: {
                            url: '{{ route('manager.get.city-select') }}',
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                var query = {
                                    q: params.term,
                                    type: 'public',
                                    _token: '{{ csrf_token() }}',
                                    countryId: countryId,
                                    stateId: stateId,
                                };
                                return query;
                            },
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        return {
                                            id: item.id,
                                            text: item.name
                                        };
                                    })
                                };
                            },
                            cache: true
                        }
                    }).trigger('change.select2');
                }

                $(".select2-options-city-id").on("select2:unselecting", function (e) {
                    selectRange()
                })
            });

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });
        });

    </script>
    <script>
        $(document).ready(function () {
            // Initialize Select2 for both dropdowns
            $('#payment').select2();
            $('#submission').select2();

            // Initially disable the second dropdown
            $('#submission').prop('disabled', true);

            // Listen for changes in the first dropdown
            $('#payment').on('change', function () {
                var selectedValue = $(this).val();

                // Enable or disable the second dropdown based on the selected value
                if (selectedValue === 'enable') {
                    $('#submission').prop('disabled', false);
                } else {
                    $('#submission').prop('disabled', true);
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
