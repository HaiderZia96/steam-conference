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
                    @can('manager_master-data_faculty-list')
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
                        <label class="form-label" for="name">Name *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                               id="name" onkeyup="listingslug(this.value)" placeholder="Name"
                               value="{{(isset($data) ? $data->name : old('name'))}}">
                        @error('name')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="slug">Slug</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" name="slug"
                               id="slug" placeholder="Slug" value="{{(isset($data) ? $data->slug : old('slug'))}}">
                        @error('slug')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="faculty">Faculty *</label>
                        <select
                            class="form-control select2-options-faculty-id  @error('faculty') is-invalid @enderror"
                            name="faculty"></select>
                        @error('faculty')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-sm btn-success">Submit</button>
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
            //Get Faculty
            let faculty = [{
                id: "{{$data['faculties']['id']}}",
                text: "{{$data['faculties']['name']}}",
            }];
            $(".select2-options-faculty-id").select2({
                data: faculty,
                theme: "bootstrap5",
                placeholder: 'Select Faculty',
            });
            //Select Faculty
            $('.select2-options-faculty-id').select2({
                theme: "bootstrap5",
                placeholder: 'Select Faculty',
                allowClear: true,
                ajax: {
                    url: '{{route('manager.get.faculty-select')}}',
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
