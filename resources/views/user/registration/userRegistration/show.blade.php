@extends('manager.layouts.app')
@section('page_title')
    {{(!empty($page_title) && isset($page_title)) ? $page_title : ''}}
@endsection
@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('manager/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('manager/select2/dist/css/select2-bootstrap5.min.css') }}" rel="stylesheet" />

@endpush
@section('content')
    <div class="card mt-3">
        <div class="card-body">
            {{-- Start: Page Content --}}
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="card-title mb-0">{{(!empty($p_title) && isset($p_title)) ? $p_title : ''}}</h4>
                    <div class="small text-medium-emphasis">{{(!empty($p_summary) && isset($p_summary)) ? $p_summary : ''}}</div>
                </div>
                <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                    @can('manager_registration_user-registration-list')
                        <a href="{{(!empty($url) && isset($url)) ? $url : ''}}" class="btn btn-sm btn-primary">{{(!empty($url_text) && isset($url_text)) ? $url_text : ''}}</a>
                    @endcan
                </div>
            </div>
            <hr>
            {{-- Start: Form --}}
            <form method="{{$method}}" action="{{$action}}" enctype="{{$enctype}}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" disabled class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Name" value="{{(isset($data) ? $data->name : old('name'))}}">
                    @error('name')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="text" disabled class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" value="{{(isset($data) ? $data->email : old('email'))}}">
                    @error('email')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input type="text" disabled class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password" value="{{(isset($data) ? $data->password : old('password'))}}">
                    @error('password')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="contact_no">Contact No</label>
                    <input type="text" disabled class="form-control @error('contact_no') is-invalid @enderror" name="contact_no" id="contact_no" placeholder="Contact No" value="{{(isset($data) ? $data->contact_no : old('contact_no'))}}">
                    @error('contact_no')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="qualification">Qualification</label>
                    <input type="text" disabled class="form-control @error('qualification') is-invalid @enderror" name="qualification" id="qualification" placeholder="Qualification" value="{{(isset($data) ? $data->qualification : old('qualification'))}}">
                    @error('qualification')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" disabled class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Title" value="{{(isset($data) ? $data->title : old('title'))}}">
                    @error('title')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="session">Session</label>
                    <select disabled class="select2-options-session-id form-control @error('session') is-invalid @enderror" name="session"></select>
                    @error('session')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="payment">Payment Type</label>
                    <select disabled class="select2-options-payment-id form-control @error('payment') is-invalid @enderror" name="payment"></select>
                    @error('payment')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="registration">Registration Type</label>
                    <select disabled class="select2-options-registration-id form-control @error('registration') is-invalid @enderror" name="registration"></select>
                    @error('registration')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="country">Country</label>
                    <select disabled class="select2-options-country-id form-control @error('country') is-invalid @enderror" name="country"></select>
                    @error('country')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="state">State</label>
                    <select disabled class="select2-options-state-id form-control @error('state') is-invalid @enderror" name="state"></select>
                    @error('state')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="city">City</label>
                    <select disabled class="select2-options-city-id form-control @error('city') is-invalid @enderror" name="city"></select>
                    @error('city')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="registration-status">Registration Status</label>
                    <select disabled class="select2-options-registration-status-id form-control @error('registration-status') is-invalid @enderror" name="registration-status"></select>
                    @error('registration-status')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
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
    <script src="{{ asset('manager/select2/dist/js/select2.js') }}"></script>
    <script>
        $(document).ready(function() {
            //Get Session
            let session=[{
                id: "{{$data['session_id']}}",
                text: "{{$data['session_name']}}",
            }];
            $(".select2-options-session-id").select2({
                data: session,
                theme: "bootstrap5",
                placeholder: 'Select Session',
            });
            //Select Session
            $('.select2-options-session-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Session',
                ajax: {
                    url: '{{route('manager.get.session-select')}}',
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    data: function (params){
                        var query = {
                            q: params.term,
                            type: 'public',
                            _token: '{{csrf_token()}}'
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
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
            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

            //Get Payment Type
            let payment=[{
                id: "{{$data['payment_id']}}",
                text: "{{$data['payment_name']}}",
            }];
            $(".select2-options-payment-id").select2({
                data: payment,
                theme: "bootstrap5",
                placeholder: 'Select Payment Type',
            });
            //Select Payment Type
            $('.select2-options-payment-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Payment Type',
                ajax: {
                    url: '{{route('manager.get.payment-type-select')}}',
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    data: function (params){
                        var query = {
                            q: params.term,
                            type: 'public',
                            _token: '{{csrf_token()}}'
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
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

            //Get Registration Type
            let registration=[{
                id: "{{$data['registration_id']}}",
                text: "{{$data['registration_name']}}",
            }];
            $(".select2-options-registration-id").select2({
                data: registration,
                theme: "bootstrap5",
                placeholder: 'Select Registration Type',
            });
            //Select Registration Type
            $('.select2-options-registration-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Registration Type',
                ajax: {
                    url: '{{route('manager.get.registration-type-select')}}',
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    data: function (params){
                        var query = {
                            q: params.term,
                            type: 'public',
                            _token: '{{csrf_token()}}'
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
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

            //Get Country
            let country=[{
                id: "{{$data['country_id']}}",
                text: "{{$data['country_name']}}",
            }];
            $(".select2-options-country-id").select2({
                data: country,
                theme: "bootstrap5",
                placeholder: 'Select Country',
            });
            //Select Country
            $('.select2-options-country-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Country',
                ajax: {
                    url: '{{route('manager.get.country-select')}}',
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    data: function (params){
                        var query = {
                            q: params.term,
                            type: 'public',
                            _token: '{{csrf_token()}}'
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
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

            //Get State
            let state=[{
                id: "{{$data['state_id']}}",
                text: "{{$data['state_name']}}",
            }];
            $(".select2-options-state-id").select2({
                data: state,
                theme: "bootstrap5",
                placeholder: 'Select State',
            });
            //Select State
            $('.select2-options-state-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select State',
                ajax: {
                    url: '{{route('manager.get.state-select')}}',
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    data: function (params){
                        var query = {
                            q: params.term,
                            type: 'public',
                            _token: '{{csrf_token()}}'
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
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

            //Get City
            let city=[{
                id: "{{$data['city_id']}}",
                text: "{{$data['city_name']}}",
            }];
            $(".select2-options-city-id").select2({
                data: city,
                theme: "bootstrap5",
                placeholder: 'Select City',
            });
            //Select City
            $('.select2-options-city-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select City',
                ajax: {
                    url: '{{route('manager.get.city-select')}}',
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    data: function (params){
                        var query = {
                            q: params.term,
                            type: 'public',
                            _token: '{{csrf_token()}}'
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
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

            //Get Registration Status
            let registration_status=[{
                id: "{{$data['registration_status_id']}}",
                text: "{{$data['registration_status_name']}}",
            }];
            $(".select2-options-registration-status-id").select2({
                data: registration_status,
                theme: "bootstrap5",
                placeholder: 'Select Registration Status',
            });
            //Select Registration Status
            $('.select2-options-registration-status-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Registration Status',
                ajax: {
                    url: '{{route('manager.get.registration-status-select')}}',
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    data: function (params){
                        var query = {
                            q: params.term,
                            type: 'public',
                            _token: '{{csrf_token()}}'
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results:  $.map(data, function (item) {
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

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
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
