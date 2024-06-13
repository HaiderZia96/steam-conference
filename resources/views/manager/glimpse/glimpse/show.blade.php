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
                    @can('manager_glimpse_faculty-list')
                        <a href="{{(!empty($url) && isset($url)) ? $url : ''}}"
                           class="btn btn-sm btn-primary">{{(!empty($url_text) && isset($url_text)) ? $url_text : ''}}</a>
                    @endcan
                </div>
            </div>
            <hr>
            {{-- Start: Form --}}
            <form method="{{$method}}" action="{{$action}}" enctype="{{$enctype}}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="title">Title *</label>
                        <input type="text" disabled class="form-control @error('title') is-invalid @enderror" name="title"
                               id="title" onkeyup="listingslug(this.value)" placeholder="Title"
                               value="{{(isset($data) ? $data->title : old('title'))}}">
                        @error('title')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="department">Department *</label>
                        <select
                            disabled class="form-control select2-options-department-id  @error('department') is-invalid @enderror"
                            id="department" name="department"></select>
                        @error('department')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="glimpse_category">Glimpse Category *</label>
                        <select
                            disabled class="form-control select2-options-glimpse-category-id  @error('glimpse_category') is-invalid @enderror"
                            id="glimpse_category" name="glimpse_category"></select>
                        @error('glimpse_category')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="glimpse_year">Glimpse Year *</label>
                        <select
                            disabled class="form-control select2-options-glimpse-year-id  @error('glimpse_year') is-invalid @enderror"
                            id="glimpse_year" name="glimpse_year"></select>
                        @error('glimpse_year')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="glimpse_day">Glimpse Day *</label>
                        <select
                            disabled class="form-control select2-options-glimpse-day-id  @error('glimpse_day') is-invalid @enderror"
                            id="glimpse_day" name="glimpse_day"></select>
                        @error('glimpse_day')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
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
        $(document).ready(function () {

            //Get Department
            let faculty = [{
                id: "{{$data['departments']['id']}}",
                text: "{{$data['departments']['name']}}",
            }];
            $(".select2-options-department-id").select2({
                data: faculty,
                theme: "bootstrap5",
                placeholder: 'Select Department',
            });
            //Select Department
            $('.select2-options-department-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Department',
                allowClear: true,
                ajax: {
                    url: '{{route('manager.get.department-select')}}',
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

            //Get Glimpse Category
            let glimpseCategory = [{
                id: "{{$data['glimpseCategories']['id']}}",
                text: "{{$data['glimpseCategories']['name']}}",
            }];
            $(".select2-options-glimpse-category-id").select2({
                data: glimpseCategory,
                theme: "bootstrap5",
                placeholder: 'Select Glimpse Category',
            });
            //Select Glimpse Category
            $('.select2-options-glimpse-category-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Glimpse Category',
                allowClear: true,
                ajax: {
                    url: '{{route('manager.get.glimpse-category-select')}}',
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

            //Get Glimpse Year
            let glimpseYear = [{
                id: "{{$data['glimpseYears']['id']}}",
                text: "{{$data['glimpseYears']['name']}}",
            }];
            $(".select2-options-glimpse-year-id").select2({
                data: glimpseYear,
                theme: "bootstrap5",
                placeholder: 'Select Glimpse Year',
            });
            //Select Glimpse Year
            $('.select2-options-glimpse-year-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Glimpse Year',
                allowClear: true,
                ajax: {
                    url: '{{route('manager.get.glimpse-year-select')}}',
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

            //Get Glimpse Day
            let glimpseDay = [{
                id: "{{$data['glimpseDays']['id']}}",
                text: "{{$data['glimpseDays']['day']}}",
            }];
            $(".select2-options-glimpse-day-id").select2({
                data: glimpseDay,
                theme: "bootstrap5",
                placeholder: 'Select Glimpse Day',
            });
            //Select Glimpse Day
            $('.select2-options-glimpse-day-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Glimpse Day',
                allowClear: true,
                ajax: {
                    url: '{{route('manager.get.glimpse-day-select')}}',
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

            //Auto Focus
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
