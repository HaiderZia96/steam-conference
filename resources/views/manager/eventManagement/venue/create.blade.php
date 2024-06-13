@extends('manager.layouts.app')
@section('page_title')
    {{(!empty($page_title) && isset($page_title)) ? $page_title : ''}}
@endsection
@push('head-scripts')
    <link href="{{ asset('manager/select2/dist/css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('manager/select2/dist/css/select2-bootstrap5.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('manager/cropper/cropper.min.css') }}" rel="stylesheet"/>
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
                    <button type="button" class="btn btn-sm btn-secondary d-none" id="single-entry">Single Entry
                    </button>
                    @can('manager_event_settings-venue-list')
                        <a href="{{(!empty($url) && isset($url)) ? $url : ''}}"
                           class="btn btn-sm btn-primary">{{(!empty($url_text) && isset($url_text)) ? $url_text : ''}}</a>
                    @endcan
                </div>
            </div>
            <hr>
            {{-- Start: Form --}}
            <div class="single-box">
                <form method="{{$method}}" action="{{$action}}" enctype="{{$enctype}}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="Session">Conference Year</label>
                        <select class="form-control session-readonly @error('conference_year_id') is-invalid @enderror"
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
                        <label class="form-label" for="location">Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                               id="title" placeholder="Title" value="{{old('title')}}">
                        @error('title')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="start_time">Start Time *</label>
                        <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                               name="start_time"
                               id="start_time" placeholder="Time" value="{{old('start_time')}}">
                        @error('start_time')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="event_date">Event Date *</label>
                        <input type="date" class="form-control @error('event_date') is-invalid @enderror"
                               name="event_date"
                               id="event_date" placeholder="Date" value="{{old('event_date')}}">
                        @error('event_date')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="location">Location *</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" name="location"
                               id="location" placeholder="Location" value="{{old('location')}}">
                        @error('location')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="location">MAP <small>(longitude and latitude) *</small> </label>
                        <input type="text" class="form-control @error('map') is-invalid @enderror" name="map"
                               id="map" placeholder="31.496232448935384, 73.0737773846565" value="{{old('map')}}">
                        @error('map')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="location">Description *</label>
                        <textarea rows="3" class="form-control @error('description') is-invalid @enderror"
                                  name="description"
                                  id="description" placeholder="Description">{{old('map')}}</textarea>
                        @error('description')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                </form>
            </div>
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
    {{-- Toastr : Script : Start --}}
    @if(Session::has('messages'))
        <script>
            noti({!! json_encode((Session::get('messages'))) !!});
        </script>
    @endif
    {{-- Toastr : Script : End --}}
@endpush
