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
                    @can('manager_session-settings_venue-list')
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
                <div class="mb-3">
                    <label class="form-label" for="Session">Conference Year</label>
                    <select disabled class="form-control @error('conference_year_id') is-invalid @enderror"
                            name="conference_year_id">
                        @if(isset($conference_year))
                            <option value="{{$conference_year->id}}">{{$conference_year->name}}</option>
                        @endif
                    </select>
                    @error('conference_year_id')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="location">Title</label>
                    <input type="text" disabled class="form-control @error('title') is-invalid @enderror" name="title"
                           id="title" placeholder="Location"
                           value="{{(!empty($data->title) && isset($data->title)) ? $data->title : old('title')}}">
                    @error('title')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="start_time">Start Time</label>
                    <input type="time" disabled class="form-control @error('start_time') is-invalid @enderror"
                           name="start_time"
                           id="start_time" placeholder="Time"
                           value="{{(!empty($data->start_time) && isset($data->start_time)) ? $data->start_time : old('start_time')}}">
                    @error('start_time')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="event_date">Event Date</label>
                    <input type="date" disabled class="form-control @error('event_date') is-invalid @enderror"
                           name="event_date"
                           id="event_date" placeholder="Date"
                           value="{{(!empty($data->event_date) && isset($data->event_date)) ? $data->event_date : old('event_date')}}">
                    @error('event_date')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="location">Location</label>
                    <input type="text" disabled class="form-control @error('location') is-invalid @enderror" name="location"
                           id="location" placeholder="Location"
                           value="{{(!empty($data->location) && isset($data->location)) ? $data->location : old('location')}}">
                    @error('event_date')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="location">MAP <small>(longitude and latitude)</small> </label>
                    <input type="text" disabled class="form-control @error('map') is-invalid @enderror" name="map"
                           id="map" placeholder="31.496232448935384, 73.0737773846565"
                           value="{{(!empty($data->map) && isset($data->map)) ? $data->map : old('map')}}">
                    @error('map')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="location">Description</label>
                    <textarea rows="3" disabled class="form-control @error('description') is-invalid @enderror"
                              name="description"
                              id="description" placeholder="Description">{{(!empty($data->description) && isset($data->description)) ? $data->description : old('description')}}</textarea>
                    @error('description')
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
        $(document).ready(function () {
            //Get Module

            let module = [{
                id: "{{$data['s_id']}}",
                text: "{{$data['s_name']}}",
            }];
            $(".select2-options-module-id").select2({
                data: module,
                theme: "bootstrap5",
                placeholder: 'Select Session',
            });
            //Select Module
            $('.select2-options-module-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Session',
                ajax: {
                    url: '{{route('manager.get.conference-year-select')}}',
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
            //Select Status
            $('.select2-options-campus').select2({
                theme: "bootstrap5",
                placeholder: 'Select Status',
            });
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
