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
    <form method="POST" action="{{ $action }}" enctype="{{ $enctype }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label" for="attendee_status">Certificate Status</label>
        <select class="select2-options-certificate-status-id form-control @error('attendee_status') is-invalid @enderror" name="attendee_status">
            {{-- <option value="0" {{ old('attendee_status') == '0' ? 'selected' : '' }}>Not Attend</option>
            <option value="1" {{ old('attendee_status') == '1' ? 'selected' : '' }}>Attend</option> --}}
        </select>
        @error('attendee_status')
        <strong class="text-danger">{{ $message }}</strong>
        @enderror
    </div>
    <button type="submit" class="btn btn-sm btn-success">Submit</button>
</form>

            <!-- <form method="POST" action="{{ $action }}">
            @csrf
            <label for="status">Select New Status:</label>
            <select name="status" id="status">
                <option value="1">Attending</option>
                <option value="0">Not Attending</option>
        
            </select>
            <button type="submit">Update Status</button>
            </form> -->

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
            let certificate_status = [
                {
                    id: "1",
                    text: "Issue Certificate",
                },
                {
                    id: "0",
                    text: "Not Issue Certificate",
                }
            ];
    
            // Initialize Select2 with initial data
            let selectElement = $(".select2-options-certificate-status-id");
    
            selectElement.select2({
                data: certificate_status,
                theme: "bootstrap5",
                placeholder: 'Select Certificate Status',
            });
    
            // Configure Select2 for dynamic loading of options
            selectElement.select2({
                theme: "bootstrap5",
                placeholder: 'Select Certificate Status',
                ajax: {
                    url: '{{ route('manager.get.certificate-status-select') }}',
                    dataType: 'json',
                    delay: 250,
                    type: 'GET',
                    data: function (params) {
                        var query = {
                            q: params.term,
                            type: 'public',
                            _token: '{{ csrf_token() }}'
                        };
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.text
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
    
            // Set the initially selected value
            selectElement.val("{{$data['attendee_status']}}").trigger('change.select2');
    
            // Auto Focus
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
