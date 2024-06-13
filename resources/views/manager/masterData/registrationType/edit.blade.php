@extends('manager.layouts.app')
@section('page_title')
    {{(!empty($page_title) && isset($page_title)) ? $page_title : ''}}
@endsection
@push('head-scripts')

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
                    @can('manager_master-data_registration-type-list')
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
                    <label class="form-label" for="name">Name *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" onkeyup="listingslug(this.value)" placeholder="Name" value="{{(isset($data) ? $data->name : old('name'))}}">
                    @error('name')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="fee">Fee</label>
                    <input type="text" class="form-control @error('fee') is-invalid @enderror" name="fee" id="fee" placeholder="Fee" value="{{(isset($data) ? $data->fee : old('fee'))}}">
                    @error('fee')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="international-fee">International Fee</label>
                    <input type="text" class="form-control @error('international-fee') is-invalid @enderror" name="international-fee" id="international-fee" placeholder="International Fee" value="{{(isset($data) ? $data->international_fee : old('international-fee'))}}">
                    @error('international-fee')
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
                .replace(/_+/g,'');           // Replace multiple _ with single empty space
        }
        function listingslug(text) {
            $('#slug').val(slugify(text));
        }
    </script>
    {{-- Toastr : Script : Start --}}
    @if(Session::has('messages'))
        <script>
            noti({!! json_encode((Session::get('messages'))) !!});
        </script>
    @endif
    {{-- Toastr : Script : End --}}
@endpush
