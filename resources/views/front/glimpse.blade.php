@section('title', 'International Linkages Conference')
@extends('front.layouts.app')
@section('content')
    <section>
        <div class="container" >
            <div class="section-conference-chair m-2" >
                <div class="conference-chair-wrap" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="title mb-4">
                        Glimpses
                    </h1>

                    {{-- Modal : Start --}}
                    <div class="modal fade" id="glimpseModal" tabindex="-1" aria-labelledby="glimpseModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered rounded-1">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <button type="button" class="btn-close float-end mb-2" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    <img class="img-fluid" id="modalImage" src="" alt="Image not uploaded">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Modal : End --}}

                    {{-- Gallery : End --}}
                    <div class="row g-3 mb-4">
                        @foreach($glimpses as $glimpse)
                            <div class="col-lg-4 col-md-6 glimpse-gallery">
                                <a href="#" class="glimpse-img" data-bs-toggle="modal" data-bs-target="#glimpseModal"
                                   data-src="{{route('get-image.glimpse',$glimpse['id'])}}" data-title="{{$glimpse['title']}}">
                                    <img class="img-fluid" src="{{route('get-image.glimpse',$glimpse['id'])}}"
                                         alt="Glimpse"/>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    {{-- Gallery : End --}}

                </div>

                {{-- Page Links : Start --}}
                <div class="d-flex justify-content-center mb-5 glimpse-links">
                    {!! $glimpses->links() !!}
                </div>
                {{-- Page Links : End --}}
            </div>
        </div>
    </section>

@endsection
@push('footer-scripts')
    <script>
        $(document).on("click", ".glimpse-img", function () {
            var src = $(this).data('src');
            $('#modalImage').attr('src', src);
        });
    </script>
@endpush
